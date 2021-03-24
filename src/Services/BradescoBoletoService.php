<?php

namespace Boleto\Services;

use Boleto\Models\Banks\Bradesco;
use Boleto\Repositories\Eloquent\BilletRepository;
use Boleto\Repositories\Eloquent\BonusRepository;
use Boleto\Repositories\Eloquent\DiscountRepository;
use Boleto\Repositories\Eloquent\FeeRepository;
use Boleto\Repositories\Eloquent\FineRepository;
use Boleto\Repositories\Eloquent\PersonRepository;
use BoletoInterface;
use Bradesco\Interfaces\BilletTemplateInterface;
use Bradesco\Models\Signature;
use Bradesco\Services\AuthService;
use Bradesco\Services\BilletEmissionService;
use Bradesco\Services\JWTService;
use Bradesco\Services\SignatureService;
use Exception;
use Illuminate\Support\Facades\DB;

class BradescoBoletoService extends BilletEmissionService implements BoletoInterface
{
    private Signature $signature;
    private string $jwtService;

    public function __construct(JWTService $JWTService, Signature $signature)
    {
        parent::__construct();
        $this->jwtService = $JWTService;
        $this->signature = $signature;
    }

    public function createBillet(BilletTemplateInterface $billetTemplate)
    {
        try{
            $this->makeSignature($billetTemplate->parse(),"/v1/boleto/registrarBoleto", "POST");
            $this->emit($billetTemplate);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    private function makeSignature(array $data, string $url, string $verb = null)
    {
        try{
            $token = $this->jwtService->createJWTToken(
                config('laravel-boleto.bradesco_certificate_path'),
                config('laravel-boleto.bradesco_certificate_pass')
            );
            $this->signature->setVerb($verb ?? 'POST');
            $this->signature->setAccessToken((new AuthService())->accessToken($token));
            $this->signature->setUri($url);
            $this->signature->setBody($data);
            $this->signature->setAccount(config('laravel-boleto.bradesco_account'));
            $this->signature->setAgency(config('laravel-boleto.bradesco_agency'));
            $this->signature->setNonce(now()->getPreciseTimestamp(3));
            $this->signature->setTimestamp(now()->setTimezone(-3)->toIso8601String());
            $this->signature->setBradSignature(
                SignatureService::bradRequestSignature(
                        $this->signature, config('bradesco_certificate_path', config('bradesco_certificate_pass')
                    )
                )
            );
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function makeTemplate(array $data)
    {
        return new Bradesco($this->billetFromArray($data));
    }

    public function billetFromArray(array $data)
    {
        $payer = resolve(PersonRepository::class)->createOrUpdate($data['payer']);
        $drawer = resolve(PersonRepository::class)->createOrUpdate($data['drawer']);
        $billet = resolve(BilletRepository::class)
            ->create(array_merge($data,['payer_id' => $payer->id, 'drawer_id' => $drawer->id]));
        resolve(DiscountRepository::class)->createDiscounts(array_merge($data['discounts']));
        resolve(BonusRepository::class)->create(array_merge($data['bonus'], ['billet_id' => $billet->id]));
        resolve(FineRepository::class)->create(array_merge($data['fine'], ['billet_id' => $billet->id]));
        resolve(FeeRepository::class)->create(array_merge($data['fee'], ['billet_id' => $billet->id]));
        DB::commit();
        return $billet;
    }

    public function charge(array $data)
    {
        DB::commit();
        try{
            $this->createBillet($this->makeTemplate($data));
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function updateBillet(BilletTemplateInterface $billetTemplate)
    {
        // TODO: Implement updateBillet() method.
    }

    public function cancelBillet()
    {
        // TODO: Implement cancelBillet() method.
    }
}
