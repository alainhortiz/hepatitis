<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultadoPrueba
 *
 * @ORM\Table(name="resultado_prueba")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultadoPruebaRepository")
 */
class ResultadoPrueba
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
     * @ORM\Column(name="resultadoPrueba", type="string", length=20)
     */
    private $resultadoPrueba;

    /**
     * @ORM\ManyToOne(targetEntity="Prueba",inversedBy="resultadosPruebas")
     */
    protected $prueba;


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
     * Set resultadoPrueba
     *
     * @param string $resultadoPrueba
     *
     * @return ResultadoPrueba
     */
    public function setResultadoPrueba($resultadoPrueba)
    {
        $this->resultadoPrueba = $resultadoPrueba;

        return $this;
    }

    /**
     * Get resultadoPrueba
     *
     * @return string
     */
    public function getResultadoPrueba()
    {
        return $this->resultadoPrueba;
    }

    /**
     * Set prueba
     *
     * @param \AppBundle\Entity\Prueba $prueba
     *
     * @return ResultadoPrueba
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
}
