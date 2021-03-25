<?php

namespace Boleto\Interfaces;

use Bradesco\Interfaces\BilletTemplateInterface;

interface BoletoInterface
{
    public function createBillet(BilletTemplateInterface $billetTemplate);
    public function updateBillet(BilletTemplateInterface $billetTemplate);
    public function cancelBillet();
}
