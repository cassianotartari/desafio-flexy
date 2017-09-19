<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transportadora
 *
 * @ORM\Table(name="transportadora")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransportadoraRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Transportadora
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
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, unique=true)
     */
    private $nome;
    
    /**
     * @ORM\Column(name="is_ativa", type="boolean", nullable=true)
     */
    private $isAtiva;
    
    /**
     * Inverse Side
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FaixaEntrega", mappedBy="transportadora", cascade={"all"})
     */
    private $faixasEntrega;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;
    
    public function __toString()
    {
        return ($this->nome != "") ? $this->nome : '';
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
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
     * Set nome
     *
     * @param string $nome
     *
     * @return Transportadora
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isAtiva = true;
        $this->faixasEntrega = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set isAtiva
     *
     * @param boolean $isAtiva
     *
     * @return Transportadora
     */
    public function setIsAtiva($isAtiva)
    {
        $this->isAtiva = $isAtiva;

        return $this;
    }

    /**
     * Get isAtiva
     *
     * @return boolean
     */
    public function getIsAtiva()
    {
        return $this->isAtiva;
    }

    /**
     * Add faixasEntrega
     *
     * @param \AppBundle\Entity\FaixaEntrega $faixasEntrega
     *
     * @return Transportadora
     */
    public function addFaixasEntrega(\AppBundle\Entity\FaixaEntrega $faixasEntrega)
    {
        $this->faixasEntrega[] = $faixasEntrega;

        return $this;
    }

    /**
     * Remove faixasEntrega
     *
     * @param \AppBundle\Entity\FaixaEntrega $faixasEntrega
     */
    public function removeFaixasEntrega(\AppBundle\Entity\FaixaEntrega $faixasEntrega)
    {
        $this->faixasEntrega->removeElement($faixasEntrega);
    }

    /**
     * Get faixasEntrega
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFaixasEntrega()
    {
        return $this->faixasEntrega;
    }
    
    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Midia
     */
    public function setUpdatedAt(\Datetime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Midia
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
}
