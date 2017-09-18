<?php

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CalculoFreteAdminController extends CRUDController
{
    public function calculaFreteAction(Request $request)
    {
        if (!$this->isXmlHttpRequest()) {
            return new JsonResponse('', Response::HTTP_BAD_REQUEST);
        }
        
        /* @var $validaResquestCalculoService \AppBundle\Utils\ValidaRequestCalculoFreteService */
        $validaResquestCalculoService = $this->get('app.valida_request_calcula_frete');
        
        if ($validaResquestCalculoService->valida($request)) {
            return new JsonResponse('', Response::HTTP_BAD_REQUEST);
        }
        
        $cep = $request->get('cep');
        $peso = $request->get('peso');
        
        /* @var $calculaFreteService \AppBundle\Utils\CalculaFreteService */
        $calculaFreteService = $this->get('app.calcula_frete_service');
        
        $calculosFrete = $calculaFreteService->calculaFretePorCepEPeso($cep, $peso);
        
        $fretesComPrecoTotal = [];
        
        $em = $this->getDoctrine()->getManager();
        
        /* @var $calculoFrete \AppBundle\Entity\CalculoFrete */
        foreach ($calculosFrete as $calculoFrete) {
            $fretesComPrecoTotal[(string)$calculoFrete->getTransportadora()] = $calculoFrete->getValor();
            //log
            $em->persist($calculoFrete);
        }
        
        $em->flush();
        
        return $this->render('AppBundle:CalculoFrete:results.html.twig', array(
            'calculosFrete' => $calculosFrete
        ));
    }
}
