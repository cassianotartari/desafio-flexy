<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CalculoFreteAdminControllerTest extends WebTestCase
{
    /**
     *
     * @var User
     */
    private $user;
    
    /**
     *
     * @var Session
     */
    private $session;
    
    /**
     *
     * @var Cookie
     */
    private $cookie;
    
    /**
     *
     * @var Client
     */
    private $client = null;
    
    /**
     *
     * @var UsernamePasswordToken
     */
    private $token;
    
    /**
     *
     * @var Container
     */
    private $container;
    
    public static function setUpBeforeClass()
    {
        self::$kernel = new \AppKernel('test', true);
        self::$kernel->boot();
    }
    
    public function setUp()
    {
        parent::setUp();
        
        $this->client = static::createClient();
        
        $crawler = $this->client->request('GET', '/admin/login');
        $form = $crawler->selectButton('Entrar')->form();
        $this->client->submit($form, array('_username' => 'admin', '_password' => 'admin'));
    }

    public function testCalculaFrete()
    {
        $crawler = $this->client->request(
            'POST',
            '/admin/app/calculofrete/calcula-frete',
            array(
            'cep' => 88888888,
            'peso' => 5
        ),
        array(),
        array(
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        )
        );

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Transportadora A', $this->client->getResponse()->getContent());
        $this->assertContains('Transportadora B', $this->client->getResponse()->getContent());
        $this->assertContains('R$25,00', $this->client->getResponse()->getContent());
        $this->assertContains('R$30,00', $this->client->getResponse()->getContent());
    }
}
