<?php

namespace Boleto\Services;

use Boleto\Repositories\Eloquent\BilletRepository;
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
    private BilletTemplateInterface $billet;

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

    public function updateBillet(BilletTemplateInterface $billetTemplate)
    {
        // TODO: Implement updateBillet() method.
    }

    public function cancelBillet()
    {
        // TODO: Implement cancelBillet() method.
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

    public function billetFromArray(array $data)
    {
        DB::beginTransaction();
        try{

            $payer = resolve(PersonRepository::class)->createOrUpdate($data['payer']);
            $drawer = resolve(PersonRepository::class)->createOrUpdate($data['drawer']);
            $billet = resolve(BilletRepository::class)
                ->create(array_merge($data,['payer_id' => $payer->id, 'drawer_id' => $drawer->id]));

        } catch (Exception $exception) {
            DB::rollBack();
        }
    }

}
