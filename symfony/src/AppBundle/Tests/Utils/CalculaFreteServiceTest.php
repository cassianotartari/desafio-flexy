<?php

namespace AppBundle\Tests\Utils;

use AppBundle\Tests\ContainerAndFixturesAwareUnitTestCase;
use AppBundle\Utils\CalculaFreteService;
use AppBundle\Repository\FaixaEntregaRepository;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Entity\CalculoFrete;

class CalculaFreteServiceTest extends ContainerAndFixturesAwareUnitTestCase
{
    /**
     *
     * @var CalculaFreteService
     */
    private $calculaFrete;
    
    /**
     *
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;
    
    public function setUp()
    {
        parent::setUp();

        $this->addFixture(new \AppBundle\DataFixtures\ORM\Fixtures());
        $this->executeFixtures();
        
        /* @var $tokenStorage TokenStorage */
        $tokenStorage = $this->get('security.token_storage');
        /* @var $userManager \FOS\UserBundle\Entity\UserManager */
        $userManager = $this->get('fos_user.user_manager');
        $this->user = $userManager->findUserByUsername('admin');
        $token = new UsernamePasswordToken($this->user, null, 'main', array('ROLE_ADMIN', 'ROLE_SONATA_ADMIN'));
        $tokenStorage->setToken($token);
    }
    
    public function testCalculaFretePorCepEPeso()
    {
        $this->calculaFrete = $this->get('app.calcula_frete_service');
        
        $calculosFreteResposta = $this->calculaFrete->calculaFretePorCepEPeso(88888888, 5);
        
        $this->assertEquals(2, count($calculosFreteResposta));
        
        /* @var $calculo1 CalculoFrete */
        $calculo1 = $calculosFreteResposta[0];
                
        $this->assertEquals(88888888, $calculo1->getCep());
        $this->assertEquals(5, $calculo1->getPeso());
        $this->assertEquals($this->user, $calculo1->getUsuario());
        $this->assertEquals(25, $calculo1->getValor());
        
        /* @var $calculo2 CalculoFrete */
        $calculo2 = $calculosFreteResposta[1];
        
        $this->assertEquals(88888888, $calculo2->getCep());
        $this->assertEquals(5, $calculo2->getPeso());
        $this->assertEquals($this->user, $calculo2->getUsuario());
        $this->assertEquals(30, $calculo2->getValor());
    }
}
