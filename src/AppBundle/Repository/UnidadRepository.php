<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Unidad;

/**
 * UnidadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UnidadRepository extends \Doctrine\ORM\EntityRepository
{
    public function listarUnidades($user)
    {
        $em = $this->getEntityManager();
        $nivelAcceso = $user->getNivelAcceso()->getNivel();

        if($nivelAcceso == 'nacional')
        {
            $dql = 'SELECT a FROM AppBundle:Unidad a ';
            $query = $em->createQuery($dql);
            $unidades = $query->getResult();
        }
        elseif($nivelAcceso == 'provincial')
        {
            $provincia = $user->getUnidad()->getMunicipio()->getProvincia()->getCodigo();
            $dql = 'SELECT a FROM AppBundle:Unidad a  JOIN a.municipio m JOIN m.provincia p
                    WHERE p.codigo = :codigo';
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $provincia);
            $unidades = $query->getResult();
        }
        elseif($nivelAcceso == 'municipal')
        {
            $municipio = $user->getUnidad()->getMunicipio()->getCodigo();
            $dql = 'SELECT a FROM AppBundle:Unidad a JOIN a.municipio m
                    WHERE  m.codigo = :codigo';
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $municipio);
            $unidades = $query->getResult();
        }
        else
        {
            $unidades[0] = $user->getUnidad();
        }
        return $unidades;

    }

    public function  agregarUnidad($data)
    {

        try{
            $em = $this->getEntityManager();
            $Unidad = new Unidad();
            $Unidad->setNombre($data['nombre']);
            $Unidad->setCodigo($data['codigo']);

            $municipio  = $em->getRepository('AppBundle:Municipio')->find($data['idMunicipio']);
            $Unidad->setMunicipio($municipio);

            $em->persist($Unidad);
            $em->flush();
            $msg = $Unidad;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'La Unidad ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar la Unidad';
            }
        }

        return $msg;
    }

    public function modificarUnidad($data)
    {

        try
        {
            $em = $this->getEntityManager();
            $Unidad= $em->getRepository('AppBundle:Unidad')->find($data['idUnidad']);
            $Unidad->setNombre($data['nombre']);

            $municipio  = $em->getRepository('AppBundle:Municipio')->find($data['idMunicipio']);
            $Unidad->setMunicipio($municipio);

            $em->persist($Unidad);
            $em->flush();
            $msg = $Unidad;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar la Unidad';
        }

        return $msg;
    }

    public function eliminarUnidad($id)
    {
        try
        {
            $em = $this->getEntityManager();
            $Unidad = $em->getRepository('AppBundle:Unidad')->find($id);

            $em->remove($Unidad);
            $em->flush();
            $msg = $Unidad;

        }catch (\Exception $e){

            if(strpos($e->getMessage() , 'foreign key') > 0)
            {
                $msg = 'Existen datos asociados a esta Unidad , no se puede eliminar';
            }
            else
            {
                $msg = 'Se produjo un error al eliminar la Unidad';
            }
        }
        return $msg;
    }
}