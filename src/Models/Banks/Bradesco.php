<?php

namespace Boleto\Models\Banks;
use Boleto\Models\Billet;
use Bradesco\Interfaces\BilletTemplateInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class Bradesco implements BilletTemplateInterface
{
    private Billet $billet;

    public function __construct(Billet $billet)
    {
        $this->billet = $billet ?? new Billet();
    }

    public function getAgenciaDestino()
    {
        return $this->billet->agency;
    }

    public function getBairroPagador(): string
    {
        return $this->billet->payer->address->neighborhood ?? '';
    }

    public function getBairroSacadorAvalista(): string
    {
        return $this->billet->drawer->address->neighborhood ?? '';
    }

    public function getCdEspecieTitulo(): int
    {
        return $this->billet->title_type;
    }

    public function getCdIndCpfcnpjPagador(): int
    {
        return intval($this->billet->payer->cpfcnpj_ind);
    }

    public function getCdIndCpfcnpjSacadorAvalista()
    {
        return $this->billet->drawer->cpfcnpj_ind ?? '';
    }

    public function getCdPagamentoParcial():string
    {
        return $this->billet->partial_payment_id ?? '';
    }

    public function getCepPagador(): int
    {
        return intval($this->billet->payer->address->cep) ?? 0;
    }

    public function getCepSacadorAvalista(): int
    {
        return intval($this->billet->drawer->address->cep);
    }

    public function getCodigoMoeda(): int
    {
        return $this->billet->currency_code;
    }

    public function getComplementoCepPagador(): int
    {
        return intval($this->billet->payer->address->cep_complement);
    }

    public function getComplementoCepSacadorAvalista(): int
    {
        return intval($this->billet->drawer->address->cep_complement);
    }

    public function getComplementoLogradouroPagador(): string
    {
        return $this->billet->payer->address->complement ?? '';
    }

    public function getComplementoLogradouroSacadorAvalista(): string
    {
        return $this->billet->drawer->address->complement ?? '';
    }

    public function getControleParticipante(): string
    {
        return $this->billet->partner_controller ?? '';
    }

    public function getCtrlCPFCNPJ(): int
    {
        return intval($this->billet->cpfcnpj_control);
    }

    public function getDataLimiteDesconto1()
    {
        return $this->formatDate($this->billet->discounts->get(0)->date_limit);
    }

    public function getDataLimiteDesconto2()
    {
        return $this->formatDate($this->billet->discounts->get(1)->date_limit);
    }

    public function getDataLimiteDesconto3()
    {
        return $this->formatDate($this->billet->discounts->get(2)->date_limit);
    }

    public function getDddPagador()
    {
        return intval($this->billet->payer->phone->ddd ?? 0);
    }

    public function getDddSacadorAvalista()
    {
        return intval($this->billet->drawer->phone->ddd ?? 0);
    }

    public function getDtEmissaoTitulo()
    {
        return $this->formatDate($this->billet->emission_date);
    }

    public function getDtLimiteBonificacao()
    {
        return $this->billet->bonus->limit_date ?? '';
    }

    public function getDtVencimentoTitulo()
    {
        return $this->formatDate($this->billet->due_date);
    }

    public function getNutitulo()
    {
        return $this->billet->title_number;
    }

    public function getEndEletronicoPagador()
    {
        return $this->billet->payer->mail ?? '';
    }

    public function getEndEletronicoSacadorAvalista()
    {
        return $this->billet->drawer->mail ?? '';
    }

    public function getFilialCPFCNPJ(): int
    {
        return $this->billet->cpfcnpj_branch;
    }

    public function getFormaEmissao()
    {
        return $this->billet->emission_form;
    }

    public function getIdProduto(): int
    {
        return intval($this->billet->product_id);
    }

    public function getLogradouroPagador(): string
    {
        return $this->billet->payer->address->street ?? '';
    }

    public function getLogradouroSacadorAvalista()
    {
        return $this->billet->drawer->address->street ?? '';
    }

    public function getMunicipioPagador()
    {
        return $this->billet->payer->address->city ?? '';
    }

    public function getMunicipioSacadorAvalista()
    {
        return $this->billet->drawer->address->city ?? '';
    }

    public function getNomePagador()
    {
       return $this->billet->payer->name;
    }

    public function getNomeSacadorAvalista()
    {
        return $this->billet->drawer->name ?? '';
    }

    public function getNuCPFCNPJ()
    {
        return $this->billet->cpfcnpj_number;
    }

    public function getNuCliente()
    {
        return $this->billet->client_number;
    }

    public function getNuCpfcnpjPagador()
    {
        return intval($this->billet->payer->cpfcnpj);
    }

    public function getNuCpfcnpjSacadorAvalista()
    {
        return intval($this->billet->drawer->cpfcnpj);
    }

    public function getNuLogradouroPagador()
    {
        return $this->billet->payer->address->number;
    }

    public function getNuLogradouroSacadorAvalista()
    {
        return $this->billet->drawer->address->number ?? '';
    }

    public function getNuNegociacao()
    {
        return intval($this->billet->negotiation_number);
    }

    public function getPercentualBonificacao()
    {
        return intval($this->billet->bonus->percetual);
    }

    public function getPercentualDesconto1()
    {
        return intval($this->billet->discounts->get(0)->percent);
    }

    public function getPercentualDesconto2()
    {
        return intval($this->billet->discounts->get(1)->percent);
    }

    public function getPercentualDesconto3()
    {
        return intval($this->billet->discounts->get(2)->percent);
    }

    public function getPercentualJuros()
    {
        return intval($this->billet->fine->percent);
    }

    public function getPercentualMulta(): int
    {
        return intval($this->billet->fine->percent);
    }

    public function getPrazoBonificacao()
    {
        return intval($this->formatDate($this->billet->bonus->days));
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
        return intval($this->billet->fee->days);
    }

    public function getQtdeDiasMulta()
    {
        return intval($this->billet->fine->days);
    }

    public function getQtdePagamentoParcial()
    {
        return $this->billet->amount_partial_payment;
    }

    public function getQuantidadeMoeda()
    {
        return $this->billet->currency_amount ?? 0;
    }

    public function getRegistraTitulo()
    {
        return $this->billet->register_title;
    }

    public function getTelefonePagador()
    {
        return intval($this->billet->payer->phone->number ?? 0);
    }

    public function getTelefoneSacadorAvalista()
    {
        return intval($this->billet->drawer->phone->number ?? 0);
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
        return $this->billet->payer->address->UF ?? '';
    }

    public function getUfSacadorAvalista()
    {
        return $this->billet->drawer->address->UF ?? '';
    }

    public function getVersaoLayout()
    {
        return $this->billet->layout_version;
    }

    public function getVlAbatimento()
    {
        return intval($this->billet->rebate_value);
    }

    public function getVlBonificacao(): int
    {
        return intval($this->billet->bonus->value);
    }

    public function getVlDesconto1()
    {
        return intval($this->billet->discounts->get(0)->value);
    }

    public function getVlDesconto2()
    {
        return intval($this->billet->discounts->get(1)->value);
    }

    public function getVlDesconto3()
    {
        return intval($this->billet->discounts->get(2)->value);
    }

    public function getVlIOF()
    {
        return intval($this->billet->IOF_value);
    }

    public function getVlJuros()
    {
        return intval($this->billet->fee->value);
    }

    public function getVlMulta()
    {
        return intval($this->billet->fine->value);
    }

    public function getVlNominalTitulo()
    {
        return intval($this->billet->nominal_value);
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

    private function formatDate(string $date = null)
    {
        return $date ? str_replace('-','.', Carbon::parse($date)->format('d-m-Y')) : '';
    }
}
