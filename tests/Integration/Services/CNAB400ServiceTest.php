<?php


namespace Boleto\Tests\Integration\Services;


use Boleto\Services\CNAB400Service;
use Orchestra\Testbench\TestCase;

class CNAB400ServiceTest extends TestCase
{
    private CNAB400Service $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CNAB400Service();
    }

    public function testReadCNAB400()
    {
        echo "ID_BANCO\tCODIGO\tFATURA\tVALOR\n";
        foreach ($this->service->readCNAB400(__DIR__.'/../../../CN15041A.RET') as $lin_num=>$line) {
            if ($lin_num > 0 && $lin_num){
                echo substr($line,127,7)."\t";
                echo substr($line,57,5)."\t";
                echo substr($line,63,7)."\t"; // CODIGO FATURA(NOSSO NUMERO)
                echo bcdiv((int)substr($line,153,12),100,2)."\n"; // VALOR DO BOLETO
            }
        }
    }
}
