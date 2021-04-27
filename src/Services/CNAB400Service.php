<?php


namespace Boleto\Services;


use Boleto\Models\Billet;
use Boleto\Repositories\Eloquent\BilletRepository;
use Generator;

class CNAB400Service
{
    private $billetRepository;
    /**
     * CNAB400Service constructor.
     */
    public function __construct(BilletRepository $billetRepository)
    {
        $this->billetRepository = $billetRepository;
    }

    public function generateCNAB400()
    {
        $this->billetRepository->get()->each(function (Billet $billet) {

        });
    }

    public function readCNAB400($file_path): Generator
    {
        $lines = file($file_path);
        foreach ($lines as $line) {
            yield $line;
        }
    }

    public function registerPayedBillet($file_path)
    {
        foreach ($this->readCNAB400($file_path) as $billet) {


        }
    }

    public function makeHead(array $data=[]): string
    {
        $register = $data['register'] ?? '0';
        $operation_type = $data['operation_type'] ?? '1';
        $operation_description = $data['operation_description'] ?? 'REMESSA';
        $service_type = $data['service_type'] ?? '01';
        $charge = str_pad($data['data'] ?? 'COBRANCA', 15);
        $agency = $data['agency'] ?? config('boleto.bradesco_agency');
        $complement = $data['complement'] ?? '00';
        $account = $data['account'] ?? config('bradesco.bradesco_account');
        $account_digit = $data['account_digit'];
        $company_name = str_pad($data['company_name'], 30);
        $compensation_bank = $data['compensation_bank'];
        $bank_name = str_pad($data['bank_name'], 15);
        $create_at = now()->format('dMY');
        $sequence_number = str_pad('1',6, STR_PAD_LEFT);

        return $register.$operation_type.$operation_description.$service_type.$charge.$agency.$complement.$account
            .$account_digit.str_pad(' ',8).$company_name.$compensation_bank.$bank_name.$create_at
            .str_pad(' ',294).$sequence_number."\n";
    }

    public function makeDetails(array $data)
    {
        $transaction_id = $data['transaction_id'] ?? '1';
        $company_type = $data['company_type'] ?? '02';
        $company_register = $data['company_reigster'] ?? ''; // CNPJ
        $agency = config('boleto.bradesco_agency');
        $complement = $data['complment'] ?? '00';
        $account = config('boleto.bradesco_agency');
        $account_digit = $data['account_digit'];
        $instruction = $data['instruction'] ?? '0000';
        $your_number = str_pad($data['your_number'], 26,'0', STR_PAD_LEFT);
        $bank_number = $data['bank_number'];
        $currency_amount = str_pad($data['currency_amount'],13, '0', STR_PAD_LEFT);
        $wallet_number = $data['wallet_number'];
        $occurrence_id = $data['occurrence_id'];
        $wallet_id = $data['wallet_id'];
        $document_number = str_pad($data['document_number'], 8, '0', STR_PAD_LEFT);
        $due_date = $data['due_date'] ?? now()->format('dmy');
        $nominal_value = str_pad($data['nominal_value'], 13, '0', STR_PAD_LEFT);
        $delivery_id = $data['delivery_id'];

    }
}
