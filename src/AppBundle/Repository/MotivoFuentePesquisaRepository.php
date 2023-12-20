<?php

namespace AppBundle\Repository;
use AppBundle\Entity\MotivoFuentePesquisa;


/**
 * MotivoFuentePesquisaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MotivoFuentePesquisaRepository extends \Doctrine\ORM\EntityRepository
{
    public function listarMotivosFuentePesquisa($user)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT m FROM AppBundle:MotivoFuentePesquisa m ';
        $query = $em->createQuery($dql);
        $motivoFuentePesquisa = $query->getResult();

        return $motivoFuentePesquisa;
    }

    public function  agregarMotivoFuentePesquisia($data)
    {
        try{
            $em = $this->getEntityManager();
            $motivoFuentePesquisa = new MotivoFuentePesquisa();
            $motivoFuentePesquisa->setNombre($data['nombre']);

            $em->persist($motivoFuentePesquisa);
            $em->flush();
            $msg = $motivoFuentePesquisa;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'El motivo de fuente pesquisa ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar el motivo de fuente pesquisa';
            }
        }

        return $msg;
    }

    public function modificarMotivoFuentePesquisia($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $motivoFuentePesquisa = $em->getRepository('AppBundle:MotivoFuentePesquisa')->find($data['idMotivoFuentePesquisa']);
            $motivoFuentePesquisa->setNombre($data['nombre']);

            $em->persist($motivoFuentePesquisa);
            $em->flush();
            $msg = $motivoFuentePesquisa;

        }catch (\Exception $e)
        {
            $msg = 'Error';
        }

        return $msg;
    }

    public function eliminarMotivoFuentePesquisia($id)
    {
        try
        {
            $em = $this->getEntityManager();
            $motivoFuentePesquisa = $em->getRepository('AppBundle:MotivoFuentePesquisa')->find($id);

            $em->remove($motivoFuentePesquisa);
            $em->flush();
            $msg = $motivoFuentePesquisa;

        }catch (\Exception $e){

            if(strpos($e->getMessage() , 'foreign key') > 0)
            {
                $msg = 'Existen datos asociados a este motivo de fuente pesquisa , no se puede eliminar';
            }
            else
            {
                $msg = 'Se produjo un error al eliminar el motivo de fuente pesquisa';
            }
        }
        return $msg;
    }
}
