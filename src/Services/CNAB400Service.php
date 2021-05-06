<?php


namespace Boleto\Services;


use Boleto\Models\Billet;
use Boleto\Repositories\Eloquent\BilletRepository;
use Boleto\Resource\BradescoCNAB400;
use Boleto\Resource\CNABResource;
use Carbon\Carbon;
use Generator;
use Illuminate\Support\Str;

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
            $content.=$this->makeDetails(BradescoCNAB400::make($billet)->jsonSerialize());
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
        $company_id=Str::of($wallet.$agency.$account)->padLeft(17,0);
        $partner_number=Str::of($data['partner_number'] ?? 0)->padLeft(25,0);
        $bank_number=Str::of($data['bank_number'] ?? '237')->padLeft(3,0) ;
        $fee=$data['fee'] ?? 0;
        $fee_percent=Str::of($data['fee_percent'] ?? 0)->padLeft(4,0);
        $title_id=Str::of($data['title_id'] ?? 0)->padLeft(11,0);
        $conference_number=$data['conference_number'] ?? 0;
        $bonus_per_day=Str::of($data['bonus_per_day'] ?? 0)->padLeft(10,0);
        $emission_condition=$data['emission_condition'] ?? 1;
        $automatic_debit=$data['automatic debit'] ?? 'N';
        $blank_10=str_repeat(' ',10);
        $average_indicator=$data['average_indicator'] ?? ' ';
        $debit_notice=$data['debit_notice'] ?? ' ';
        $payment_quantity=Str::of($data['payment_quantity'] ?? 1)->padLeft(2,0);
        $occurrence_id=Str::of($data['occurrence_id'] ?? 0)->padLeft(2,0);
        $document_number=Str::of($data['document_number'] ?? 0)->padLeft(10, 0);
        $due_date=Carbon::parse($data['due_date'])->format('dmy') ?? now()->addWeekday()->format('dmy');
        $title_value=Str::of($data['title_value'] ?? 0)->padLeft(13, 0);
        $bank_in_charge=Str::of(0)->padLeft(3, 0);
        $depository_agency=Str::of(0)->padLeft(5,0);
        $title_specie=Str::of($data['title_specie'] ?? 99)->padLeft(2,0);
        $identifier='N';
        $emission_date=Carbon::parse($data['emission_date'])->format('dmy') ?? now()->format('dmy');
        $first_instruction=Str::of($data['first_instruction'] ?? 0)->padLeft(2,0);
        $second_instruction=Str::of($data['second_instruction'] ?? 0)->padLeft(2,0);
        $fine_live=Str::of(Carbon::parse($data['fine_live'])->format('dmy') ?? 0)->padLeft(13,0);
        $discount_limit_date=Str::of(Carbon::parse($data['discount_limit_date'])->format('dmy') ?? 0)->padLeft(6,0);
        $discount_value=Str::of($data['discount_value'] ?? 0)->padLeft(13,0);
        $iof_value=Str::of($data['iof_value'] ?? 0)->padLeft(13,0);
        $dejection_value=Str::of($data['dejection_value'] ?? 0)->padLeft(13,0);
        $payer_type=Str::of($data['payer_type'] ?? 1)->padLeft(2,0);
        $payer_document=Str::of($data['payer_document'] ?? 0)->padLeft(14,0);
        $payer_name=Str::of($data['payer_name']  ?? "USUARIO SEM NOME")->substr(0,40)->padRight(40," ");
        $payer_address=Str::of($data['payer_address'] ?? "SEM ENDERECO")->substr(0,40)->padRight(40, " ");
        $first_message=Str::of($data['first_message'] ?? " ")->substr(0,12)->padRight(12, " ");
        $postal_code=Str::of($data['postal_code'] ?? 0)->padLeft(5,0);
        $postal_code_suffix=Str::of($data['postal_code_suffix'] ?? 0)->padLeft(3,0);
        $second_message=Str::of($data['second_message'] ?? " ")->substr(0,60)->padRight(60," ");
        $sequence_number=Str::of($data['sequence_number'] ?? 0)->padLeft(6,0);

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
