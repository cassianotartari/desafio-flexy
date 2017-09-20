<?php

namespace AppBundle\Tests\Utils;

use AppBundle\Tests\ContainerAndFixturesAwareUnitTestCase;
use AppBundle\Utils\ValidaRequestCalculoFreteService;
use Symfony\Component\HttpFoundation\Request;

class ValidaRequestCalculoFreteServiceTest extends ContainerAndFixturesAwareUnitTestCase
{
    public function testValida()
    {
        /* @var $validador ValidaRequestCalculoFreteService */
        $validador = $this->get('app.valida_request_calcula_frete');
        
        $request = new Request();
        
        $request->attributes = new \Symfony\Component\HttpFoundation\ParameterBag(array(
            'cep' => 88888888,
            'peso' => 5
        ));
        
        $this->assertEquals(false, $validador->valida($request));
    }
}
