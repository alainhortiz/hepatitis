<?php

namespace AppBundle\Repository;

use AppBundle\Entity\PacienteDireccion;

/**
 * PacienteDireccionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PacienteDireccionRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarPacienteDireccion($data , $paciente)
    {
        try{
            $em = $this->getEntityManager();
            $direccion = new PacienteDireccion();
            $direccion->setDireccionResidencia(strtoupper($data['direccionResidencia']));

            $municipio = $em->getRepository('AppBundle:Municipio')->find($data['municipioResidencia']);
            $direccion->setMunicipio($municipio);

            $direccion->setFechaResidencia(new \DateTime('now'));
            $direccion->setPaciente($paciente);

            $direccion->setIsActive(1);

            $em->persist($direccion);
            $em->flush();
            $msg = $direccion;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al insertar la dirección de residencia';
        }

        return $msg;
    }


}
