<?php


namespace Boleto\Tests\Integration\Services;


use Boleto\Services\BradescoBoletoService;
use Boleto\Tests\TestCase;

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
            'bank' => 254135,
            'agency' => 65321,
            'title_number' => 85462122,
            'title_type' => 9,
            'currency_code' => 1,
            'product_id' => 9,
            'client_number' => '52651',
            'partial_payment_id' => 0,
            'amount_partial_payment' => 0,
            'emission_form' => 1,
            'currency_amount' => 1500,
            'register_title' => 52662,
            'emission_date' => '2020-01-03',
            'due_date' => now()->toDateString(),
            'cpfcnpj_number' => 99999999999,
            'term_limit' => 0,
            'term_type' => 0,
            'protest_limit' => 0,
            'protest_type' => 0,
            'cpfcnpj_branch' => 57,
            'negotiation_number' => 95656463154564983,
            'iof_value' => 0,
            'layout_version' => 1,
            'payer' => [
                'name' => 'Cliente Teste',
                'cpf_cnpj' => 11111111111,
                'address' => [
                    'street' => 'Rua Teste',
                    'complement' => 'casa 2',
                    'number' => 120,
                    'neighborhood' => 'CENTRO',
                    'cep' => 28470000,
                    'city' => 'Araruama',
                    'UF' => 'RJ'
                ],
                'email' => 'teste@teste.com',
            ],
            'drawer' => [
                'name' => 'Cliente Teste',
                'cpf_cnpj' => 11111111111,
                'address' => [
                    'street' => 'Rua Teste',
                    'complement' => 'casa 2',
                    'number' => 120,
                    'neighborhood' => 'CENTRO',
                    'cep' => 28470000,
                    'city' => 'Araruama',
                    'UF' => 'RJ'
                ],
                'email' => 'teste@teste.com',
            ],
            'discounts' => [
                [
                    'value' => 0,
                    'percent' => 0,
                    'limit_date' => 0
                ],
                [
                    'value' => 0,
                    'percent' => 0,
                    'limit_date' => 0
                ],
                [
                    'value' => 0,
                    'percent' => 0,
                    'limit_date' => 0
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

        $this->assertTrue($this->service->charge($data));
    }

}
