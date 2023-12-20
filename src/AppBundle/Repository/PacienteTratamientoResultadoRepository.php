<?php

namespace AppBundle\Repository;

use AppBundle\Entity\PacienteTratamientoResultado;

/**
 * PacienteTratamientoResultadoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PacienteTratamientoResultadoRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarPacienteTratamientoResultado($paciente ,$evolucion)
    {
        try
        {
            $em = $this->getEntityManager();
            $evolucionClinica = $em->getRepository('AppBundle:EvolucionClinica')->findOneBy(array('id' => $evolucion));
            $resultadoTratamieno = new PacienteTratamientoResultado();
            $resultadoTratamieno->setEvolucionClinica($evolucionClinica);
            $resultadoTratamieno->setFecha($paciente->getFechaDiagnostico());
            $resultadoTratamieno->setPaciente($paciente);
            $em->persist($resultadoTratamieno);
            $em->flush();
            $msg = $resultadoTratamieno;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al insertar la evolución clínica del paciente';

        }
        return $msg;
    }

    public function agregarEvolucionesClinicas($paciente , $evolucionesClinicas)
    {
        try
        {
            $em = $this->getEntityManager();
            foreach ($evolucionesClinicas as $evolucion)
            {
                if($evolucion != ""){
                    $resultadoTratamiento = new PacienteTratamientoResultado();
                    $evolucionClinica = $em->getRepository('AppBundle:EvolucionClinica')->find($evolucion['idEvolucionClinica']);
                    $resultadoTratamiento->setFecha(new \DateTime($evolucion['fecha']));
                    $resultadoTratamiento->setEvolucionClinica($evolucionClinica);
                    $resultadoTratamiento->setPaciente($paciente);
                    $em->persist($resultadoTratamiento);
                }
            }
            $em->flush();
            $msg = 'ok';

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al insertar las evoluciones clínicas del paciente';

        }
        return $msg;
    }

}
