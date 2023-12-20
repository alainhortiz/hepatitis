<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * GestanteHijo
 *
 * @ORM\Table(name="gestante_hijo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GestanteHijoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class GestanteHijo
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primerApellido", type="string", length=100)
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoApellido", type="string", length=100)
     */
    private $segundoApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string",columnDefinition="ENUM('Femenino','Masculino')" ,length=20)
     */
    private $sexo;

    /**
     * @var bool
     *
     * @ORM\Column(name="inmunoglobulina", type="boolean")
     */
    private $inmunoglobulina;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechainmunoglobulina", type="date", nullable=true)
     */
    private $fechainmunoglobulina;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaNacimiento", type="date")
     */
    private $fechaNacimiento;

    /**
     * @var bool
     *
     * @ORM\Column(name="alta", type="boolean", nullable=true)
     */
    private $alta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAlta", type="date", nullable=true)
     */
    private $fechaAlta;

    /**
     * @ORM\OneToMany(targetEntity="HijoVacuna", mappedBy="gestanteHijo", cascade={"remove"})
     * @OrderBy({"id" = "ASC"})
     */
    private $hijoVacunas;

    /**
     * @ORM\OneToMany(targetEntity="HijoPrueba", mappedBy="gestanteHijo", cascade={"remove"})
     * @OrderBy({"id" = "ASC"})
     */
    private $hijoPruebas;

    /**
     * Hijos constructor.
     */
    public function __construct()
    {
        $this->hijoVacunas = new ArrayCollection();
        $this->hijoPruebas = new ArrayCollection();
    }


    /**
     * @var string
     *
     * @ORM\Column(name="fonNombre", type="string", length=5)
     */
    private $fonNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="fonPrimerApellido", type="string", length=5)
     */
    private $fonPrimerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="fonSegundoApellido", type="string", length=5)
     */
    private $fonSegundoApellido;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PacienteGestante",inversedBy="gestanteHijos")
     */
    protected $pacienteGestante;


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
     * @return GestanteHijo
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
     * Set primerApellido
     *
     * @param string $primerApellido
     *
     * @return GestanteHijo
     */
    public function setPrimerApellido($primerApellido)
    {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    /**
     * Get primerApellido
     *
     * @return string
     */
    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    /**
     * Set segundoApellido
     *
     * @param string $segundoApellido
     *
     * @return GestanteHijo
     */
    public function setSegundoApellido($segundoApellido)
    {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    /**
     * Get segundoApellido
     *
     * @return string
     */
    public function getSegundoApellido()
    {
        return $this->segundoApellido;
    }

    /**
     * Get nombreCompleto
     *
     * @return string
     */
    public function nombreCompleto()
    {
        return $this->getNombre() . ' ' . $this->getPrimerApellido() . ' ' . $this->getSegundoApellido();
    }

    /**
     * Set inmunoglobulina
     *
     * @param boolean $inmunoglobulina
     *
     * @return GestanteHijo
     */
    public function setInmunoglobulina($inmunoglobulina)
    {
        $this->inmunoglobulina = $inmunoglobulina;

        return $this;
    }

    /**
     * Get inmunoglobulina
     *
     * @return bool
     */
    public function getInmunoglobulina()
    {
        return $this->inmunoglobulina;
    }

    /**
     * Set fechainmunoglobulina
     *
     * @param \DateTime $fechainmunoglobulina
     *
     * @return GestanteHijo
     */
    public function setFechainmunoglobulina($fechainmunoglobulina)
    {
        $this->fechainmunoglobulina = $fechainmunoglobulina;

        return $this;
    }

    /**
     * Get fechainmunoglobulina
     *
     * @return \DateTime
     */
    public function getFechainmunoglobulina()
    {
        return $this->fechainmunoglobulina;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     *
     * @return GestanteHijo
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set paciente
     *
     * @param \AppBundle\Entity\Paciente $paciente
     *
     * @return GestanteHijo
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
     * Set pacienteGestante
     *
     * @param \AppBundle\Entity\PacienteGestante $pacienteGestante
     *
     * @return GestanteHijo
     */
    public function setPacienteGestante(\AppBundle\Entity\PacienteGestante $pacienteGestante = null)
    {
        $this->pacienteGestante = $pacienteGestante;

        return $this;
    }

    /**
     * Get pacienteGestante
     *
     * @return \AppBundle\Entity\PacienteGestante
     */
    public function getPacienteGestante()
    {
        return $this->pacienteGestante;
    }


    /**
     * Set fonNombre
     *
     * @param string $fonNombre
     *
     * @return GestanteHijo
     */
    public function setFonNombre($fonNombre)
    {
        $this->fonNombre = $fonNombre;

        return $this;
    }

    /**
     * Get fonNombre
     *
     * @return string
     */
    public function getFonNombre()
    {
        return $this->fonNombre;
    }

    /**
     * Set fonPrimerApellido
     *
     * @param string $fonPrimerApellido
     *
     * @return GestanteHijo
     */
    public function setFonPrimerApellido($fonPrimerApellido)
    {
        $this->fonPrimerApellido = $fonPrimerApellido;

        return $this;
    }

    /**
     * Get fonPrimerApellido
     *
     * @return string
     */
    public function getFonPrimerApellido()
    {
        return $this->fonPrimerApellido;
    }

    /**
     * Set fonSegundoApellido
     *
     * @param string $fonSegundoApellido
     *
     * @return GestanteHijo
     */
    public function setFonSegundoApellido($fonSegundoApellido)
    {
        $this->fonSegundoApellido = $fonSegundoApellido;

        return $this;
    }

    /**
     * Get fonSegundoApellido
     *
     * @return string
     */
    public function getFonSegundoApellido()
    {
        return $this->fonSegundoApellido;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setFonNombreValue()
    {
        $this->fonNombre = metaphone($this->nombre,5);
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setFonPrimerApellidoValue()
    {
        $this->fonPrimerApellido = metaphone($this->primerApellido,5);
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setFonSegundoApellidoValue()
    {
        $this->fonSegundoApellido = metaphone($this->segundoApellido,5);
    }



    /**
     * Set alta
     *
     * @param boolean $alta
     *
     * @return GestanteHijo
     */
    public function setAlta($alta)
    {
        $this->alta = $alta;

        return $this;
    }

    /**
     * Get alta
     *
     * @return boolean
     */
    public function getAlta()
    {
        return $this->alta;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     *
     * @return GestanteHijo
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Add hijoVacuna
     *
     * @param \AppBundle\Entity\HijoVacuna $hijoVacuna
     *
     * @return GestanteHijo
     */
    public function addHijoVacuna(\AppBundle\Entity\HijoVacuna $hijoVacuna)
    {
        $this->hijoVacunas[] = $hijoVacuna;

        return $this;
    }

    /**
     * Remove hijoVacuna
     *
     * @param \AppBundle\Entity\HijoVacuna $hijoVacuna
     */
    public function removeHijoVacuna(\AppBundle\Entity\HijoVacuna $hijoVacuna)
    {
        $this->hijoVacunas->removeElement($hijoVacuna);
    }

    /**
     * Get hijoVacunas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHijoVacunas()
    {
        return $this->hijoVacunas;
    }

    /**
     * Add hijoPrueba
     *
     * @param \AppBundle\Entity\HijoPrueba $hijoPrueba
     *
     * @return GestanteHijo
     */
    public function addHijoPrueba(\AppBundle\Entity\HijoPrueba $hijoPrueba)
    {
        $this->hijoPruebas[] = $hijoPrueba;

        return $this;
    }

    /**
     * Remove hijoPrueba
     *
     * @param \AppBundle\Entity\HijoPrueba $hijoPrueba
     */
    public function removeHijoPrueba(\AppBundle\Entity\HijoPrueba $hijoPrueba)
    {
        $this->hijoPruebas->removeElement($hijoPrueba);
    }

    /**
     * Get hijoPruebas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHijoPruebas()
    {
        return $this->hijoPruebas;
    }

    public function cantidadDosis()
    {
        return count($this->hijoVacunas);
    }

    public function cantidadPruebas()
    {
        return count($this->hijoPruebas);
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return GestanteHijo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

}
