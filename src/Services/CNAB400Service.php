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
        $this->billetRepository->get()->each(function (Billet $billet, $item) use (&$content) {
            $content.=$this->makeDetails(CNABResource::make($billet)->jsonSerialize());
        });
        $content.=$this->makeFooter();
        file_put_contents(now()->toDayDateTimeString().'.txt', $content);
        return true;
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
        $register_id=$data['register_id'] ?? 0;
        $shipping_id=$data['shipping_id'] ?? 1;
        $literal_shipping=$data['literal_shipping'] ?? 'REMESSA';
        $service_id=str_pad($data['service_id'] ?? 1, 2, 0, STR_PAD_LEFT);
        $literal_service=str_pad($data['literal_service'] ?? 'COBRANCA',15," ");
        $company_code=str_pad($data['company_code'] ?? 0,20,0,STR_PAD_LEFT);
        $company_name=str_pad($data['company_name'] ?? "TESTE", 30, " ");
        $bank_number=str_pad($data['bank_number'] ?? 237, 3, 0, STR_PAD_LEFT);
        $bank_name=str_pad($data['bank_name'] ?? 'BRADESCO', 15, " ");
        $write_date=now()->format('dmy');
        $blank=str_repeat(" ", 8);
        $system_id=$data['system_id'] ?? "MX";
        $shipping_sequence=str_pad($data['shipping_sequence'] ?? 0,7,0,STR_PAD_LEFT);
        $sequence_number=str_pad(1,6,0,STR_PAD_LEFT);
        return $register_id.$shipping_id.$literal_shipping.$service_id.$literal_service.$company_code
            .$company_name.$bank_number.$bank_name.$write_date.str_repeat(" ", 8).$system_id
            .$shipping_sequence.str_repeat(" ",277).$sequence_number;
    }

    public function makeDetails(array $data = []): string
    {
        $id_register=$data['id_register'] ?? 1;
        $wallet=$data['wallet'] ?? 0;
        $agency=$data['agency'] ?? 0;
        $account=$data['account'] ?? 0;
        $company_id=str_pad($wallet.$agency.$account,17,0,STR_PAD_LEFT);
        $partner_number=str_pad($data['partner_number'] ?? 0, 25,0,STR_PAD_LEFT);
        $bank_number=str_pad($data['bank_number'] ?? '237', 3,0,STR_PAD_LEFT) ;
        $fee=$data['fee'] ?? 0;
        $fee_percent=str_pad($data['fee_percent'] ?? 0,4,0,STR_PAD_LEFT);
        $title_id=str_pad($data['title_id'] ?? 0,11,0,STR_PAD_LEFT);
        $conference_number=$data['conference_number'] ?? 0;
        $bonus_per_day=str_pad($data['bonus_per_day'] ?? 0,10,0,STR_PAD_LEFT);
        $emission_condition=$data['emission_condition'] ?? 1;
        $automatic_debit=$data['automatic debit'] ?? 'N';
        $blank_10=str_repeat(' ',10);
        $average_indicator=$data['average_indicator'] ?? ' ';
        $debit_notice=$data['debit_notice'] ?? ' ';
        $payment_quantity=str_pad($data['payment_quantity'] ?? 1,2,0,STR_PAD_LEFT);
        $occurrence_id=str_pad($data['occurrence_id'] ?? 0,2,0,STR_PAD_LEFT);
        $document_number=str_pad($data['document_number'] ?? 0, 10, 0, STR_PAD_LEFT);
        $due_date=$data['due_date'] ?? now()->addWeekday()->format('dmy');
        $title_value=str_pad($data['title_value'] ?? 0, 13, 0, STR_PAD_LEFT);
        $bank_in_charge=str_pad(0, 3, 0, STR_PAD_LEFT);
        $depository_agency=str_pad(0,5,0,STR_PAD_LEFT);
        $title_specie=str_pad($data['title_specie'] ?? 99,2,0,STR_PAD_LEFT);
        $identifier='N';
        $emission_date=$data['emission_date'] ?? now()->format('dmy');
        $first_instruction=str_pad($data['first_instruction'] ?? 0,2,0,STR_PAD_LEFT);
        $second_instruction=str_pad($data['second_instruction'] ?? 0,2,0,STR_PAD_LEFT);
        $fine_live=str_pad($data['fine_live'] ?? 0,13,0,STR_PAD_LEFT);
        $discount_limit_date=str_pad($data['discount_limit_date'] ?? 0,6,0,STR_PAD_LEFT);
        $discount_value=str_pad($data['discount_value'] ?? 0,13,0, STR_PAD_LEFT);
        $iof_value=str_pad($data['iof_value'] ?? 0,13,0, STR_PAD_LEFT);
        $dejection_value=str_pad($data['dejection_value'] ?? 0,13,0,STR_PAD_LEFT);
        $payer_type=str_pad($data['payer_type'] ?? 1,2,0,STR_PAD_LEFT);
        $payer_document=str_pad($data['payer_document'] ?? 0,14,0,STR_PAD_LEFT);
        $payer_name=str_pad(substr($data['payer_name']  ?? "USUARIO SEM NOME",0,40),40," ");
        $payer_address=str_pad(substr($data['payer_address'] ?? "SEM ENDERECO",0,40) ,40, " ");
        $first_message=str_pad(substr($data['first_message'] ?? " ",0,12) ,12, " ");
        $postal_code=str_pad($data['postal_code'] ?? 0,5,0,STR_PAD_LEFT);
        $postal_code_suffix=str_pad($data['postal_code_suffix'] ?? 0, 3,0,STR_PAD_LEFT);
        $second_message=str_pad(substr($data['second_message'] ?? "",0,60),60," ");
        $sequence_number=str_pad($data['sequence_number'] ?? 0,6,0,STR_PAD_LEFT);

        return $id_register.str_repeat(" ",19).$company_id.$partner_number.$bank_number.$fee
            .$fee_percent.$title_id.$conference_number.$bonus_per_day.$emission_condition.$automatic_debit
            .$blank_10.$average_indicator.$debit_notice.$payment_quantity.$occurrence_id.$document_number
            .$due_date.$title_value
            .$bank_in_charge.$depository_agency.$title_specie.$identifier.$emission_date.$first_instruction.
            $second_instruction.$fine_live.$discount_limit_date.$discount_value.$iof_value.$dejection_value
            .$payer_type.$payer_document.$payer_name.$payer_address.$first_message.$postal_code.$postal_code_suffix
            .$second_message.$sequence_number;
    }

    public function makeFooter(int $sequence_number=0): string
    {
        return '9'.str_repeat(' ',393).str_pad($sequence_number,6, '0',STR_PAD_LEFT);
    }
}
