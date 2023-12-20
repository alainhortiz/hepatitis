<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoinfeccionPaciente
 *
 * @ORM\Table(name="coinfeccion_paciente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoinfeccionPacienteRepository")
 */
class CoinfeccionPaciente
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
     * @ORM\ManyToOne(targetEntity="Paciente",inversedBy="coinfecciones")
     */
    protected $paciente;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Coinfeccion",inversedBy="pacienteCoinfecciones")
     */
    protected $coinfeccion;


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
     * @return CoinfeccionPaciente
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
     * @return CoinfeccionPaciente
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
     * Set coinfeccion
     *
     * @param \AppBundle\Entity\Coinfeccion $coinfeccion
     *
     * @return CoinfeccionPaciente
     */
    public function setCoinfeccion(\AppBundle\Entity\Coinfeccion $coinfeccion = null)
    {
        $this->coinfeccion = $coinfeccion;

        return $this;
    }

    /**
     * Get coinfeccion
     *
     * @return \AppBundle\Entity\Coinfeccion
     */
    public function getCoinfeccion()
    {
        return $this->coinfeccion;
    }
}
