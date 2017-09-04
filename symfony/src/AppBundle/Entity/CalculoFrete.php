<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calculo Frete
 *
 * @ORM\Table(name="calculo_frete")
 * @ORM\Entity()
 */
class CalculoFrete
{
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var int
     * @ORM\Column(name="cep", type="integer", nullable=false)
     */
    private $cep;
    
    /**
     * @var float
     * @ORM\Column(name="peso_inicial", type="float", nullable=false)
     */
    private $peso;
    
    /**
     * @var float
     * @ORM\Column(name="valor", type="float", nullable=false)
     */
    private $valor;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get cep
     *
     * @return integer
     */
    public function getCep()
    {
        return $this->cep;
    }
    
    /**
     * Get peso
     *
     * @return float
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set cep
     *
     * @param int $cep
     *
     * @return CalculoFrete
     */
    public function setCep($cep)
    {
        $this->cepInicial = $cep;
        
        return $this;
    }

    /**
     * Set peso
     *
     * @param float $peso
     *
     * @return CalculoFrete
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;
        
        return $this;
    }

    /**
     * Set valor
     *
     * @param float $valor
     *
     * @return CalculoFrete
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        
        return $this;
    }
}
