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
use AppBundle\Repository\TransportadoraRepository;
use AppBundle\Entity\Transportadora;

class CalculoFreteAdminController extends CRUDController
{

    public function calculaFreteAction(Request $request)
    {
        $required = ["cep", "peso"];
        foreach ($required as $r)
        {
            if(!$request->get($r))
            {
                return new JsonResponse('', Response::HTTP_BAD_REQUEST);
            }
        }
        
        $cep = $request->get('cep');
        $peso = $request->get('peso');
        
        $repositorioTransportadora = $this->getRepositoryTransportadora();
        
        $queryFretes = $repositorioTransportadora->getFretePorCep($cep);
        $transportadoras = $queryFretes->getQuery()->execute();
        
        /* @var $transportadora Transportadora */
//        foreach ($transportadoras as $transportadora) {
//            $transportadora->getFaixasEntrega();
//        }
        
        return new JsonResponse($transportadoras);
    }
    
    /**
     * @return TransportadoraRepository
     */
    private function getRepositoryTransportadora() {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Transportadora');
    }

}
