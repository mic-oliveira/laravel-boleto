<?php


use Boleto\Models\Billet;
use Bradesco\Interfaces\BilletTemplateInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Bradesco extends Model implements BilletTemplateInterface
{
    private Billet $billet;

    public function __construct(Billet $billet)
    {
        parent::__construct();
        $this->billet = $billet ?? new Billet();
    }

    public function getAgenciaDestino()
    {
        return $this->billet->agency;
    }

    public function getBairroPagador()
    {
        return $this->billet->payer->address->neighborhood ?? '';
    }

    public function getBairroSacadorAvalista()
    {
        return $this->billet->drawer->address->neighborhood ?? '';
    }

    public function getCdEspecieTitulo()
    {
        return $this->billet->title_type;
    }

    public function getCdIndCpfcnpjPagador()
    {
        return $this->billet->payer->cpfcnpf_ind;
    }

    public function getCdIndCpfcnpjSacadorAvalista()
    {
        return $this->billet->drawer->cpfcnpf_ind;
    }

    public function getCdPagamentoParcial()
    {
        return $this->billet->partial_payment_id;
    }

    public function getCepPagador()
    {
        return $this->billet->payer->address->cep;
    }

    public function getCepSacadorAvalista()
    {
        return $this->billet->drawer->address->cep;
    }

    public function getCodigoMoeda()
    {
        return $this->billet->currency_code;
    }

    public function getComplementoCepPagador()
    {
        return $this->billet->payer->address->cep_complement;
    }

    public function getComplementoCepSacadorAvalista()
    {
        return $this->billet->drawer->address->cep_complement;
    }

    public function getComplementoLogradouroPagador()
    {
        return $this->billet->payer->address->complement ?? '';
    }

    public function getComplementoLogradouroSacadorAvalista()
    {
        return $this->billet->drawer->address->complement;
    }

    public function getControleParticipante()
    {
        return $this->billet->partner_controller;
    }

    public function getCtrlCPFCNPJ()
    {
        return $this->billet->cpfcpnj_controller;
    }

    public function getDataLimiteDesconto1()
    {
        return $this->billet->discounts->get(0)->date_limit;
    }

    public function getDataLimiteDesconto2()
    {
        return $this->billet->discounts->get(1)->date_limit;
    }

    public function getDataLimiteDesconto3()
    {
        return $this->billet->discounts->get(2)->date_limit;
    }

    public function getDddPagador()
    {
        return $this->billet->payer->phone->ddd;
    }

    public function getDddSacadorAvalista()
    {
        return $this->billet->drawer->phone->ddd;
    }

    public function getDtEmissaoTitulo()
    {
        return str_replace('-','.', $this->billet->emission_date);
    }

    public function getDtLimiteBonificacao()
    {
        return $this->billet->bonus->limit_date;
    }

    public function getDtVencimentoTitulo()
    {
        return str_replace('-','.', $this->billet->due_date);
    }

    public function getNutitulo()
    {
        return $this->billet->title_number;
    }

    public function getEndEletronicoPagador()
    {
        return $this->billet->payer->email;
    }

    public function getEndEletronicoSacadorAvalista()
    {
        return $this->billet->drawer->email;
    }

    public function getFilialCPFCNPJ()
    {
        return $this->billet->cpfcnpj_branch;
    }

    public function getFormaEmissao()
    {
        return $this->billet->emission_form;
    }

    public function getIdProduto()
    {
        return $this->billet->product_id;
    }

    public function getLogradouroPagador()
    {
        return $this->billet->payer->address->street;
    }

    public function getLogradouroSacadorAvalista()
    {
        return $this->billet->drawer->address->street;
    }

    public function getMunicipioPagador()
    {
        return $this->billet->payer->address->city;
    }

    public function getMunicipioSacadorAvalista()
    {
        return $this->billet->drawer->address->city;
    }

    public function getNomePagador()
    {
       return $this->billet->payer->name;
    }

    public function getNomeSacadorAvalista()
    {
        return $this->billet->drawer->name;
    }

    public function getNuCPFCNPJ()
    {
        return $this->billet->cpfcnpf_number;
    }

    public function getNuCliente()
    {
        return $this->billet->client_number;
    }

    public function getNuCpfcnpjPagador()
    {
        return $this->billet->payer->cpf_cnpj;
    }

    public function getNuCpfcnpjSacadorAvalista()
    {
        return $this->billet->drawer->cpf_cnpf;
    }

    public function getNuLogradouroPagador()
    {
        return $this->billet->payer->address->number;
    }

    public function getNuLogradouroSacadorAvalista()
    {
        return $this->billet->drawer->address->number;
    }

    public function getNuNegociacao()
    {
        return $this->billet->negotiation_number;
    }

    public function getPercentualBonificacao()
    {
        return $this->billet->bonus->percetual ?? '';
    }

    public function getPercentualDesconto1()
    {
        return $this->billet->discounts->get(0)->percent;
    }

    public function getPercentualDesconto2()
    {
        return $this->billet->discounts->get(1)->percent;
    }

    public function getPercentualDesconto3()
    {
        return $this->billet->discounts->get(2)->percent;
    }

    public function getPercentualJuros()
    {
        return $this->billet->fine->percent;
    }

    public function getPercentualMulta()
    {
        return $this->billet->fine->percent;
    }

    public function getPrazoBonificacao()
    {
        return $this->billet->bonus->date_limit;
    }

    public function getPrazoDecurso()
    {
        return $this->billet->term_limit;
    }

    public function getPrazoProtestoAutomaticoNegativacao()
    {
        return $this->billet->protest_limit;
    }

    public function getQtdeDiasJuros()
    {
        return $this->billet->fee->days;
    }

    public function getQtdeDiasMulta()
    {
        return $this->billet->fine->days;
    }

    public function getQtdePagamentoParcial()
    {
        return $this->billet->amount_partial_payment;
    }

    public function getQuantidadeMoeda()
    {
        return $this->billet->currency_amount;
    }

    public function getRegistraTitulo()
    {
        return $this->billet->register_title;
    }

    public function getTelefonePagador()
    {
        return $this->billet->payer->phone->number ?? 0;
    }

    public function getTelefoneSacadorAvalista()
    {
        return $this->billet->drawer->phone->number ?? 0;
    }

    public function getTipoDecurso()
    {
        return $this->billet->term_type;
    }

    public function getTpProtestoAutomaticoNegativacao()
    {
        return $this->billet->protest_type;
    }

    public function getUfPagador()
    {
        return $this->billet->payer->address->UF;
    }

    public function getUfSacadorAvalista()
    {
        return $this->billet->drawer->address->UF;
    }

    public function getVersaoLayout()
    {
        return $this->billet->layout_version;
    }

    public function getVlAbatimento()
    {
        return $this->billet->discount_amount;
    }

    public function getVlBonificacao()
    {
        return $this->billet->bonus_amount;
    }

    public function getVlDesconto1()
    {
        return $this->billet->discounts->get(0)->value;
    }

    public function getVlDesconto2()
    {
        return $this->billet->discounts->get(1)->value;
    }

    public function getVlDesconto3()
    {
        return $this->billet->discounts->get(2)->value;
    }

    public function getVlIOF()
    {
        return $this->billet->IOF_value;
    }

    public function getVlJuros()
    {
        return $this->billet->fee->value;
    }

    public function getVlMulta()
    {
        return $this->billet->fine->value;
    }

    public function getVlNominalTitulo()
    {
        return $this->billet->nominal_value;
    }

    public function createBillet(array $billet)
    {
        DB::beginTransaction();
        try{
            $billet = $this->billet->fill($billet)->saveOrFail();

        } catch (Throwable $e) {
        }

    }

    public function parse(): array
    {
        return [
            "agenciaDestino" => $this->getAgenciaDestino(),
            "bairroPagador" => $this->getBairroPagador(),
            "bairroSacadorAvalista" => $this->getBairroSacadorAvalista(),
            "cdEspecieTitulo" => $this->getCdEspecieTitulo(),
            "cdIndCpfcnpjPagador" => $this->getCdIndCpfcnpjPagador(),
            "cdIndCpfcnpjSacadorAvalista" => $this->getCdIndCpfcnpjSacadorAvalista(),
            "cdPagamentoParcial" => $this->getCdPagamentoParcial(),
            "cepPagador" => $this->getCepPagador(),
            "cepSacadorAvalista" => $this->getCepSacadorAvalista(),
            "codigoMoeda" => $this->getCodigoMoeda(),
            "complementoCepPagador" => $this->getComplementoCepPagador(),
            "complementoCepSacadorAvalista" => $this->getComplementoCepSacadorAvalista(),
            "complementoLogradouroPagador" => $this->getComplementoLogradouroPagador(),
            "complementoLogradouroSacadorAvalista" => $this->getComplementoLogradouroSacadorAvalista(),
            "controleParticipante" => $this->getControleParticipante(),
            "ctrlCPFCNPJ" => $this->getCtrlCPFCNPJ(),
            "dataLimiteDesconto1" => $this->getDataLimiteDesconto1(),
            "dataLimiteDesconto2" => $this->getDataLimiteDesconto2(),
            "dataLimiteDesconto3" => $this->getDataLimiteDesconto3(),
            "dddPagador" => $this->getDddPagador(),
            "dddSacadorAvalista" => $this->getDddSacadorAvalista(),
            "dtEmissaoTitulo" => $this->getDtEmissaoTitulo(),
            "dtLimiteBonificacao" => $this->getDtLimiteBonificacao(),
            "dtVencimentoTitulo" => $this->getDtVencimentoTitulo(),
            "nutitulo" => $this->getNutitulo(),
            "endEletronicoPagador" => $this->getEndEletronicoPagador(),
            "endEletronicoSacadorAvalista" => $this->getEndEletronicoSacadorAvalista(),
            "filialCPFCNPJ" => $this->getFilialCPFCNPJ(),
            "formaEmissao" => $this->getFormaEmissao(),
            "idProduto" => $this->getIdProduto(),
            "logradouroPagador" => $this->getLogradouroPagador(),
            "logradouroSacadorAvalista" => $this->getLogradouroSacadorAvalista(),
            "municipioPagador" => $this->getMunicipioPagador(),
            "municipioSacadorAvalista" => $this->getMunicipioSacadorAvalista(),
            "nomePagador" => $this->getNomePagador(),
            "nomeSacadorAvalista" => $this->getNomeSacadorAvalista(),
            "nuCPFCNPJ" => $this->getNuCPFCNPJ(),
            "nuCliente" => $this->getNuCliente(),
            "nuCpfcnpjPagador" => $this->getNuCpfcnpjPagador(),
            "nuCpfcnpjSacadorAvalista" => $this->getNuCpfcnpjSacadorAvalista(),
            "nuLogradouroPagador" => $this->getNuLogradouroPagador(),
            "nuLogradouroSacadorAvalista" => $this->getNuLogradouroSacadorAvalista(),
            "nuNegociacao" => $this->getNuNegociacao(),
            "percentualBonificacao" => $this->getPercentualBonificacao(),
            "percentualDesconto1" => $this->getPercentualDesconto1(),
            "percentualDesconto2" => $this->getPercentualDesconto2(),
            "percentualDesconto3" => $this->getPercentualDesconto3(),
            "percentualJuros" => $this->getPercentualJuros(),
            "percentualMulta" => $this->getPercentualMulta(),
            "prazoBonificacao" => $this->getPrazoBonificacao(),
            "prazoDecurso" => $this->getPrazoDecurso(),
            "prazoProtestoAutomaticoNegativacao" => $this->getPrazoProtestoAutomaticoNegativacao(),
            "qtdeDiasJuros" => $this->getQtdeDiasJuros(),
            "qtdeDiasMulta" => $this->getQtdeDiasMulta(),
            "qtdePagamentoParcial" => $this->getQtdePagamentoParcial(),
            "quantidadeMoeda" => $this->getQuantidadeMoeda(),
            "registraTitulo" => $this->getRegistraTitulo(),
            "telefonePagador" => $this->getTelefonePagador(),
            "telefoneSacadorAvalista" => $this->getTelefoneSacadorAvalista(),
            "tipoDecurso" => $this->getTipoDecurso(),
            "tpProtestoAutomaticoNegativacao" => $this->getTpProtestoAutomaticoNegativacao(),
            "ufPagador" => $this->getUfPagador(),
            "ufSacadorAvalista" => $this->getUfSacadorAvalista(),
            "versaoLayout" => $this->getVersaoLayout(),
            "vlAbatimento" => $this->getVlAbatimento(),
            "vlBonificacao" => $this->getVlBonificacao(),
            "vlDesconto1" => $this->getVlDesconto1(),
            "vlDesconto2" => $this->getVlDesconto2(),
            "vlDesconto3" => $this->getVlDesconto3(),
            "vlIOF" => $this->getVlIOF(),
            "vlJuros" => $this->getVlJuros(),
            "vlMulta" => $this->getVlMulta(),
            "vlNominalTitulo" => $this->getVlNominalTitulo(),
        ];
    }

}
