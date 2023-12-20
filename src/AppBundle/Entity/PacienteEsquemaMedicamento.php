<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PacienteEsquemaMedicamento
 *
 * @ORM\Table(name="paciente_esquema_medicamento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacienteEsquemaMedicamentoRepository")
 */
class PacienteEsquemaMedicamento
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
     * @ORM\Column(name="fechaInicio", type="date")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFinal", type="date", nullable=true)
     */
    private $fechaFinal;

    /**
     * @ORM\ManyToOne(targetEntity="Paciente",inversedBy="medicamentoEsquemas")
     */
    protected $paciente;

    /**
     * @ORM\ManyToMany(targetEntity="Medicamento")
     * @ORM\JoinTable(name="esquemamedicamento_medicamento",
     *     joinColumns={@ORM\JoinColumn(name="pacienteEsquemaMedicamento_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="medicamento_id", referencedColumnName="id")}
     * )
     */
    private $medicamentos;

    /**
     * PacienteEsquemaMedicamento constructor.
     */
    public function __construct()
    {
        $this->medicamentos = new ArrayCollection();
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
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return PacienteEsquemaMedicamento
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set paciente
     *
     * @param \AppBundle\Entity\Paciente $paciente
     *
     * @return PacienteEsquemaMedicamento
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
     * Add medicamento
     *
     * @param \AppBundle\Entity\Medicamento $medicamento
     *
     * @return PacienteEsquemaMedicamento
     */
    public function addMedicamento(\AppBundle\Entity\Medicamento $medicamento)
    {
        $this->medicamentos[] = $medicamento;

        return $this;
    }

    /**
     * Remove medicamento
     *
     * @param \AppBundle\Entity\Medicamento $medicamento
     */
    public function removeMedicamento(\AppBundle\Entity\Medicamento $medicamento)
    {
        $this->medicamentos->removeElement($medicamento);
    }

    /**
     * Get medicamentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedicamentos()
    {
        return $this->medicamentos;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     *
     * @return PacienteEsquemaMedicamento
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
