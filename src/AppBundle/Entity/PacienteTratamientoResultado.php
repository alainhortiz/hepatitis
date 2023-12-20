<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PacienteTratamientoResultado
 *
 * @ORM\Table(name="paciente_tratamiento_resultado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacienteTratamientoResultadoRepository")
 */
class PacienteTratamientoResultado
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFinal", type="date", nullable=true)
     */
    private $fechaFinal;


    /**
     * @ORM\ManyToOne(targetEntity="Paciente",inversedBy="tratamientoResultados")
     */
    protected $paciente;

    /**
     * @ORM\ManyToOne(targetEntity="EvolucionClinica",inversedBy="tratamientoResultados")
     */
    protected $evolucionClinica;

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
     * @return PacienteTratamientoResultado
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
     * @return PacienteTratamientoResultado
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
     * Set evolucionClinica
     *
     * @param \AppBundle\Entity\EvolucionClinica $evolucionClinica
     *
     * @return PacienteTratamientoResultado
     */
    public function setEvolucionClinica(\AppBundle\Entity\EvolucionClinica $evolucionClinica = null)
    {
        $this->evolucionClinica = $evolucionClinica;

        return $this;
    }

    /**
     * Get evolucionClinica
     *
     * @return \AppBundle\Entity\EvolucionClinica
     */
    public function getEvolucionClinica()
    {
        return $this->evolucionClinica;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     *
     * @return PacienteTratamientoResultado
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }
}
