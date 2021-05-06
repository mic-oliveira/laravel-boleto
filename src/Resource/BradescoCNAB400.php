<?php


namespace Boleto\Resource;


use Illuminate\Http\Resources\Json\JsonResource;

class BradescoCNAB400 extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_register' => $this->id_register ?? 1,
            'wallet' => $this->wallet ?? 0,
            'agency' => $this->agency ?? 0,
            'account' => $this->account ?? 0,
            'partner_number' => '',
            'bank_number' => '',
            'fee' => $this->fee->date_limit ?? now()->addWeekdays(3),
            'fee_percent' => 1,
            'title_id' => $this->title_id ?? 0,
            'conference_number' => $this->conference_number ?? 0,
            'bonus_per_day' => $this->bonus->value ?? 0,
            'emission_condition' => $this->emission_condition ?? 0,
            'automatic debit' => 'N',
            'payment_quantity' => 1,
            'occurrence_id' => $this->occurrence_id ?? 1,
            'document_number' => $this->id,
            'due_date' => $this->due_date,
            'title_value' => $this->nominal_value,
            'title_specie' => $this->title_specie ?? 99,
            'emission_date' => $this->emission_date,
            'first_instruction' => $this->first_instruction,
            'second_instruction' => $this->second_instruction,
            'fine_live' => $this->fine->value,
            'discount_limit_date' => $this->discounts()->first()->date_limit,
            'discount_value' => $this->discounts()->sum('value'),
            'iof_value' => $this->iof_value,
            'dejection_value' => '',
            'payer_type' => strlen($this->payer->cpf_cnpj)>11 ? 2 : 1,
            'payer_document' => $this->payer->cpf_cnpj,
            'payer_name' => $this->payer->name,
            'payer_address' => $this->payer->address->street,
            'first_message' => '',
            'postal_code' => $this->payer->address->getCepAttribute(),
            'postal_code_suffix' => $this->payer->address->getCepComplementAttribute(),
            'second_message' => '',
            'sequence_number' => $this->sequence_number,
        ];
    }

}
