<?php

namespace AppBundle\Repository;

use AppBundle\Entity\EstadioHepatitis;

/**
 * EstadioHepatitisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EstadioHepatitisRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarEstadioHepatitis($data)
    {
        try{
            $em = $this->getEntityManager();
            $estadioHepatitis = new EstadioHepatitis();
            $estadioHepatitis->setNombre($data['nombre']);

            $em->persist($estadioHepatitis);
            $em->flush();
            $msg = $estadioHepatitis;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'El estadío de hepatitis ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar el estadío de hepatitis';
            }
        }

        return $msg;
    }

    public function modificarEstadioHepatitis($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $estadioHepatitis = $em->getRepository('AppBundle:EstadioHepatitis')->find($data['idEstadioHepatitis']);
            $estadioHepatitis->setNombre($data['nombre']);

            $em->persist($estadioHepatitis);
            $em->flush();
            $msg = $estadioHepatitis;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el estadío de hepatitis';
        }

        return $msg;
    }

    public function eliminarEstadioHepatitis($id)
    {
        try {
            $em = $this->getEntityManager();
            $estadioHepatitis = $em->getRepository('AppBundle:EstadioHepatitis')->find($id);

            $em->remove($estadioHepatitis);
            $em->flush();
            $msg = $estadioHepatitis;

        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'foreign key') > 0) {
                $msg = 'Existen seguimientos asociados a este estadío de hepatitis , no se puede eliminar';
            } else {
                $msg = 'Se produjo un error al eliminar el estadío de hepatitis';
            }
        }
        return $msg;
    }
}