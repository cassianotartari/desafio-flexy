<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\CalculoFrete;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Repository\FaixaEntregaRepository;
use AppBundle\Entity\Transportadora;
use AppBundle\Entity\FaixaEntrega;

class CalculoFreteAdminController extends CRUDController
{
    const NUMEROS_CARACTERES_CEP = 8;
    
    private function validateRequestParametersCalculaFrete(Request $request)
    {
        $required = ["cep", "peso"];
        foreach ($required as $r)
        {
            if(!$request->get($r))
            {
                return true;
            }
        }
        if(strlen($request->get('cep')) < self::NUMEROS_CARACTERES_CEP) {
            return true;
        }
        if(!$request->get('peso')) {
            return true;
        }
    }
    
    private function calculaPesoExcedente($peso, FaixaEntrega $faixaEntrega)
    {
        if($peso > $faixaEntrega->getPesoFinal()) {
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

    private function getFaixasEntregaPorCep($cep)
    {
        $repositorioFaixaEntrega = $this->getRepositoryFaixaEntrega();
        $queryFretes = $repositorioFaixaEntrega->getFretePorCep($cep);
        
        return $queryFretes
            ->getQuery()
            ->execute();
    }

    public function calculaFreteAction(Request $request)
    {
        if($this->validateRequestParametersCalculaFrete($request))
        {
            return new JsonResponse('', Response::HTTP_BAD_REQUEST);
        }
        
        $cep = $request->get('cep');
        $peso = $request->get('peso');
        
        $faixasEntrega = $this->getFaixasEntregaPorCep($cep);
        
        $fretesComPrecoTotal = [];
        
        /* @var $faixaEntrega FaixaEntrega */
        foreach ($faixasEntrega as $faixaEntrega) {
            $pesoExcedente = $this->calculaPesoExcedente($peso, $faixaEntrega);
            $valorFrete = $this->calculaValorFrete($peso, $pesoExcedente, $faixaEntrega);
            $fretesComPrecoTotal[(string)$faixaEntrega->getTransportadora()] = $valorFrete;
        }
        
        //ordena crescente pelo valor do frete
        asort($fretesComPrecoTotal);
        
        return new JsonResponse($fretesComPrecoTotal);
    }
    
    /**
     * @return FaixaEntregaRepository
     */
    private function getRepositoryFaixaEntrega() {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:FaixaEntrega');
    }

}
