<?php

namespace AppBundle\Tests\Validator;

use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;
use AppBundle\Validator\Constraints\CepNoIntervalo;
use AppBundle\Validator\Constraints\CepNoIntervaloValidator;
use AppBundle\Entity\FaixaEntrega;
use AppBundle\Entity\Transportadora;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\Container;

class CepNoIntervaloValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     *
     * @var Kernel
     */
    protected static $kernel;
    
    /**
     *
     * @var Container
     */
    protected static $container;
    
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public static function setUpBeforeClass()
    {
        self::$kernel = new \AppKernel('test', true);
        self::$kernel->boot();

        self::$container = self::$kernel->getContainer();
    }

    public function get($serviceId)
    {
        return self::$kernel->getContainer()->get($serviceId);
    }
    
    protected function getApiVersion()
    {
        return Validation::API_VERSION_2_5;
    }

    protected function createValidator()
    {
        $this->em = $this->get('doctrine.orm.entity_manager');
        return new CepNoIntervaloValidator($this->em);
    }

    public function testEmptyStringIsValid()
    {
        $this->validator->validate('', new CepNoIntervalo());
        $this->buildViolation('intervalo_invalido')
            ->assertRaised();
    }
    
    public function testNullIsValid()
    {
        $this->validator->validate(null, new CepNoIntervalo());

        $this->buildViolation('intervalo_invalido')
            ->assertRaised();
    }
    
    public function testValidFaixaEntrega()
    {   
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
        
        $this->validator->validate($faixaEntrega, new CepNoIntervalo());

        $this->assertNoViolation();
    }
    
    public function testInvalidFaixaEntregaComErroNoCepInicialEFinal()
    {
        $repository = $this->em->getRepository(Transportadora::class);
        $transportadoraA = $repository->findOneByNome('Transportadora A');
        
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

        $this->validator->validate($faixaEntrega,  new CepNoIntervalo());
        
        $this->buildViolation('cep_no_intervalo')
            ->atPath('property.path.cepInicial')
            ->setParameter('%cep%', $faixaEntrega->getCepInicial())
            ->buildNextViolation('cep_no_intervalo')
            ->atPath('property.path.cepFinal')
            ->setParameter('%cep%', $faixaEntrega->getCepFinal())
            ->buildNextViolation('cepinicial_cepfinal_no_intervalo')
            ->setParameter('%cepinicial%', $faixaEntrega->getCepInicial())
            ->setParameter('%cepfinal%', $faixaEntrega->getCepFinal())
            ->assertRaised();
    }
    
    public function testInvalidFaixaEntregaComErroNoCepInicial()
    {
        $repository = $this->em->getRepository(Transportadora::class);
        $transportadoraA = $repository->findOneByNome('Transportadora A');
        
        $faixaEntrega = new FaixaEntrega();
        $faixaEntrega->setNome('Faixa entrega 1');
        $faixaEntrega->setCepInicial(88888888);
        $faixaEntrega->setCepFinal(88889999);
        $faixaEntrega->setPesoInicial(1);
        $faixaEntrega->setPesoFinal(5);
        $faixaEntrega->setValorQuilo(5);
        $faixaEntrega->setValorQuiloAdicional(6.5);
        $faixaEntrega->setPrazoEntregaInicial(5);
        $faixaEntrega->setPrazoEntregaFinal(7);
        $faixaEntrega->setPrazoEntregaAdicionalPorPeso(1);
        $faixaEntrega->setPesoParaPrazoAdicional(5);
        $faixaEntrega->setTransportadora($transportadoraA);

        $this->validator->validate($faixaEntrega,  new CepNoIntervalo());
        
        $this->buildViolation('cep_no_intervalo')
            ->atPath('property.path.cepInicial')
            ->setParameter('%cep%', $faixaEntrega->getCepInicial())
            ->buildNextViolation('cepinicial_cepfinal_no_intervalo')
            ->setParameter('%cepinicial%', $faixaEntrega->getCepInicial())
            ->setParameter('%cepfinal%', $faixaEntrega->getCepFinal())
            ->assertRaised();
    }
    
    public function testInvalidFaixaEntregaComErroNoCepFinal()
    {
        $repository = $this->em->getRepository(Transportadora::class);
        $transportadoraA = $repository->findOneByNome('Transportadora A');
        
        $faixaEntrega = new FaixaEntrega();
        $faixaEntrega->setNome('Faixa entrega 1');
        $faixaEntrega->setCepInicial(77777777);
        $faixaEntrega->setCepFinal(88888899);
        $faixaEntrega->setPesoInicial(1);
        $faixaEntrega->setPesoFinal(5);
        $faixaEntrega->setValorQuilo(5);
        $faixaEntrega->setValorQuiloAdicional(6.5);
        $faixaEntrega->setPrazoEntregaInicial(5);
        $faixaEntrega->setPrazoEntregaFinal(7);
        $faixaEntrega->setPrazoEntregaAdicionalPorPeso(1);
        $faixaEntrega->setPesoParaPrazoAdicional(5);
        $faixaEntrega->setTransportadora($transportadoraA);

        $this->validator->validate($faixaEntrega,  new CepNoIntervalo());
        
        $this->buildViolation('cep_no_intervalo')
            ->atPath('property.path.cepFinal')
            ->setParameter('%cep%', $faixaEntrega->getCepFinal())
            ->buildNextViolation('cepinicial_cepfinal_no_intervalo')
            ->setParameter('%cepinicial%', $faixaEntrega->getCepInicial())
            ->setParameter('%cepfinal%', $faixaEntrega->getCepFinal())
            ->assertRaised();
    }
}
