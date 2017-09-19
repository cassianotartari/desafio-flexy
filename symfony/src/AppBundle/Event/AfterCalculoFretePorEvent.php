<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class AfterCalculoFretePorEvent extends Event
{
    private $fretesCalculados;

    public function __construct($fretesCalculados)
    {
        $this->fretesCalculados = $fretesCalculados;
    }
    
    public function getFretesCalculados()
    {
        return $this->fretesCalculados;
    }

    public function setFretesCalculados($fretesCalculados)
    {
        $this->fretesCalculados = $fretesCalculados;
    }
}
