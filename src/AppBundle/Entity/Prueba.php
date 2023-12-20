<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Prueba
 *
 * @ORM\Table(name="prueba")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PruebaRepository")
 */
class Prueba
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
     * @ORM\Column(name="nombre", type="string", length=100, unique=true)
     */
    private $nombre;

    /**
     * @var bool
     *
     * @ORM\Column(name="valor", type="boolean")
     */
    private $valor;

    /**
     * @var bool
     *
     * @ORM\Column(name="menor", type="boolean", nullable=true)
     */
    private $menor;

    /**
     * @ORM\ManyToOne(targetEntity="TipoEtiologia",inversedBy="pruebas")
     */
    protected $tipoEtiologia;


    /**
     * @ORM\OneToMany(targetEntity="ResultadoPrueba", mappedBy="prueba")
     */
    private $resultadosPruebas;

    /**
     * Resultado Prueba constructor.
     */
    public function __construct()
    {
        $this->resultadosPruebas = new ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Prueba
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }


    /**
     * Set valor
     *
     * @param boolean $valor
     *
     * @return Prueba
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return boolean
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set tipoEtiologia
     *
     * @param \AppBundle\Entity\TipoEtiologia $tipoEtiologia
     *
     * @return Prueba
     */
    public function setTipoEtiologia(\AppBundle\Entity\TipoEtiologia $tipoEtiologia = null)
    {
        $this->tipoEtiologia = $tipoEtiologia;

        return $this;
    }

    /**
     * Get tipoEtiologia
     *
     * @return \AppBundle\Entity\TipoEtiologia
     */
    public function getTipoEtiologia()
    {
        return $this->tipoEtiologia;
    }

    public function cantidadResultados()
    {
        return count($this->resultadosPruebas);
    }


    /**
     * Set menor
     *
     * @param boolean $menor
     *
     * @return Prueba
     */
    public function setMenor($menor)
    {
        $this->menor = $menor;

        return $this;
    }

    /**
     * Get menor
     *
     * @return boolean
     */
    public function getMenor()
    {
        return $this->menor;
    }

    /**
     * Add resultadosPrueba
     *
     * @param \AppBundle\Entity\ResultadoPrueba $resultadosPrueba
     *
     * @return Prueba
     */
    public function addResultadosPrueba(\AppBundle\Entity\ResultadoPrueba $resultadosPrueba)
    {
        $this->resultadosPruebas[] = $resultadosPrueba;

        return $this;
    }

    /**
     * Remove resultadosPrueba
     *
     * @param \AppBundle\Entity\ResultadoPrueba $resultadosPrueba
     */
    public function removeResultadosPrueba(\AppBundle\Entity\ResultadoPrueba $resultadosPrueba)
    {
        $this->resultadosPruebas->removeElement($resultadosPrueba);
    }

    /**
     * Get resultadosPruebas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResultadosPruebas()
    {
        return $this->resultadosPruebas;
    }
}
