<?php

namespace Boleto\Services;

use BoletoInterface;
use Bradesco\Interfaces\BilletTemplateInterface;
use Bradesco\Models\Signature;
use Bradesco\Services\AuthService;
use Bradesco\Services\BilletEmissionService;
use Bradesco\Services\JWTService;
use Bradesco\Services\SignatureService;
use Exception;
use SignatureException;

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
            $this->signature->setBradSignature(SignatureService::requestString($this->signature));
        } catch (Exception $exception) {
            throw new SignatureException('Signature error during create.');
        }
    }
}
