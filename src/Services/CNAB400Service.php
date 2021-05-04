<?php


namespace Boleto\Services;


use Boleto\Models\Billet;
use Boleto\Repositories\Eloquent\BilletRepository;
use Boleto\Resource\CNABResource;
use Carbon\Carbon;
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

    public function registerBillet(array $data)
    {

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

    public function makeDetails(array $data): string
    {
        $id_register=$data['id_register'];
        $wallet=$data['wallet'] ?? 0;
        $agency=$data['agency'] ?? 0;
        $account=$data['account'] ?? 0;
        $company_id=str_pad($wallet.$agency.$account,17,0,STR_PAD_LEFT);
        $partner_number=str_pad($data['patner_number'] ?? 0, 25,0,STR_PAD_LEFT);
        $bank_number=str_pad($data['bank_number'], 3,0,STR_PAD_LEFT) ?? '237';
        $fee=$data['fee'];
        $fee_percent=str_pad($data['fee_percent'] ?? 0,4,0,STR_PAD_LEFT);
        $title_id=str_pad($data['title_id'] ?? 0,11,0,STR_PAD_LEFT);
        $conference_number=$data['conference_number'] ?? 0;
        $bonus_per_day=str_pad($data['bonus_per_day'] ?? 0,10,0,STR_PAD_LEFT);
        $emission_condition=$data['emission_condition'] ?? 1;
        $automatic_debit=$data['automatic debit'] ?? 'N';
        $blank_10=str_repeat(' ',10);
        $average_indicator=$data['average_indicator'] ?? ' ';
        $debit_notice=$data['debit_notice'] ?? ' ';
        $payment_quantity=str_pad($data['payment_quantity'] ?? 01,2,0,STR_PAD_LEFT);
        $document_number=str_pad($data['document_number'] ?? 0, 10,STR_PAD_LEFT);
        $due_date=$data['due_date'] ?? now()->addWeekday()->format('dmy');
    }

    public function makeFooter(int $sequence_number=0): string
    {
        return '9'.str_repeat(' ',393).str_pad($sequence_number,6, '0',STR_PAD_LEFT);
    }
}
