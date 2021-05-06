<?php


namespace Boleto\Tests\Integration\Services;


use Boleto\Repositories\Eloquent\BilletRepository;
use Boleto\Services\CNAB400Service;
use Mockery;
use Mockery\Mock;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase;

class CNAB400ServiceTest extends TestCase
{
    private $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CNAB400Service(new BilletRepository());
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

    public function testGenerateCNAB()
    {
        $this->assertTrue($this->service->generateCNAB400());
    }

    public function testMakeheader()
    {
        echo $this->service->makeHeader();
        $this->assertEquals(400, strlen($this->service->makeHeader()));
    }

    public function testMakeDetails()
    {
        echo $this->service->makeDetails();
        $this->assertEquals(400, strlen(explode("\n",$this->service->makeDetails())[0]));
    }

    public function testMakeFooter()
    {
        echo $this->service->makeFooter(250);
        $this->assertEquals(400, strlen($this->service->makeFooter(250)));
    }
}
