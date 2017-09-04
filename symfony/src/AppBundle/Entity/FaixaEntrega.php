<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * FaixaEntrega
 *
 * @ORM\Table(name="faixa_entrega")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FaixaEntregaRepository")
 * @UniqueEntity(fields= {"cepInicial", "cepFinal", "transportadora"}, message="intervalo_ja_cadastrado")
 * @ORM\HasLifecycleCallbacks
 */
class FaixaEntrega
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
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;
    
    /**
     * @var int
     *
     * @ORM\Column(name="cep_inicial", type="integer", nullable=false)
     */
    private $cepInicial;
    
    /**
     * @var int
     *
     * @ORM\Column(name="cep_final", type="integer", nullable=false)
     */
    private $cepFinal;
    
    /**
     * @var float
     *
     * @ORM\Column(name="peso_inicial", type="float", nullable=false)
     */
    private $pesoInicial;
    
    /**
     * @var float
     *
     * @ORM\Column(name="peso_final", type="float", nullable=false)
     */
    private $pesoFinal;
    
    /**
     * @var float
     *
     * @ORM\Column(name="valor_quilo", type="float", nullable=false)
     */
    private $valorQuilo;
    
    /**
     * @var float
     *
     * @ORM\Column(name="valor_quilo_adicional", type="float")
     */
    private $valorQuiloAdicional;
    
    /**
     * @var int
     *
     * @ORM\Column(name="prazo_entrega_inicial", type="integer")
     */
    private $prazoEntregaInicial;
    
    /**
     * @var int
     *
     * @ORM\Column(name="prazo_entrega_final", type="integer")
     */
    private $prazoEntregaFinal;
    
    /**
     * @var int
     *
     * @ORM\Column(name="prazo_entrega_adicional_por_peso", type="integer")
     */
    private $prazoEntregaAdicionalPorPeso;
    
    /**
     * @var float
     *
     * @ORM\Column(name="peso_para_prazo_adicional", type="float")
     */
    private $pesoParaPrazoAdicional;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Transportadora", inversedBy="faixasEntrega", cascade={"persist"})
     * @ORM\JoinColumn(name="transportadora_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $transportadora;

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
    
    
    public function __construct()
    {
        $this->cepInicial = 88888888;
        $this->cepFinal = 88888999;
        $this->pesoInicial = 1;
        $this->pesoFinal = 5;
        $this->valorQuilo = 5;
        $this->valorQuiloAdicional = 6.5;
        $this->prazoEntregaInicial = 5;
        $this->prazoEntregaFinal = 7;
        $this->prazoEntregaAdicionalPorPeso = 1;
        $this->pesoParaPrazoAdicional = 5;
    }

    public function __toString() {
        return ($this->nome != "") ? $this->nome : '';
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate() {
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
     * @return FaixaEntrega
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
     * Set cepInicial
     *
     * @param integer $cepInicial
     *
     * @return FaixaEntrega
     */
    public function setCepInicial($cepInicial)
    {
        $this->cepInicial = $cepInicial;

        return $this;
    }

    /**
     * Get cepInicial
     *
     * @return integer
     */
    public function getCepInicial()
    {
        return $this->cepInicial;
    }

    /**
     * Set cepFinal
     *
     * @param integer $cepFinal
     *
     * @return FaixaEntrega
     */
    public function setCepFinal($cepFinal)
    {
        $this->cepFinal = $cepFinal;

        return $this;
    }

    /**
     * Get cepFinal
     *
     * @return integer
     */
    public function getCepFinal()
    {
        return $this->cepFinal;
    }

    /**
     * Set pesoInicial
     *
     * @param float $pesoInicial
     *
     * @return FaixaEntrega
     */
    public function setPesoInicial($pesoInicial)
    {
        $this->pesoInicial = $pesoInicial;

        return $this;
    }

    /**
     * Get pesoInicial
     *
     * @return float
     */
    public function getPesoInicial()
    {
        return $this->pesoInicial;
    }

    /**
     * Set pesoFinal
     *
     * @param float $pesoFinal
     *
     * @return FaixaEntrega
     */
    public function setPesoFinal($pesoFinal)
    {
        $this->pesoFinal = $pesoFinal;

        return $this;
    }

    /**
     * Get pesoFinal
     *
     * @return float
     */
    public function getPesoFinal()
    {
        return $this->pesoFinal;
    }

    /**
     * Set valorQuilo
     *
     * @param float $valorQuilo
     *
     * @return FaixaEntrega
     */
    public function setValorQuilo($valorQuilo)
    {
        $this->valorQuilo = $valorQuilo;

        return $this;
    }

    /**
     * Get valorQuilo
     *
     * @return float
     */
    public function getValorQuilo()
    {
        return $this->valorQuilo;
    }

    /**
     * Set valorQuiloAdicional
     *
     * @param float $valorQuiloAdicional
     *
     * @return FaixaEntrega
     */
    public function setValorQuiloAdicional($valorQuiloAdicional)
    {
        $this->valorQuiloAdicional = $valorQuiloAdicional;

        return $this;
    }

    /**
     * Get valorQuiloAdicional
     *
     * @return float
     */
    public function getValorQuiloAdicional()
    {
        return $this->valorQuiloAdicional;
    }

    /**
     * Set prazoEntregaInicial
     *
     * @param integer $prazoEntregaInicial
     *
     * @return FaixaEntrega
     */
    public function setPrazoEntregaInicial($prazoEntregaInicial)
    {
        $this->prazoEntregaInicial = $prazoEntregaInicial;

        return $this;
    }

    /**
     * Get prazoEntregaInicial
     *
     * @return integer
     */
    public function getPrazoEntregaInicial()
    {
        return $this->prazoEntregaInicial;
    }

    /**
     * Set prazoEntregaFinal
     *
     * @param integer $prazoEntregaFinal
     *
     * @return FaixaEntrega
     */
    public function setPrazoEntregaFinal($prazoEntregaFinal)
    {
        $this->prazoEntregaFinal = $prazoEntregaFinal;

        return $this;
    }

    /**
     * Get prazoEntregaFinal
     *
     * @return integer
     */
    public function getPrazoEntregaFinal()
    {
        return $this->prazoEntregaFinal;
    }

    /**
     * Set prazoEntregaAdicionalPorPeso
     *
     * @param integer $prazoEntregaAdicionalPorPeso
     *
     * @return FaixaEntrega
     */
    public function setPrazoEntregaAdicionalPorPeso($prazoEntregaAdicionalPorPeso)
    {
        $this->prazoEntregaAdicionalPorPeso = $prazoEntregaAdicionalPorPeso;

        return $this;
    }

    /**
     * Get prazoEntregaAdicionalPorPeso
     *
     * @return integer
     */
    public function getPrazoEntregaAdicionalPorPeso()
    {
        return $this->prazoEntregaAdicionalPorPeso;
    }

    /**
     * Set pesoParaPrazoAdicional
     *
     * @param float $pesoParaPrazoAdicional
     *
     * @return FaixaEntrega
     */
    public function setPesoParaPrazoAdicional($pesoParaPrazoAdicional)
    {
        $this->pesoParaPrazoAdicional = $pesoParaPrazoAdicional;

        return $this;
    }

    /**
     * Get pesoParaPrazoAdicional
     *
     * @return float
     */
    public function getPesoParaPrazoAdicional()
    {
        return $this->pesoParaPrazoAdicional;
    }

    /**
     * Set Transportadora
     *
     * @param \AppBundle\Entity\Transportadora $transportadora
     *
     * @return FaixaEntrega
     */
    public function setTransportadora(\AppBundle\Entity\Transportadora $transportadora = null)
    {
        $this->transportadora = $transportadora;

        return $this;
    }

    /**
     * Get Transportadora
     *
     * @return \AppBundle\Entity\Transportadora
     */
    public function getTransportadora()
    {
        return $this->transportadora;
    }
    
        /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Midia
     */
    public function setUpdatedAt($updatedAt)
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
    public function setCreatedAt($createdAt)
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
