<?php
namespace AppBundle\Listener;

use AppBundle\Event\AfterCalculoFretePorEvent;
use Doctrine\ORM\EntityManager;

class CalculoFreteLogListener
{
    /**
     *
     * @var EntityManager
     */
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function onCalculoFrete(AfterCalculoFretePorEvent $event)
    {
        $fretes = $event->getFretesCalculados();
        foreach ($fretes as $frete) {
            $this->em->persist($frete);
        }
        $this->em->flush();
    }
}
