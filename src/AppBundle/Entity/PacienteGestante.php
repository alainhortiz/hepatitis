<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PacienteGestante
 *
 * @ORM\Table(name="paciente_gestante")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacienteGestanteRepository")
 */
class PacienteGestante
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
     *
     * @ORM\Column(name="semanaGestacional", type="integer")
     */
    private $semanaGestacional;

    /**
     * @var int
     *
     * @ORM\Column(name="diasGestacional", type="integer")
     */
    private $diasGestacional;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEdadGestacional", type="date")
     */
    private $fechaEdadGestacional;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="Paciente" ,inversedBy="pacienteGestante")
     * @ORM\JoinColumn(name="paciente_id" , referencedColumnName="id")
     */
    private $paciente;

    /**
     * @ORM\OneToMany(targetEntity="GestanteHijo", mappedBy="pacienteGestante", cascade={"remove"})
     */
    private $gestanteHijos;

    /**
     * PacienteGestante constructor.
     */
    public function __construct()
    {
        $this->gestanteHijos = new ArrayCollection();
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
     * Set fechaEdadGestacional
     *
     * @param \DateTime $fechaEdadGestacional
     *
     * @return PacienteGestante
     */
    public function setFechaEdadGestacional($fechaEdadGestacional)
    {
        $this->fechaEdadGestacional = $fechaEdadGestacional;

        return $this;
    }

    /**
     * Get fechaEdadGestacional
     *
     * @return \DateTime
     */
    public function getFechaEdadGestacional()
    {
        return $this->fechaEdadGestacional;
    }

    /**
     * Set semanaGestacional
     *
     * @param integer $semanaGestacional
     *
     * @return PacienteGestante
     */
    public function setSemanaGestacional($semanaGestacional)
    {
        $this->semanaGestacional = $semanaGestacional;

        return $this;
    }

    /**
     * Get semanaGestacional
     *
     * @return integer
     */
    public function getSemanaGestacional()
    {
        return $this->semanaGestacional;
    }

    /**
     * Set diasGestacional
     *
     * @param integer $diasGestacional
     *
     * @return PacienteGestante
     */
    public function setDiasGestacional($diasGestacional)
    {
        $this->diasGestacional = $diasGestacional;

        return $this;
    }

    /**
     * Get diasGestacional
     *
     * @return integer
     */
    public function getDiasGestacional()
    {
        return $this->diasGestacional;
    }

    /**
     * Add gestanteHijo
     *
     * @param \AppBundle\Entity\GestanteHijo $gestanteHijo
     *
     * @return PacienteGestante
     */
    public function addGestanteHijo(\AppBundle\Entity\GestanteHijo $gestanteHijo)
    {
        $this->gestanteHijos[] = $gestanteHijo;

        return $this;
    }

    /**
     * Remove gestanteHijo
     *
     * @param \AppBundle\Entity\GestanteHijo $gestanteHijo
     */
    public function removeGestanteHijo(\AppBundle\Entity\GestanteHijo $gestanteHijo)
    {
        $this->gestanteHijos->removeElement($gestanteHijo);
    }

    /**
     * Get gestanteHijos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGestanteHijos()
    {
        return $this->gestanteHijos;
    }

    /**
     * Set paciente
     *
     * @param \AppBundle\Entity\Paciente $paciente
     *
     * @return PacienteGestante
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

    public function cantidadHijos()
    {
        return count($this->gestanteHijos);
    }
}
