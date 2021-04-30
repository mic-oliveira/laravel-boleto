<?php


namespace Boleto\Resource;


use Illuminate\Http\Resources\Json\JsonResource;

class CNABResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'transaction_id' => $this->transaction ?? '1',
            'company_type' => $this->company_type ?? '02',
            'company_register' => $this->document ?? '0',
            'agency' => $this->agency ?? '0',
            'complement' => $this->complement ?? '00',
            'account' => $this->account ?? '0',
            'account_digit' => $this->account_digit ?? '0',
            'instruction' => $this->instruction ?? '29',
            'our_number' => $this->bank_id ?? '0',
            'bank_number' => $this->bank_id ?? '0',
            'currency_amount' => $this->currency_amount ?? '0',
            'wallet_number' => $this->wallet_number ?? '0',
            'occurrence_id' => $this->occurrence_id ?? '0',
            'wallet_id' => $this->wallet_id ?? '999',
            'document_number' => $this->document ?? '0',
            'due_date' => $this->due_date ?? '0',
            'nominal_value' => $this->nominal_value ?? '0',
            'delivery_id' => $this->delivery_id ?? '0',
            'bank_id' => $this->bank_number ?? '237',
            'charge_agency' => $this->charge_agency ?? '0000',
            'title_specie' => $this->title_specie ?? '0',
            'title_id' => $this->title_id ?? 0,
            'emission_date' => $this->emission_date ?? now()->format('dmy'),
            'first_instruction' => $this->first_instruction ?? '29',
            'second_instruction' => $this->second_isntruction ?? '94',
            'late_fee' => $this->fee->value ?? 0,
            'date_limit_discount' => $this->discounts()->first()->date_limit ?? '0',
            'discount_value' => $this->discounts()->sum('value') ?? 0,
            'iof_value' => $this->iof_value ?? 0,
            'discount_amount' => $this->discounts()->sum('value') ?? 0,
            'document_type' => $this->document_type ?? 1,
            'payer_name' => $this->payer->name ?? 'NULL',
            'payer_address' => $this->payer->address->street ?? 'NULL',
            'payer_neighborhood' => $this->payer->address->neighborhood ?? "NULL",
            'postal_code' => $this->payer->address->postal_code ?? "00000000",
            'city' => $this->payer->address->city ?? "NULL",
            'uf' => $this->payer->address->uf ?? "RJ",
            'description' => $this->description ?? "NULL",
            'sequence_number' => $this->sequence_number ?? "0",
        ];
    }

}
