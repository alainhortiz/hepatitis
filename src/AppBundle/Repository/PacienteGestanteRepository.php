<?php

namespace AppBundle\Repository;

use AppBundle\Entity\PacienteGestante;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PacienteGestanteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PacienteGestanteRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarPacienteGestante($data , $paciente)
    {
        try{
            $em = $this->getEntityManager();
            $pacienteGestante = new PacienteGestante();
            $pacienteGestante->setFechaEdadGestacional(new \DateTime($data['fechaEdadGestacional']));
            $pacienteGestante->setSemanaGestacional($data['semanaGestacional']);
            $pacienteGestante->setDiasGestacional($data['diasGestacional']);
            $pacienteGestante->setPaciente($paciente);

            $em->persist($pacienteGestante);
            $em->flush();
            $msg = $pacienteGestante;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al insertar el paciente gestante';
        }

        return $msg;
    }

    public function modificarPacienteGestante($data , $paciente)
    {
        try{
            $em = $this->getEntityManager();
            $pacienteGestante = $paciente->getPacienteGestante();
            $pacienteGestante->setFechaEdadGestacional(new \DateTime($data['fechaEdadGestacional']));
            $pacienteGestante->setSemanaGestacional($data['semanaGestacional']);
            $pacienteGestante->setDiasGestacional($data['diasGestacional']);

            $em->persist($pacienteGestante);
            $em->flush();
            $msg = $pacienteGestante;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el paciente gestante';
        }

        return $msg;
    }

    public function eliminarPacienteGestante($idGestante)
    {
        try {
            $em = $this->getEntityManager();
            $gestante = $em->getRepository('AppBundle:PacienteGestante')->find($idGestante);

            $em->remove($gestante);
            $em->flush();
            $msg = $gestante;

        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'foreign key') > 0) {
                $msg = 'Existen hijos asociados a esta gestante , no se puede eliminar';
            } else {
                $msg = 'Se produjo un error al eliminar la gestante';
            }
        }
        return $msg;
    }

    public function gestantesFueraDeTiempoSinHijos($user)
    {
        $em = $this->getEntityManager();
        $nivelAcceso = $user->getNivelAcceso()->getNivel();


        $dql = 'SELECT g FROM AppBundle:PacienteGestante g JOIN g.paciente p JOIN p.unidadAtencion u JOIN u.municipio m JOIN m.provincia prov 
                    WHERE  g.gestanteHijos IS EMPTY';

        if($nivelAcceso == 'provincial'){
            $dql .= " AND prov.id = " .$user->getUnidad()->getMunicipio()->getProvincia()->getId();
        }
        if($nivelAcceso == 'municipal'){
            $dql .= " AND m.id = " .$user->getUnidad()->getMunicipio()->getId();
        }
        $query = $em->createQuery($dql);
        $gestantes = $query->getResult();

        $tiempoTotal = 42*7;
        $actual = new \DateTime('now');
        $gestantesEncontradas = new ArrayCollection();

        foreach ($gestantes as $gestante)
        {
            $intervalo = $gestante->getFechaEdadGestacional()->diff($actual);
            $diferencia = (int)$intervalo->format('%R%a');
            $tiempoGestacional = $tiempoTotal - (($gestante->getSemanaGestacional() * 7) + $gestante->getDiasGestacional() + $diferencia );
            if($tiempoGestacional <= 0) $gestantesEncontradas[] = $gestante;

        }
        return $gestantesEncontradas;
    }
}
