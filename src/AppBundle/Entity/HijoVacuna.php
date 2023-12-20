<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HijoVacuna
 *
 * @ORM\Table(name="hijo_vacuna")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HijoVacunaRepository")
 */
class HijoVacuna
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
     * @ORM\Column(name="fechaVacunaPrimera", type="date")
     */
    private $fechaVacunaPrimera;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaVacunaSegunda", type="date", nullable=true)
     */
    private $fechaVacunaSegunda;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaVacunaTercera", type="date", nullable=true)
     */
    private $fechaVacunaTercera;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaReactivacion", type="date", nullable=true)
     */
    private $fechaReactivacion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GestanteHijo",inversedBy="hijoVacunas")
     */
    protected $gestanteHijo;


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
     * Set fechaVacunaPrimera
     *
     * @param \DateTime $fechaVacunaPrimera
     *
     * @return HijoVacuna
     */
    public function setFechaVacunaPrimera($fechaVacunaPrimera)
    {
        $this->fechaVacunaPrimera = $fechaVacunaPrimera;

        return $this;
    }

    /**
     * Get fechaVacunaPrimera
     *
     * @return \DateTime
     */
    public function getFechaVacunaPrimera()
    {
        return $this->fechaVacunaPrimera;
    }

    /**
     * Set fechaVacunaSegunda
     *
     * @param \DateTime $fechaVacunaSegunda
     *
     * @return HijoVacuna
     */
    public function setFechaVacunaSegunda($fechaVacunaSegunda)
    {
        $this->fechaVacunaSegunda = $fechaVacunaSegunda;

        return $this;
    }

    /**
     * Get fechaVacunaSegunda
     *
     * @return \DateTime
     */
    public function getFechaVacunaSegunda()
    {
        return $this->fechaVacunaSegunda;
    }

    /**
     * Set fechaVacunaTercera
     *
     * @param \DateTime $fechaVacunaTercera
     *
     * @return HijoVacuna
     */
    public function setFechaVacunaTercera($fechaVacunaTercera)
    {
        $this->fechaVacunaTercera = $fechaVacunaTercera;

        return $this;
    }

    /**
     * Get fechaVacunaTercera
     *
     * @return \DateTime
     */
    public function getFechaVacunaTercera()
    {
        return $this->fechaVacunaTercera;
    }

    /**
     * Set fechaReactivacion
     *
     * @param \DateTime $fechaReactivacion
     *
     * @return HijoVacuna
     */
    public function setFechaReactivacion($fechaReactivacion)
    {
        $this->fechaReactivacion = $fechaReactivacion;

        return $this;
    }

    /**
     * Get fechaReactivacion
     *
     * @return \DateTime
     */
    public function getFechaReactivacion()
    {
        return $this->fechaReactivacion;
    }

    /**
     * Set gestanteHijo
     *
     * @param \AppBundle\Entity\GestanteHijo $gestanteHijo
     *
     * @return HijoVacuna
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

    public function cantidadVacunas()
    {
        if($this->fechaReactivacion)
            return 4;
        if($this->fechaVacunaTercera)
            return 3;
        if($this->fechaVacunaSegunda)
            return 2;
        if($this->fechaVacunaPrimera)
            return 1;
        return 0;
    }
}
