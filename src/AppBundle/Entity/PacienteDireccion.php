<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PacienteDireccion
 *
 * @ORM\Table(name="paciente_direccion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacienteDireccionRepository")
 */
class PacienteDireccion
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
     * @ORM\Column(name="direccionResidencia", type="string", length=255)
     */
    private $direccionResidencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaResidencia", type="date")
     */
    private $fechaResidencia;

    /**
     * @ORM\ManyToOne(targetEntity="Paciente",inversedBy="residenciaDirecciones")
     */
    protected $paciente;

    /**
     * @ORM\ManyToOne(targetEntity="Municipio",inversedBy="pacienteDirecciones")
     */
    protected $municipio;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;


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
     * Set direccionResidencia
     *
     * @param string $direccionResidencia
     *
     * @return PacienteDireccion
     */
    public function setDireccionResidencia($direccionResidencia)
    {
        $this->direccionResidencia = $direccionResidencia;

        return $this;
    }

    /**
     * Get direccionResidencia
     *
     * @return string
     */
    public function getDireccionResidencia()
    {
        return $this->direccionResidencia;
    }

    /**
     * Set fechaResidencia
     *
     * @param \DateTime $fechaResidencia
     *
     * @return PacienteDireccion
     */
    public function setFechaResidencia($fechaResidencia)
    {
        $this->fechaResidencia = $fechaResidencia;

        return $this;
    }

    /**
     * Get fechaResidencia
     *
     * @return \DateTime
     */
    public function getFechaResidencia()
    {
        return $this->fechaResidencia;
    }


    /**
     * Set paciente
     *
     * @param \AppBundle\Entity\Paciente $paciente
     *
     * @return PacienteDireccion
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
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return PacienteDireccion
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return PacienteDireccion
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
