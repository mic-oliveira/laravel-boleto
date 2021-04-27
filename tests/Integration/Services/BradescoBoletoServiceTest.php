<?php


namespace Boleto\Tests\Integration\Services;


use Boleto\Models\Person;
use Boleto\Services\BradescoBoletoService;
use Boleto\Tests\TestCase;
use Bradesco\Services\AuthService;

class BradescoBoletoServiceTest extends TestCase
{
    private BradescoBoletoService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app()->make(BradescoBoletoService::class);
    }

    public function testCharge()
    {
        $data = [
            'bank_id' => null,
            'bank' => 'BRADESCO',
            'agency' => 3995,
            'title_number' => "2346",
            'title_type' => 2,
            'currency_code' => 9,
            'product_id' => 9,
            'client_number' => '2799',
            'partial_payment_id' => null,
            'amount_partial_payment' => 0,
            'emission_form' => 0,
            'currency_amount' => 0,
            'register_title' => 1,
            'emission_date' => '2021-02-12',
            'due_date' => '2021-02-14',
            'cpfcnpj_number' => 38052160,
            'cpfcnpj_control' => 1,
            'term_limit' => 0,
            'term_type' => 0,
            'protest_limit' => 0,
            'protest_type' => 0,
            'cpfcnpj_branch' => 57,
            'negotiation_number' => 399500000000075557,
            'iof_value' => 0,
            'nominal_value' => 15000,
            'layout_version' => 1,
            'payer' => [
                'name' => 'Natália Loren Stachechen',
                'cpf_cnpj' => 13528086921,
                'address' => [
                    'street' => 'Possídio Salomoni',
                    'complement' => null,
                    'number' => '548',
                    'neighborhood' => 'São Vicente',
                    'cep' => 85506320,
                    'city' => 'Pato Branco',
                    'UF' => 'PR'
                ],
                'phone' => [
                    'ddd' => 46,
                    'number' => 987456321
                ],
                'email' => null,
            ],
            'drawer' => [
                'name' => null,
                'cpf_cnpj' => null,
                'address' => [
                    'street' => null,
                    'complement' => null,
                    'number' => null,
                    'neighborhood' => null,
                    'cep' => null,
                    'city' => null,
                    'UF' => null
                ],
                'email' => null,
            ],
            'discounts' => [
                [
                    'value' => 0,
                    'percent' => 0,
                    'limit_date' => null
                ],
                [
                    'value' => 0,
                    'percent' => 0,
                    'limit_date' => null
                ],
                [
                    'value' => 0,
                    'percent' => 0,
                    'limit_date' => null
                ]
            ],
            'bonus' => [
                'value' => 0,
                'percent' => 0,
                'limit_date' => null
            ],
            'fine' => [
                'value' => 0,
                'percent' => 0,
                'limit_date' => null
            ],
            'fee' => [
                'value' => 0,
                'percent' => 0,
                'limit_date' => null
            ]
        ];
        //dump((new AuthService())->accessToken())
        dump($this->service->makeTemplate($data)->parse());
        // file_put_contents('parse.txt',json_encode($this->service->makeTemplate($data)->parse()));
        dump($this->service->charge($data)->getBody()->getContents());
    }

}
