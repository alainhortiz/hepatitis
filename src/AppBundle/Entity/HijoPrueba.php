<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HijoPrueba
 *
 * @ORM\Table(name="hijo_prueba")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HijoPruebaRepository")
 */
class HijoPrueba
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer", nullable=true)
     */
    private $valor;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GestanteHijo",inversedBy="hijoPruebas")
     */
    protected $gestanteHijo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Prueba",inversedBy="hijoPruebas")
     */
    protected $prueba;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ResultadoPrueba", inversedBy="hijoPruebas")
     */
    private $resultadoPrueba;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return HijoPrueba
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     *
     * @return HijoPrueba
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return int
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set gestanteHijo
     *
     * @param \AppBundle\Entity\GestanteHijo $gestanteHijo
     *
     * @return HijoPrueba
     */
    public function setGestanteHijo(\AppBundle\Entity\GestanteHijo $gestanteHijo = null)
    {
        $this->gestanteHijo = $gestanteHijo;

        return $this;
    }

    /**
     * Get gestanteHijo
     *
     * @return \AppBundle\Entity\GestanteHijo
     */
    public function getGestanteHijo()
    {
        return $this->gestanteHijo;
    }


    /**
     * Set prueba
     *
     * @param \AppBundle\Entity\Prueba $prueba
     *
     * @return HijoPrueba
     */
    public function setPrueba(\AppBundle\Entity\Prueba $prueba = null)
    {
        $this->prueba = $prueba;

        return $this;
    }

    /**
     * Get prueba
     *
     * @return \AppBundle\Entity\Prueba
     */
    public function getPrueba()
    {
        return $this->prueba;
    }

    /**
     * Set resultadoPrueba
     *
     * @param \AppBundle\Entity\ResultadoPrueba $resultadoPrueba
     *
     * @return HijoPrueba
     */
    public function setResultadoPrueba(\AppBundle\Entity\ResultadoPrueba $resultadoPrueba = null)
    {
        $this->resultadoPrueba = $resultadoPrueba;

        return $this;
    }

    /**
     * Get resultadoPrueba
     *
     * @return \AppBundle\Entity\ResultadoPrueba
     */
    public function getResultadoPrueba()
    {
        return $this->resultadoPrueba;
    }
}
