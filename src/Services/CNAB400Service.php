<?php


namespace Boleto\Services;


use Generator;

class CNAB400Service
{

    /**
     * CNAB400Service constructor.
     */
    public function __construct()
    {
    }

    public function generateCNAB400()
    {

    }

    public function readCNAB400($path): Generator
    {
        $lines = file($path);
        foreach ($lines as $line) {
            yield $line;
        }
    }
}
