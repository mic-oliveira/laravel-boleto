<?php


namespace Boleto\Tests\Unit\Models;


use Boleto\Models\Person;
use Orchestra\Testbench\TestCase;

class PersonTest extends TestCase
{
    private Person $person;
    protected function setUp(): void
    {
        parent::setUp();
        $this->person = new Person();
        $this->person->cpf_cnpf=12345678910;
    }

    public function testCpfcnpj()
    {

        $this->assertEquals(1234567891, $this->person->cpf_cnpf);
    }

    public function testCpfcnpjDigit()
    {
        $this->assertEquals(0, $this->person->cpfcnpj_ind);
    }
}
