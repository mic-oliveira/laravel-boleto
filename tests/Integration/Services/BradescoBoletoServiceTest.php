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
            'client_number' => '52651',
            'partial_payment_id' => 0,
            'amount_partial_payment' => 0,
            'emission_form' => 1,
            'currency_amount' => 1500,
            'register_title' => 52662,
            'emission_date' => '2021-02-12',
            'due_date' => '2021-02-14',
            'cpfcnpj_number' => 99999999999,
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
                'cpf_cnpj' => 2,
                'address' => [
                    'street' => 'Possídio Salomoni',
                    'complement' => 'casa 2',
                    'number' => 120,
                    'neighborhood' => 'São Vicente',
                    'cep' => 85506320,
                    'city' => 'Araruama',
                    'UF' => 'RJ'
                ],
                'phones' => [
                    'ddd' => 46,
                    'number' => 987456321
                ],
                'email' => null,
            ],
            'drawer' => [
                'name' => 'Cliente Teste',
                'cpf_cnpj' => 11111111111,
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
                'limit_date' => 0
            ],
            'fine' => [
                'value' => 0,
                'percent' => 0,
                'limit_date' => 0
            ],
            'fee' => [
                'value' => 0,
                'percent' => 0,
                'limit_date' => 0
            ]
        ];
        dump((new AuthService())->accessToken())
        dump($this->service->makeTemplate($data)->parse());

        // $this->assertTrue($this->service->charge($data));
    }

}
