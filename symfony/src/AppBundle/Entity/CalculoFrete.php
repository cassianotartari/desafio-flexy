<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calculo Frete
 *
 * @ORM\Table(name="calculo_frete")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
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
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $usuario;
    
    /**
     * @var \AppBundle\Entity\Transportadora
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Transportadora")
     * @ORM\JoinColumn(name="transportadora_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $transportadora;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }
    
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
        $this->cep = $cep;
        
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CalculoFrete
     */
    public function setCreatedAt(\Datetime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set usuario
     *
     * @param \Application\Sonata\UserBundle\Entity\User $usuario
     *
     * @return CalculoFrete
     */
    public function setUsuario(\Application\Sonata\UserBundle\Entity\User $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set transportadora
     *
     * @param \AppBundle\Entity\Transportadora $transportadora
     *
     * @return CalculoFrete
     */
    public function setTransportadora(\AppBundle\Entity\Transportadora $transportadora)
    {
        $this->transportadora = $transportadora;

        return $this;
    }

    /**
     * Get transportadora
     *
     * @return \AppBundle\Entity\Transportadora
     */
    public function getTransportadora()
    {
        return $this->transportadora;
    }
}
