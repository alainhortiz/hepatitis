<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Ocupacion;


/**
 * OcupacionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OcupacionRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarOcupacion($data)
    {
        try{
            $em = $this->getEntityManager();
            $ocupacion = new Ocupacion();
            $ocupacion->setNombre($data['nombre']);

            $em->persist($ocupacion);
            $em->flush();
            $msg = $ocupacion;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'La ocupación ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar la ocupación';
            }
        }

        return $msg;
    }

    public function modificarOcupacion($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $ocupacion = $em->getRepository('AppBundle:Ocupacion')->find($data['idOcupacion']);
            $ocupacion->setNombre($data['nombre']);

            $em->persist($ocupacion);
            $em->flush();
            $msg = $ocupacion;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar la ocupación';
        }

        return $msg;
    }

    public function eliminarOcupacion($id)
    {
        try {
            $em = $this->getEntityManager();
            $ocupacion = $em->getRepository('AppBundle:Ocupacion')->find($id);

            $em->remove($ocupacion);
            $em->flush();
            $msg = $ocupacion;

        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'foreign key') > 0) {
                $msg = 'Existen pacientes asociados a esta ocupación , no se puede eliminar';
            } else {
                $msg = 'Se produjo un error al eliminar la ocupación';
            }
        }
        return $msg;
    }
}
