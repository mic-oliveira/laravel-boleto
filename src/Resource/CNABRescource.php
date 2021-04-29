<?php


namespace Boleto\Resource;


use Illuminate\Http\Resources\Json\JsonResource;

class CNABRescource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'transaction_id' => $this->transaction ?? '1',
            'company_type' => $this->company_type ?? '02',
            'company_register' => $this->drawer->document,
            'agency' => $this->agency,
            'complement' => $this->complement ?? '00',
            'account' => $this->account,
            'account_digit' => $this->account_digit,
            'instruction' => $this->instruction ?? '29',
            'our_number' => $this->bank_id,
            'bank_number' => $this->bank_id,
            'currency_amount' => $this->currency_amount ?? '0',
            'wallet_number' => $this->wallet_number ?? '0',
            'occurrence_id' => $this->occurrence_id,
            'wallet_id' => $this->wallet_id ?? '999',
            'document_number' => $this->bank_id,
            'due_date' => $this->due_date,
            'nominal_value' => $this->nominal_value,
            'delivery_id' => $this->delivery_id ?? '0',
            'bank_id' => $this->bank_number ?? '237',
            'charge_agency' => $this->charge_agency ?? '0000',
            'title_specie' => $this->title_specie ?? '',
            'title_id' => $this->title_id ?? '',
            'emission_date' => $this->emission_date ?? now()->format('dmy'),
            'first_instruction' => $this->first_instruction ?? '29',
            'second_instruction' => $this->second_isntruction ?? '94',
            'late_fee' => $this->fee->value ?? 0,
            'date_limit_discount' => $this->discounts()->first()->date_limit,
            'discount_value' => $this->discounts()->sum('value') ?? 0,
            'iof_value' => $this->iof_value ?? 0,
            'discount_amount' => $this->discounts()->sum('value') ?? 0,
            'document_type' => $this->document_type ?? 1,
            'payer_name' => $this->payer->name,
            'payer_address' => $this->payer->address->street,
            'payer_neighborhood' => $this->payer->address->neighborhood,
            'postal_code' => $this->payer->address->postal_code,
            'city' => $this->payer->address->city,
            'uf' => $this->payer->address->uf,
            'description' => $this->description,
            'sequence_number' => $this->sequence_number,
        ];
    }

}
