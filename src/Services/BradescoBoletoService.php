<?php

namespace Boleto\Services;

use Boleto\Interfaces\BoletoInterface;
use Boleto\Models\Banks\Bradesco;
use Boleto\Models\Email;
use Boleto\Repositories\Eloquent\AddressRepository;
use Boleto\Repositories\Eloquent\BilletRepository;
use Boleto\Repositories\Eloquent\BonusRepository;
use Boleto\Repositories\Eloquent\DiscountRepository;
use Boleto\Repositories\Eloquent\EmailRepository;
use Boleto\Repositories\Eloquent\FeeRepository;
use Boleto\Repositories\Eloquent\FineRepository;
use Boleto\Repositories\Eloquent\PersonRepository;
use Boleto\Repositories\Eloquent\PhoneRepository;
use Bradesco\Interfaces\BilletTemplateInterface;
use Bradesco\Models\Signature;
use Bradesco\Services\AuthService;
use Bradesco\Services\BilletEmissionService;
use Bradesco\Services\JWTService;
use Bradesco\Services\SignatureService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class BradescoBoletoService extends BilletEmissionService implements BoletoInterface
{
    private JWTService $jwtService;

    public function __construct(JWTService $JWTService)
    {
        parent::__construct();
        $this->jwtService = $JWTService;
        $this->setSignature(new Signature());
    }

    public function emit(BilletTemplateInterface $billet)
    {
        return parent::emit($billet); // TODO: Change the autogenerated stub
    }

    public function createBillet(BilletTemplateInterface $billetTemplate)
    {
        DB::beginTransaction();
        try{
            $this->jwtService->setPayload([
                'sub' => config('boleto.bradesco_application_id'),
                'iat' => Carbon::now()->getPreciseTimestamp(0),
                'exp' => Carbon::now()->addMonth()->getPreciseTimestamp(0),
                'jti' => Carbon::now()->getPreciseTimestamp(3)
            ]);
            $token = $this->jwtService->createJWTToken(
                config('boleto.bradesco_certificate_path'),
                config('boleto.bradesco_certificate_pass')
            );
            cache()->has('bradesco_access_token') ? cache()->get('bradesco_access_token') :
               cache()->add('bradesco_access_token', (new AuthService())->accessToken($token),
               config('boleto.bradesco_token_ttl'));
            $this->getSignature()->setAccessToken(cache()->get('bradesco_access_token'));
            $this->makeSignature($billetTemplate->parse(),"/v1/boleto/registrarBoleto", "POST");
            $response = $this->emit($billetTemplate)->getBody()->getContents();
            $billetTemplate->getBillet()->update(['digitable_line' => json_decode($response)->linhaDigitavel]);
            $billetTemplate->getBillet()->update(['return_code' => json_decode($response)->codigoRetorno]);
            $billetTemplate->getBillet()->update(['return_message' => json_decode($response)->mensagemRetorno]);
            $billetTemplate->getBillet()->update(['bank_id' => json_decode($response)->nuTituloGerado]);
            DB::commit();
            return $response;
        } catch (Exception $exception) {
            DB::rollBack();
            $billetTemplate->getBillet()->delete();
            throw $exception;
        }
    }

    private function makeSignature(array $data, string $url, string $verb = null)
    {
        try{

            $this->getSignature()->setVerb($verb ?? 'POST');
            $this->getSignature()->setUri($url);
            $this->getSignature()->setBody($data);
            $this->getSignature()->setNonce(now()->getPreciseTimestamp(4));
            $this->getSignature()->setTimestamp(Carbon::now()->setTimezone("America/Sao_Paulo")->toIso8601String());
            $this->getSignature()->setAlgorithm('SHA256');
            $this->getSignature()->setBradSignature(
                base64_encode(SignatureService::bradRequestSignature(
                        $this->getSignature(), config('boleto.bradesco_certificate_path', config('boleto.bradesco_certificate_pass')
                    )
                ))
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
        try {
            $payer = $this->makePerson($data['payer']);
            $drawer = $this->makePerson($data['drawer']);
            $billet = resolve(BilletRepository::class)
                ->create(array_merge($data,['payer_id' => $payer->id, 'drawer_id' => $drawer->id]));
            resolve(DiscountRepository::class)->createDiscounts($data['discounts'],$billet->id);
            resolve(BonusRepository::class)->create(array_merge($data['bonus'], ['billet_id' => $billet->id]));
            resolve(FineRepository::class)->create(array_merge($data['fine'], ['billet_id' => $billet->id]));
            resolve(FeeRepository::class)->create(array_merge($data['fee'], ['billet_id' => $billet->id]));
            return $billet;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function makePerson(array $data)
    {
        $person = resolve(PersonRepository::class)->createOrUpdate($data);
        array_key_exists('email',$data) && !empty($data['email']) ? resolve(EmailRepository::class)
            ->createOrUpdate(['email' => $data['email'],'person_id' => $person->id]) : null;
        array_key_exists('phone', $data) ? resolve(PhoneRepository::class)
            ->createOrUpdate(array_merge($data['phone'], ['person_id' => $person->id])) : null;
        resolve(AddressRepository::class)
            ->createOrUpdate(array_merge($data['address'],['person_id' => $person->id]));
        return $person;
    }

    public function charge(array $data)
    {
        try{
            return $this->createBillet($this->makeTemplate($data));
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
}
