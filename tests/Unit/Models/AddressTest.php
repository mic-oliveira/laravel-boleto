<?php


namespace Boleto\Tests\Unit\Models;

use Boleto\Models\Address;
use Orchestra\Testbench\TestCase;

class AddressTest extends TestCase
{
    private Address $address;

    protected function setUp(): void
    {
        parent::setUp();
        $this->address = new Address();
        $this->address->cep='28970000';
    }

    public function testCep()
    {

        $this->assertEquals(28970,$this->address->cep);
    }

    public function testCepComplement()
    {
        $this->assertEquals(000,$this->assertEquals('28970',$this->address->cep));
    }

}
