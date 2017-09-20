<?php

namespace AppBundle\Tests\EntityValidation;

use AppBundle\Tests\ContainerAndFixturesAwareUnitTestCase;
use AppBundle\Entity\FaixaEntrega;
use AppBundle\Entity\Transportadora;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\Container;

class FaixaEntregaTest extends ContainerAndFixturesAwareUnitTestCase
{
   
    public function setUp()
    {
        $this->addFixture(new \AppBundle\DataFixtures\ORM\Fixtures());
        $this->executeFixtures();
    }

    public function testSemErros()
    {
        $validator = $this->get('validator');
        
        $transportadoraA = new Transportadora();
        $transportadoraA->setNome('Transportadora A');
        
        $faixaEntrega = new FaixaEntrega();
        $faixaEntrega->setNome('Faixa entrega 1');
        $faixaEntrega->setCepInicial(88888888);
        $faixaEntrega->setCepFinal(88888999);
        $faixaEntrega->setPesoInicial(1);
        $faixaEntrega->setPesoFinal(5);
        $faixaEntrega->setValorQuilo(5);
        $faixaEntrega->setValorQuiloAdicional(6.5);
        $faixaEntrega->setPrazoEntregaInicial(5);
        $faixaEntrega->setPrazoEntregaFinal(7);
        $faixaEntrega->setPrazoEntregaAdicionalPorPeso(1);
        $faixaEntrega->setPesoParaPrazoAdicional(5);
        $faixaEntrega->setTransportadora($transportadoraA);
        
        $errors = $validator->validate($faixaEntrega);
        $this->assertEquals(0, count($errors));
    }
    
    public function testNumerosNegativos()
    {
        $validator = $this->get('validator');
        
        $transportadoraC = new Transportadora();
        $transportadoraC->setNome('Transportadora C');
        
        $faixaEntrega = new FaixaEntrega();
        $faixaEntrega->setNome('Faixa entrega 1');
        $faixaEntrega->setCepInicial(88888888);
        $faixaEntrega->setCepFinal(88888999);
        $faixaEntrega->setPesoInicial(-5);
        $faixaEntrega->setPesoFinal(-1);
        $faixaEntrega->setValorQuilo(-6.5);
        $faixaEntrega->setValorQuiloAdicional(-3);
        $faixaEntrega->setPrazoEntregaInicial(-7);
        $faixaEntrega->setPrazoEntregaFinal(-5);
        $faixaEntrega->setPrazoEntregaAdicionalPorPeso(-5);
        $faixaEntrega->setPesoParaPrazoAdicional(-1);
        $faixaEntrega->setTransportadora($transportadoraC);
        
        $errors = $validator->validate($faixaEntrega);
        $this->assertEquals(8, count($errors));
    }
    
    public function testLetras()
    {
        $validator = $this->get('validator');
        
        $transportadoraC = new Transportadora();
        $transportadoraC->setNome('Transportadora C');
        
        $faixaEntrega = new FaixaEntrega();
        $faixaEntrega->setNome('Faixa entrega 1');
        $faixaEntrega->setCepInicial('aaaaaaaa');
        $faixaEntrega->setCepFinal('aaaaaaaa');
        $faixaEntrega->setPesoInicial('a');
        $faixaEntrega->setPesoFinal('a');
        $faixaEntrega->setValorQuilo('a');
        $faixaEntrega->setValorQuiloAdicional('a');
        $faixaEntrega->setPrazoEntregaInicial('a');
        $faixaEntrega->setPrazoEntregaFinal('a');
        $faixaEntrega->setPrazoEntregaAdicionalPorPeso('a');
        $faixaEntrega->setPesoParaPrazoAdicional('a');
        $faixaEntrega->setTransportadora($transportadoraC);
        
        $errors = $validator->validate($faixaEntrega);
        //10 das letras e 1 por pelo validador mair ou igual a 1 do prazoEntregaFinal
        $this->assertEquals(11, count($errors));
    }
    
}
