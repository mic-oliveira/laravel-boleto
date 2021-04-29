<?php


namespace Boleto\Services;


use Boleto\Models\Billet;
use Boleto\Repositories\Eloquent\BilletRepository;
use Boleto\Resource\CNABRescource;
use Boleto\Resource\CNABResource;
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
        $content = $this->makeHeader();
        $this->billetRepository->get()->each(function (Billet $billet) use (&$content) {
            $content.=$this->makeDetails(CNABResource::make($billet)->jsonSerialize());
        });
        file_put_contents(now()->toDayDateTimeString().'.txt', $content);
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

    public function makeHeader(array $data=[]): string
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
        $agency = $data['agency'];
        $complement = $data['complment'] ?? '00';
        $account = str_pad($data['account'],5, '0', STR_PAD_LEFT);
        $account_digit = $data['account_digit'];
        $instruction = $data['instruction'] ?? '0000';
        $our_number = str_pad($data['our_number'], 26,'0', STR_PAD_LEFT);
        $bank_number = $data['bank_number'];
        $currency_amount = str_pad($data['currency_amount'],13, '0', STR_PAD_LEFT);
        $wallet_number = $data['wallet_number'];
        $occurrence_id = $data['occurrence_id'];
        $wallet_id = $data['wallet_id'];
        $document_number = str_pad($data['document_number'], 8, '0', STR_PAD_LEFT);
        $due_date = $data['due_date'] ?? now()->format('dmy');
        $nominal_value = str_pad($data['nominal_value'], 13, '0', STR_PAD_LEFT);
        $delivery_id = $data['delivery_id'];
        $bank_id = $data['bank_id']; // ex.: 341
        $charge_agency = $data['charge_agency'] ?? '0000';
        $title_specie = $data['title_specie'] ?? '99';
        $title_id = $data['title_id'] ?? 'A';
        $emission_date = $data['emission_date'] ?? now()->format('dmy');
        $first_instruction = $data['first_instruction'] ?? '29';
        $second_instruction = $data['second_instruction'] ?? '94';
        $late_fee = $data['late_fee'] ?? '0';
        $date_limit_discount = $data['date_limit_discount'];
        $discount_value = $data['discount_value'];
        $iof_value = $data['iof_value'];
        $discount_amount = $data['discount_amount'];
        $document_type = str_pad($data['document_type'],15, '0', STR_PAD_LEFT);
        $payer_name = $data['payer_name'];
        $payer_address = $data['payer_address'];
        $payer_neighborhood = $data['payer_neighborhood'];
        $postal_code = str_pad($data['postal_code'], 8, '0', STR_PAD_LEFT);
        $city = str_pad($data['city'], 15);
        $uf = $data['uf'];
        $description = str_pad($data['description'], 40);
        $register_detail = $data['register_detail'];
        $sequence_number = $data['sequence_number'];

        return $transaction_id.$company_type.$company_register.$agency.$complement.$account.$account_digit
            .str_pad(' ', 4).$instruction.$our_number.$bank_number.$currency_amount.str_pad(' ', 21)
            .$wallet_number.$occurrence_id.$wallet_id.$document_number.$due_date.$nominal_value.$delivery_id.$bank_id
            .$charge_agency.$title_specie.$title_id.$emission_date.$first_instruction.$second_instruction.$late_fee
            .$date_limit_discount.$discount_value.$iof_value.$discount_amount.$document_type.$payer_name.$payer_address
            .$payer_neighborhood.$postal_code.$city.$uf.$description.$register_detail.$sequence_number."\n";
    }

    public function makeFooter()
    {

    }
}
