<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TotalPoblacion
 *
 * @ORM\Table(name="total_poblacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TotalPoblacionRepository")
 */
class TotalPoblacion
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
     * @ORM\Column(name="year", type="integer", unique=true)
     */
    private $year;

    /**
     * @var int
     *
     * @ORM\Column(name="total", type="integer",nullable=true)
     */
    private $total = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="totalFemenino", type="integer",nullable=true)
     */
    private $totalFemenino = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="totalMasculino", type="integer",nullable=true)
     */
    private $totalMasculino = 0;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return TotalPoblacion
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set total
     *
     * @param integer $total
     *
     * @return TotalPoblacion
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set totalFemenino
     *
     * @param integer $totalFemenino
     *
     * @return TotalPoblacion
     */
    public function setTotalFemenino($totalFemenino)
    {
        $this->totalFemenino = $totalFemenino;

        return $this;
    }

    /**
     * Get totalFemenino
     *
     * @return integer
     */
    public function getTotalFemenino()
    {
        return $this->totalFemenino;
    }

    /**
     * Set totalMasculino
     *
     * @param integer $totalMasculino
     *
     * @return TotalPoblacion
     */
    public function setTotalMasculino($totalMasculino)
    {
        $this->totalMasculino = $totalMasculino;

        return $this;
    }

    /**
     * Get totalMasculino
     *
     * @return integer
     */
    public function getTotalMasculino()
    {
        return $this->totalMasculino;
    }
}
