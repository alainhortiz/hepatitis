<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Etiologia;

/**
 * EtiologiaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EtiologiaRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarEtiologia($data)
    {
        try{
            $em = $this->getEntityManager();
            $etiologia = new Etiologia();
            $etiologia->setNombre($data['nombre']);

            $em->persist($etiologia);
            $em->flush();
            $msg = $etiologia;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'La etiologia de hepatitis ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar la etiologia de hepatitis';
            }
        }

        return $msg;
    }

    public function modificarEtiologia($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $etiologia = $em->getRepository('AppBundle:Etiologia')->find($data['idEtiologia']);
            $etiologia->setNombre($data['nombre']);

            $em->persist($etiologia);
            $em->flush();
            $msg = $etiologia;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar la etiologia de hepatitis';
        }

        return $msg;
    }

    public function eliminarEtiologia($id)
    {
        try {
            $em = $this->getEntityManager();
            $etiologia = $em->getRepository('AppBundle:Etiologia')->find($id);

            $em->remove($etiologia);
            $em->flush();
            $msg = $etiologia;

        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'foreign key') > 0) {
                $msg = 'Existen pacientes asociados a esta etiologia de hepatitis , no se puede eliminar';
            } else {
                $msg = 'Se produjo un error al eliminar la etiologia de hepatitis';
            }
        }
        return $msg;
    }
}