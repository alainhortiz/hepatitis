<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * Paciente
 *
 * @ORM\Table(name="paciente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacienteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Paciente
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
     * @ORM\Column(name="carnetIdentidad", type="string", length=11)
     */
    private $carnetIdentidad;

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
     * @var int
     *
     * @ORM\Column(name="edad", type="integer")
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string",columnDefinition="ENUM('Femenino','Masculino')" ,length=20)
     */
    private $sexo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaDiagnostico", type="date")
     */
    private $fechaDiagnostico;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFallecimiento", type="date", nullable=true)
     */
    private $fechaFallecimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="direccionCarnet", type="string", length=255)
     */
    private $direccionCarnet;

    /**
     * @var bool
     *
     * @ORM\Column(name="gestante", type="boolean")
     */
    private $gestante;

    /**
     * @var bool
     *
     * @ORM\Column(name="transfusion", type="boolean")
     */
    private $transfusion;

    /**
     * @var string
     *
     * @ORM\Column(name="fonNombre", type="string", length=100)
     */
    private $fonNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="fonPrimerApellido", type="string", length=100)
     */
    private $fonPrimerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="fonSegundoApellido", type="string", length=100)
     */
    private $fonSegundoApellido;

    /**
     * @ORM\ManyToOne(targetEntity="EstadioHepatitis",inversedBy="pacientes")
     */
    protected $estadioHepatitis;

    /**
     * @ORM\ManyToOne(targetEntity="GrupoVulnerable",inversedBy="pacientes")
     */
    protected $grupoVulnerable;

    /**
     * @ORM\ManyToOne(targetEntity="Ocupacion",inversedBy="pacientes")
     */
    protected $ocupacion;

    /**
     * @ORM\ManyToOne(targetEntity="TipoHepatitis",inversedBy="pacientes")
     */
    protected $tipoHepatitis;

    /**
     * @ORM\ManyToOne(targetEntity="FormaInfeccion",inversedBy="pacientes")
     */
    protected $formaInfeccion;

    /**
     * @ORM\ManyToOne(targetEntity="Etiologia",inversedBy="pacientes")
     */
    protected $etiologia;

    /**
     * @ORM\ManyToOne(targetEntity="CausaFallecimiento",inversedBy="pacientes")
     */
    protected $causaFallecimiento;

    /**
     * @ORM\ManyToOne(targetEntity="FuentePesquisa",inversedBy="pacientes")
     */
    protected $fuentePesquisa;

    /**
     * @ORM\ManyToOne(targetEntity="MotivoFuentePesquisa", inversedBy="pacientes")
     */
    private $motivoFuentePesquisa;

    /**
     * @ORM\ManyToOne(targetEntity="Municipio",inversedBy="pacientes")
     */
    protected $municipioCarnet;

    /**
     * @ORM\ManyToOne(targetEntity="NivelEscolaridad",inversedBy="pacientes")
     */
    protected $nivelEscolaridad;

    /**
     * @ORM\ManyToOne(targetEntity="EstadoCivil",inversedBy="pacientes")
     */
    protected $estadoCivil;

    /**
     * @ORM\ManyToOne(targetEntity="ColorPiel",inversedBy="pacientes")
     */
    protected $colorPiel;

    /**
     * @ORM\ManyToOne(targetEntity="Unidad",inversedBy="pacientes")
     */
    protected $unidadAtencion;

    /**
     * @ORM\OneToMany(targetEntity="PacienteTratamientoResultado", mappedBy="paciente" , cascade={"remove"})
     * @OrderBy({"fecha" = "ASC"})
     */
    private $tratamientoResultados;

    /**
     * @ORM\OneToMany(targetEntity="PacienteDireccion", mappedBy="paciente" , cascade={"remove"})
     * @OrderBy({"id" = "ASC"})
     */
    private $residenciaDirecciones;

    /**
     * @ORM\OneToMany(targetEntity="PacientePrueba", mappedBy="paciente" , cascade={"remove"})
     */
    private $pacientePruebas;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="PacienteGestante" ,mappedBy="paciente" , cascade={"remove"})
     *
     */
    private $pacienteGestante;

    /**
     * @ORM\OneToMany(targetEntity="PacienteEsquemaMedicamento", mappedBy="paciente" , cascade={"remove"})
     */
    private $medicamentoEsquemas;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CoinfeccionPaciente", mappedBy="paciente" , cascade={"remove"})
     * @OrderBy({"fecha" = "ASC"})
     */
    private $coinfecciones;

    /**
     * @ORM\ManyToMany(targetEntity="AntecedentePatologico" )
     * @ORM\JoinTable(name="paciente_antecedentepatologico",
     *     joinColumns={@ORM\JoinColumn(name="paciente_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="antecedentePatologico_id", referencedColumnName="id")}
     * )
     */
    private $antecedentesPatologicos;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\OrientacionSexual" )
     * @ORM\JoinTable(name="paciente_orientacionsexual",
     *     joinColumns={@ORM\JoinColumn(name="paciente_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="orientacionSexual_id", referencedColumnName="id")}
     * )
     */
    private $orientacionesSexuales;

    /**
     * Paciente constructor.
     */
    public function __construct()
    {
        $this->tratamientoResultados = new ArrayCollection();
        $this->residenciaDirecciones = new ArrayCollection();
        $this->pacientePruebas = new ArrayCollection();
        $this->medicamentoEsquemas = new ArrayCollection();
        $this->coinfecciones = new ArrayCollection();
        $this->antecedentesPatologicos = new ArrayCollection();
        $this->orientacionesSexuales = new ArrayCollection();
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
     * Set carnetIdentidad
     *
     * @param string $carnetIdentidad
     *
     * @return Paciente
     */
    public function setCarnetIdentidad($carnetIdentidad)
    {
        $this->carnetIdentidad = $carnetIdentidad;

        return $this;
    }

    /**
     * Get carnetIdentidad
     *
     * @return string
     */
    public function getCarnetIdentidad()
    {
        return $this->carnetIdentidad;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Paciente
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
     * @return Paciente
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
     * @return Paciente
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
     * Set edad
     *
     * @param integer $edad
     *
     * @return Paciente
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return int
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Paciente
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

    /**
     * Set fechaDiagnostico
     *
     * @param \DateTime $fechaDiagnostico
     *
     * @return Paciente
     */
    public function setFechaDiagnostico($fechaDiagnostico)
    {
        $this->fechaDiagnostico = $fechaDiagnostico;

        return $this;
    }

    /**
     * Get fechaDiagnostico
     *
     * @return \DateTime
     */
    public function getFechaDiagnostico()
    {
        return $this->fechaDiagnostico;
    }

    /**
     * Set direccionCarnet
     *
     * @param string $direccionCarnet
     *
     * @return Paciente
     */
    public function setDireccionCarnet($direccionCarnet)
    {
        $this->direccionCarnet = $direccionCarnet;

        return $this;
    }

    /**
     * Get direccionCarnet
     *
     * @return string
     */
    public function getDireccionCarnet()
    {
        return $this->direccionCarnet;
    }

    /**
     * Set gestante
     *
     * @param boolean $gestante
     *
     * @return Paciente
     */
    public function setGestante($gestante)
    {
        $this->gestante = $gestante;

        return $this;
    }

    /**
     * Get gestante
     *
     * @return bool
     */
    public function getGestante()
    {
        return $this->gestante;
    }

    /**
     * Set transfusion
     *
     * @param boolean $transfusion
     *
     * @return Paciente
     */
    public function setTransfusion($transfusion)
    {
        $this->transfusion = $transfusion;

        return $this;
    }

    /**
     * Get transfusion
     *
     * @return bool
     */
    public function getTransfusion()
    {
        return $this->transfusion;
    }

    /**
     * Set estadioHepatitis
     *
     * @param \AppBundle\Entity\EstadioHepatitis $estadioHepatitis
     *
     * @return Paciente
     */
    public function setEstadioHepatitis(\AppBundle\Entity\EstadioHepatitis $estadioHepatitis = null)
    {
        $this->estadioHepatitis = $estadioHepatitis;

        return $this;
    }

    /**
     * Get estadioHepatitis
     *
     * @return \AppBundle\Entity\EstadioHepatitis
     */
    public function getEstadioHepatitis()
    {
        return $this->estadioHepatitis;
    }

    /**
     * Set grupoVulnerable
     *
     * @param \AppBundle\Entity\GrupoVulnerable $grupoVulnerable
     *
     * @return Paciente
     */
    public function setGrupoVulnerable(\AppBundle\Entity\GrupoVulnerable $grupoVulnerable = null)
    {
        $this->grupoVulnerable = $grupoVulnerable;

        return $this;
    }

    /**
     * Get grupoVulnerable
     *
     * @return \AppBundle\Entity\GrupoVulnerable
     */
    public function getGrupoVulnerable()
    {
        return $this->grupoVulnerable;
    }

    /**
     * Set ocupacion
     *
     * @param \AppBundle\Entity\Ocupacion $ocupacion
     *
     * @return Paciente
     */
    public function setOcupacion(\AppBundle\Entity\Ocupacion $ocupacion = null)
    {
        $this->ocupacion = $ocupacion;

        return $this;
    }

    /**
     * Get ocupacion
     *
     * @return \AppBundle\Entity\Ocupacion
     */
    public function getOcupacion()
    {
        return $this->ocupacion;
    }

    /**
     * Set tipoHepatitis
     *
     * @param \AppBundle\Entity\TipoHepatitis $tipoHepatitis
     *
     * @return Paciente
     */
    public function setTipoHepatitis(\AppBundle\Entity\TipoHepatitis $tipoHepatitis = null)
    {
        $this->tipoHepatitis = $tipoHepatitis;

        return $this;
    }

    /**
     * Get tipoHepatitis
     *
     * @return \AppBundle\Entity\TipoHepatitis
     */
    public function getTipoHepatitis()
    {
        return $this->tipoHepatitis;
    }

    /**
     * Set fuentePesquisa
     *
     * @param \AppBundle\Entity\FuentePesquisa $fuentePesquisa
     *
     * @return Paciente
     */
    public function setFuentePesquisa(\AppBundle\Entity\FuentePesquisa $fuentePesquisa = null)
    {
        $this->fuentePesquisa = $fuentePesquisa;

        return $this;
    }

    /**
     * Get fuentePesquisa
     *
     * @return \AppBundle\Entity\FuentePesquisa
     */
    public function getFuentePesquisa()
    {
        return $this->fuentePesquisa;
    }

    /**
     * Set municipioCarnet
     *
     * @param \AppBundle\Entity\Municipio $municipioCarnet
     *
     * @return Paciente
     */
    public function setMunicipioCarnet(\AppBundle\Entity\Municipio $municipioCarnet = null)
    {
        $this->municipioCarnet = $municipioCarnet;

        return $this;
    }

    /**
     * Get municipioCarnet
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipioCarnet()
    {
        return $this->municipioCarnet;
    }

    /**
     * Set nivelEscolaridad
     *
     * @param \AppBundle\Entity\NivelEscolaridad $nivelEscolaridad
     *
     * @return Paciente
     */
    public function setNivelEscolaridad(\AppBundle\Entity\NivelEscolaridad $nivelEscolaridad = null)
    {
        $this->nivelEscolaridad = $nivelEscolaridad;

        return $this;
    }

    /**
     * Get nivelEscolaridad
     *
     * @return \AppBundle\Entity\NivelEscolaridad
     */
    public function getNivelEscolaridad()
    {
        return $this->nivelEscolaridad;
    }

    /**
     * Set estadoCivil
     *
     * @param \AppBundle\Entity\EstadoCivil $estadoCivil
     *
     * @return Paciente
     */
    public function setEstadoCivil(\AppBundle\Entity\EstadoCivil $estadoCivil = null)
    {
        $this->estadoCivil = $estadoCivil;

        return $this;
    }

    /**
     * Get estadoCivil
     *
     * @return \AppBundle\Entity\EstadoCivil
     */
    public function getEstadoCivil()
    {
        return $this->estadoCivil;
    }

    /**
     * Set colorPiel
     *
     * @param \AppBundle\Entity\ColorPiel $colorPiel
     *
     * @return Paciente
     */
    public function setColorPiel(\AppBundle\Entity\ColorPiel $colorPiel = null)
    {
        $this->colorPiel = $colorPiel;

        return $this;
    }

    /**
     * Get colorPiel
     *
     * @return \AppBundle\Entity\ColorPiel
     */
    public function getColorPiel()
    {
        return $this->colorPiel;
    }

    /**
     * Set unidadAtencion
     *
     * @param \AppBundle\Entity\Unidad $unidadAtencion
     *
     * @return Paciente
     */
    public function setUnidadAtencion(\AppBundle\Entity\Unidad $unidadAtencion = null)
    {
        $this->unidadAtencion = $unidadAtencion;

        return $this;
    }

    /**
     * Get unidadAtencion
     *
     * @return \AppBundle\Entity\Unidad
     */
    public function getUnidadAtencion()
    {
        return $this->unidadAtencion;
    }

    /**
     * Add tratamientoResultado
     *
     * @param \AppBundle\Entity\PacienteTratamientoResultado $tratamientoResultado
     *
     * @return Paciente
     */
    public function addTratamientoResultado(\AppBundle\Entity\PacienteTratamientoResultado $tratamientoResultado)
    {
        $this->tratamientoResultados[] = $tratamientoResultado;

        return $this;
    }

    /**
     * Remove tratamientoResultado
     *
     * @param \AppBundle\Entity\PacienteTratamientoResultado $tratamientoResultado
     */
    public function removeTratamientoResultado(\AppBundle\Entity\PacienteTratamientoResultado $tratamientoResultado)
    {
        $this->tratamientoResultados->removeElement($tratamientoResultado);
    }

    /**
     * Get tratamientoResultados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTratamientoResultados()
    {
        return $this->tratamientoResultados;
    }

    /**
     * Add residenciaDireccione
     *
     * @param \AppBundle\Entity\PacienteDireccion $residenciaDireccione
     *
     * @return Paciente
     */
    public function addResidenciaDireccione(\AppBundle\Entity\PacienteDireccion $residenciaDireccione)
    {
        $this->residenciaDirecciones[] = $residenciaDireccione;

        return $this;
    }

    /**
     * Remove residenciaDireccione
     *
     * @param \AppBundle\Entity\PacienteDireccion $residenciaDireccione
     */
    public function removeResidenciaDireccione(\AppBundle\Entity\PacienteDireccion $residenciaDireccione)
    {
        $this->residenciaDirecciones->removeElement($residenciaDireccione);
    }

    /**
     * Get residenciaDirecciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResidenciaDirecciones()
    {
        return $this->residenciaDirecciones;
    }

    /**
     * Add pacientePrueba
     *
     * @param \AppBundle\Entity\PacientePrueba $pacientePrueba
     *
     * @return Paciente
     */
    public function addPacientePrueba(\AppBundle\Entity\PacientePrueba $pacientePrueba)
    {
        $this->pacientePruebas[] = $pacientePrueba;

        return $this;
    }

    /**
     * Remove pacientePrueba
     *
     * @param \AppBundle\Entity\PacientePrueba $pacientePrueba
     */
    public function removePacientePrueba(\AppBundle\Entity\PacientePrueba $pacientePrueba)
    {
        $this->pacientePruebas->removeElement($pacientePrueba);
    }

    /**
     * Get pacientePruebas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPacientePruebas()
    {
        return $this->pacientePruebas;
    }

    /**
     * Add medicamentoEsquema
     *
     * @param \AppBundle\Entity\PacienteEsquemaMedicamento $medicamentoEsquema
     *
     * @return Paciente
     */
    public function addMedicamentoEsquema(\AppBundle\Entity\PacienteEsquemaMedicamento $medicamentoEsquema)
    {
        $this->medicamentoEsquemas[] = $medicamentoEsquema;

        return $this;
    }

    /**
     * Remove medicamentoEsquema
     *
     * @param \AppBundle\Entity\PacienteEsquemaMedicamento $medicamentoEsquema
     */
    public function removeMedicamentoEsquema(\AppBundle\Entity\PacienteEsquemaMedicamento $medicamentoEsquema)
    {
        $this->medicamentoEsquemas->removeElement($medicamentoEsquema);
    }

    /**
     * Get medicamentoEsquemas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedicamentoEsquemas()
    {
        return $this->medicamentoEsquemas;
    }

    public function setMedicamentoEsquemas($esquemas)
    {
        $this->medicamentoEsquemas = $esquemas;
    }

    /**
     * Add antecedentesPatologico
     *
     * @param \AppBundle\Entity\AntecedentePatologico $antecedentesPatologico
     *
     * @return Paciente
     */
    public function addAntecedentesPatologico(\AppBundle\Entity\AntecedentePatologico $antecedentesPatologico)
    {
        $this->antecedentesPatologicos[] = $antecedentesPatologico;

        return $this;
    }

    /**
     * Remove antecedentesPatologico
     *
     * @param \AppBundle\Entity\AntecedentePatologico $antecedentesPatologico
     */
    public function removeAntecedentesPatologico(\AppBundle\Entity\AntecedentePatologico $antecedentesPatologico)
    {
        $this->antecedentesPatologicos->removeElement($antecedentesPatologico);
    }

    /**
     * Get antecedentesPatologicos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAntecedentesPatologicos()
    {
        return $this->antecedentesPatologicos;
    }

    public function setAntecedentesPatologicos($antecedentes)
    {
        $this->antecedentesPatologicos = $antecedentes;
    }

    /**
     * Set fonNombre
     *
     * @param string $fonNombre
     *
     * @return Paciente
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
     * @return Paciente
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
     * @return Paciente
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
     * Set motivoFuentePesquisa
     *
     * @param \AppBundle\Entity\MotivoFuentePesquisa $motivoFuentePesquisa
     *
     * @return Paciente
     */
    public function setMotivoFuentePesquisa(\AppBundle\Entity\MotivoFuentePesquisa $motivoFuentePesquisa = null)
    {
        $this->motivoFuentePesquisa = $motivoFuentePesquisa;

        return $this;
    }

    /**
     * Get motivoFuentePesquisa
     *
     * @return \AppBundle\Entity\MotivoFuentePesquisa
     */
    public function getMotivoFuentePesquisa()
    {
        return $this->motivoFuentePesquisa;
    }


    /**
     * Set pacienteGestante
     *
     * @param \AppBundle\Entity\PacienteGestante $pacienteGestante
     *
     * @return Paciente
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
     * Set fechaFallecimiento
     *
     * @param \DateTime $fechaFallecimiento
     *
     * @return Paciente
     */
    public function setFechaFallecimiento($fechaFallecimiento)
    {
        $this->fechaFallecimiento = $fechaFallecimiento;

        return $this;
    }

    /**
     * Get fechaFallecimiento
     *
     * @return \DateTime
     */
    public function getFechaFallecimiento()
    {
        return $this->fechaFallecimiento;
    }

    /**
     * Set etiologia
     *
     * @param \AppBundle\Entity\Etiologia $etiologia
     *
     * @return Paciente
     */
    public function setEtiologia(\AppBundle\Entity\Etiologia $etiologia = null)
    {
        $this->etiologia = $etiologia;

        return $this;
    }

    /**
     * Get etiologia
     *
     * @return \AppBundle\Entity\Etiologia
     */
    public function getEtiologia()
    {
        return $this->etiologia;
    }

    /**
     * Set causaFallecimiento
     *
     * @param \AppBundle\Entity\CausaFallecimiento $causaFallecimiento
     *
     * @return Paciente
     */
    public function setCausaFallecimiento(\AppBundle\Entity\CausaFallecimiento $causaFallecimiento = null)
    {
        $this->causaFallecimiento = $causaFallecimiento;

        return $this;
    }

    /**
     * Get causaFallecimiento
     *
     * @return \AppBundle\Entity\CausaFallecimiento
     */
    public function getCausaFallecimiento()
    {
        return $this->causaFallecimiento;
    }

    /**
     * Set formaInfeccion
     *
     * @param \AppBundle\Entity\FormaInfeccion $formaInfeccion
     *
     * @return Paciente
     */
    public function setFormaInfeccion(\AppBundle\Entity\FormaInfeccion $formaInfeccion = null)
    {
        $this->formaInfeccion = $formaInfeccion;

        return $this;
    }

    /**
     * Get formaInfeccion
     *
     * @return \AppBundle\Entity\FormaInfeccion
     */
    public function getFormaInfeccion()
    {
        return $this->formaInfeccion;
    }

    public function cantidadPruebas()
    {
        return count($this->pacientePruebas);
    }

    /**
     * Add coinfeccione
     *
     * @param \AppBundle\Entity\CoinfeccionPaciente $coinfeccione
     *
     * @return Paciente
     */
    public function addCoinfeccione(\AppBundle\Entity\CoinfeccionPaciente $coinfeccione)
    {
        $this->coinfecciones[] = $coinfeccione;

        return $this;
    }

    /**
     * Remove coinfeccione
     *
     * @param \AppBundle\Entity\CoinfeccionPaciente $coinfeccione
     */
    public function removeCoinfeccione(\AppBundle\Entity\CoinfeccionPaciente $coinfeccione)
    {
        $this->coinfecciones->removeElement($coinfeccione);
    }

    /**
     * Get coinfecciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCoinfecciones()
    {
        return $this->coinfecciones;
    }

    public function setCoinfecciones($coinfecciones)
    {
        $this->coinfecciones = $coinfecciones;
    }

    /**
     * Add orientacionesSexuale
     *
     * @param \AppBundle\Entity\OrientacionSexual $orientacionesSexuale
     *
     * @return Paciente
     */
    public function addOrientacionesSexuale(\AppBundle\Entity\OrientacionSexual $orientacionesSexuale)
    {
        $this->orientacionesSexuales[] = $orientacionesSexuale;

        return $this;
    }

    /**
     * Remove orientacionesSexuale
     *
     * @param \AppBundle\Entity\OrientacionSexual $orientacionesSexuale
     */
    public function removeOrientacionesSexuale(\AppBundle\Entity\OrientacionSexual $orientacionesSexuale)
    {
        $this->orientacionesSexuales->removeElement($orientacionesSexuale);
    }

    /**
     * Get orientacionesSexuales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrientacionesSexuales()
    {
        return $this->orientacionesSexuales;
    }
}
