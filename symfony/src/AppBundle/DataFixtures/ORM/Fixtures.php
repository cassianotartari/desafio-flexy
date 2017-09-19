<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\FaixaEntrega;
use AppBundle\Entity\Transportadora;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Sonata\UserBundle\Entity\User;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'admin');
        $user->setPassword($password);
        $user->setEmail('admin@desafioflexy.com');
        $user->setEnabled(true);
        $user->addRole('ROLE_ADMIN');
        $user->addRole('ROLE_SONATA_ADMIN');

        $manager->persist($user);
        
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

        
        $manager->persist($faixaEntrega);
        
        $transportadoraB = new Transportadora();
        $transportadoraB->setNome('Transportadora B');
        
        $faixaEntrega = new FaixaEntrega();
        $faixaEntrega->setNome('Faixa entrega 2');
        $faixaEntrega->setCepInicial(88888888);
        $faixaEntrega->setCepFinal(88888999);
        $faixaEntrega->setPesoInicial(1);
        $faixaEntrega->setPesoFinal(5);
        $faixaEntrega->setValorQuilo(6);
        $faixaEntrega->setValorQuiloAdicional(6.5);
        $faixaEntrega->setPrazoEntregaInicial(5);
        $faixaEntrega->setPrazoEntregaFinal(7);
        $faixaEntrega->setPrazoEntregaAdicionalPorPeso(1);
        $faixaEntrega->setPesoParaPrazoAdicional(5);
        $faixaEntrega->setTransportadora($transportadoraB);
        $manager->persist($faixaEntrega);
        
        
        $manager->flush();
    }
}
