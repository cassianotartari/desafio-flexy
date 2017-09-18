<?php

namespace AppBundle\Utils;

use AppBundle\Repository\FaixaEntregaRepository;
use AppBundle\Entity\FaixaEntrega;
use AppBundle\Entity\CalculoFrete;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CalculaFreteService
{
    /**
     *
     * @var FaixaEntregaRepository
     */
    private $faixaEntregaRepository;
    
    /**
     *
     * @var TokenStorage
     */
    private $token;
    
    /**
     *
     * @param FaixaEntregaRepository $faixaEntregaRepository
     */
    public function __construct(FaixaEntregaRepository $faixaEntregaRepository, TokenStorage $token)
    {
        $this->faixaEntregaRepository = $faixaEntregaRepository;
        $this->token = $token;
    }
    
    private function calculaPesoExcedente($peso, FaixaEntrega $faixaEntrega)
    {
        if ($peso > $faixaEntrega->getPesoFinal()) {
            return round($peso - $faixaEntrega->getPesoFinal());
        }
        return 0;
    }
    
    private function calculaValorExcedente($pesoExcedente, FaixaEntrega $faixaEntrega)
    {
        return $pesoExcedente * $faixaEntrega->getValorQuiloAdicional();
    }
    
    private function calculaValorSemExcedente($peso, $pesoExcedente, FaixaEntrega $faixaEntrega)
    {
        //caso o peso ultrpasse o peso maximo do frete
        $pesoMax = $peso - $pesoExcedente;
        return $faixaEntrega->getValorQuilo() * $pesoMax;
    }

    private function calculaValorFrete($peso, $pesoExcedente, FaixaEntrega $faixaEntrega)
    {
        $valorSemExcedente = $this->calculaValorSemExcedente($peso, $pesoExcedente, $faixaEntrega);
        $valorDoExcedente = $this->calculaValorExcedente($pesoExcedente, $faixaEntrega);
        return $valorSemExcedente + $valorDoExcedente;
    }

    /**
     *
     * @param int $cep
     * @return mixed
     */
    private function getFaixasEntregaPorCep($cep)
    {
        $queryFretes = $this->faixaEntregaRepository->getFretePorCep($cep);
        
        return $queryFretes
            ->getQuery()
            ->execute();
    }

    /**
     *
     * @param int $cep
     * @param float $peso
     * @return array()
     */
    public function calculaFretePorCepEPeso($cep, $peso)
    {
        $faixasEntrega = $this->getFaixasEntregaPorCep($cep);
        
        $fretesComPrecoTotal = [];
        
        /* @var $faixaEntrega FaixaEntrega */
        foreach ($faixasEntrega as $faixaEntrega) {
            $pesoExcedente = $this->calculaPesoExcedente($peso, $faixaEntrega);
            $valorFrete = $this->calculaValorFrete($peso, $pesoExcedente, $faixaEntrega);

            $calculoFrete = new CalculoFrete();
            $calculoFrete->setUsuario($this->token->getToken()->getUser());
            $calculoFrete->setCep($cep);
            $calculoFrete->setPeso($peso);
            $calculoFrete->setValor($valorFrete);
            $calculoFrete->setTransportadora($faixaEntrega->getTransportadora());
            
            $fretesComPrecoTotal[] = $calculoFrete;
        }
        
        //ordena crescente pelo valor do frete
        usort($fretesComPrecoTotal, array($this, "precoMenor"));
        
        return $fretesComPrecoTotal;
    }
    
    private function precoMenor($a, $b)
    {
        return $a > $b;
    }
}
