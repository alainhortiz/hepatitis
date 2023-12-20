<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PacientePrueba
 *
 * @ORM\Table(name="paciente_prueba")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacientePruebaRepository")
 */
class PacientePrueba
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
     * @ORM\ManyToOne(targetEntity="Paciente",inversedBy="pacientePruebas")
     */
    protected $paciente;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Prueba",inversedBy="pacientePruebas")
     */
    protected $prueba;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ResultadoPrueba", inversedBy="pacientePruebas")
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
     * @return PacientePrueba
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
     * Set paciente
     *
     * @param \AppBundle\Entity\Paciente $paciente
     *
     * @return PacientePrueba
     */
    public function setPaciente(\AppBundle\Entity\Paciente $paciente = null)
    {
        $this->paciente = $paciente;

        return $this;
    }

    /**
     * Get paciente
     *
     * @return \AppBundle\Entity\Paciente
     */
    public function getPaciente()
    {
        return $this->paciente;
    }


    /**
     * Set valor
     *
     * @param integer $valor
     *
     * @return PacientePrueba
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }


    /**
     * Set prueba
     *
     * @param \AppBundle\Entity\Prueba $prueba
     *
     * @return PacientePrueba
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
     * @return PacientePrueba
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
