<?php

namespace AppBundle\Tests\Validator;

use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;
use AppBundle\Validator\Constraints\CepNoIntervalo;
use AppBundle\Validator\Constraints\CepNoIntervaloValidator;
use AppBundle\Entity\FaixaEntrega;
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
    
    public static function setUpBeforeClass()
    {
        self::$kernel = new \AppKernel('dev', true);
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
        $em = $this->get('doctrine.orm.entity_manager');
        return new CepNoIntervaloValidator($em);
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
    
}
