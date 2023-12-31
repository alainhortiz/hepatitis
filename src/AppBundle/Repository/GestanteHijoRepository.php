<?php

namespace AppBundle\Repository;
use AppBundle\Entity\GestanteHijo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * GestanteHijoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GestanteHijoRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarHijo($data)
    {
        try{

            $em = $this->getEntityManager();
            $hijo = new GestanteHijo();

            /* ManytoOne */
            $gestante = $em->getRepository('AppBundle:PacienteGestante')->find($data['idGestante']);
            $hijo->setPacienteGestante($gestante);

            $hijo->setNombre(strtoupper($data['nombre']));
            $hijo->setPrimerApellido(strtoupper($data['primerApellido']));
            $hijo->setSegundoApellido(strtoupper($data['segundoApellido']));
            $hijo->setSexo($data['sexo']);
            $hijo->setInmunoglobulina($data['inmunoglobulina']);
            $hijo->setAlta($data['alta']);
            $hijo->setFechaNacimiento(new \DateTime($data['fechaNacimiento'] == '' ? '01-01-0001' : $data['fechaNacimiento']));
            $hijo->setFechainmunoglobulina(new \DateTime($data['fechaInmunoglobulina'] == '' ? '01-01-0001' : $data['fechaInmunoglobulina']));
            $hijo->setFechaAlta(new \DateTime($data['fechaAlta'] == '' ? '01-01-0001' : $data['fechaAlta']));
            $em->persist($hijo);
            $em->flush();
            $msg = $hijo;

        }catch (\Exception $e)
        {
           $msg = 'Se produjo un error al insertar el hijo de la gestante';

        }

        return $msg;
    }

    public function modificarHijo($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $hijo = $em->getRepository('AppBundle:GestanteHijo')->find($data['idHijo']);
            $hijo->setNombre(strtoupper($data['nombre']));
            $hijo->setPrimerApellido(strtoupper($data['primerApellido']));
            $hijo->setSegundoApellido(strtoupper($data['segundoApellido']));
            $hijo->setSexo($data['sexo']);
            $hijo->setInmunoglobulina($data['inmunoglobulina']);
            $hijo->setAlta($data['alta']);
            $hijo->setFechaNacimiento(new \DateTime($data['fechaNacimiento'] == '' ? '01-01-0001' : $data['fechaNacimiento']));
            $hijo->setFechainmunoglobulina(new \DateTime($data['fechaInmunoglobulina'] == '' ? '01-01-0001' : $data['fechaInmunoglobulina']));
            $hijo->setFechaAlta(new \DateTime($data['fechaAlta'] == '' ? '01-01-0001' : $data['fechaAlta']));
            $em->persist($hijo);
            $em->flush();
            $msg = $hijo;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el hijo';
        }

        return $msg;
    }

    public function eliminarHijo($id)
    {
        try {
            $em = $this->getEntityManager();
            $hijo = $em->getRepository('AppBundle:GestanteHijo')->find($id);

            $em->remove($hijo);
            $em->flush();
            $msg = $hijo;

        } catch (\Exception $e) {

                $msg = 'Se produjo un error al eliminar el hijo';

        }
        return $msg;
    }

    public function hijosSinInmunoglobulina($user)
    {
        $em = $this->getEntityManager();
        $nivelAcceso = $user->getNivelAcceso()->getNivel();


        $dql = 'SELECT h FROM AppBundle:GestanteHijo h JOIN h.pacienteGestante g JOIN g.paciente p JOIN p.unidadAtencion u JOIN u.municipio m JOIN m.provincia prov 
                    WHERE  h.inmunoglobulina = 0';

        if($nivelAcceso == 'provincial'){
            $dql .= " AND prov.id = " .$user->getUnidad()->getMunicipio()->getProvincia()->getId();
        }
        if($nivelAcceso == 'municipal'){
            $dql .= " AND m.id = " .$user->getUnidad()->getMunicipio()->getId();
        }
        $query = $em->createQuery($dql);

        return  $query->getResult();
    }

    public function hijosSinPruebas($user)
    {
        $em = $this->getEntityManager();
        $nivelAcceso = $user->getNivelAcceso()->getNivel();


        $dql = 'SELECT h FROM AppBundle:GestanteHijo h JOIN h.pacienteGestante g JOIN g.paciente p JOIN p.unidadAtencion u JOIN u.municipio m JOIN m.provincia prov 
                    WHERE  SIZE(h.hijoPruebas) = 0';

        if($nivelAcceso == 'provincial'){
            $dql .= " AND prov.id = " .$user->getUnidad()->getMunicipio()->getProvincia()->getId();
        }
        if($nivelAcceso == 'municipal'){
            $dql .= " AND m.id = " .$user->getUnidad()->getMunicipio()->getId();
        }
        $query = $em->createQuery($dql);
        $hijos = $query->getResult();

        $actual = new \DateTime('now');
        $fecha = $actual->sub(new \DateInterval('P18M'));
        $hijosEncontrados = new ArrayCollection();

        foreach ($hijos as $hijo)
        {

            if($fecha >= $hijo->getFechaNacimiento()) $hijosEncontrados->add($hijo);
        }

        return  $hijosEncontrados;
    }

    public function hijosFaltanVacunas($user)
    {
        $em = $this->getEntityManager();
        $nivelAcceso = $user->getNivelAcceso()->getNivel();


        $dql = 'SELECT h FROM AppBundle:GestanteHijo h JOIN h.pacienteGestante g JOIN g.paciente p LEFT JOIN h.hijoVacunas hv
                JOIN p.unidadAtencion u JOIN u.municipio m JOIN m.provincia prov 
                WHERE SIZE(h.hijoVacunas) = 0 OR (hv.fechaVacunaPrimera IS NULL OR  hv.fechaVacunaSegunda IS NULL OR hv.fechaVacunaTercera IS NULL OR hv.fechaReactivacion IS NULL)';

        if($nivelAcceso == 'provincial'){
            $dql .= " AND prov.id = " .$user->getUnidad()->getMunicipio()->getProvincia()->getId();
        }
        if($nivelAcceso == 'municipal'){
            $dql .= " AND m.id = " .$user->getUnidad()->getMunicipio()->getId();
        }
        $query = $em->createQuery($dql);
        $hijos = $query->getResult();

        $actual = new \DateTime('now');
        $fecha = $actual->sub(new \DateInterval('P18M'));
        $hijosEncontrados = new ArrayCollection();

        foreach ($hijos as $hijo)
        {
            if($fecha >= $hijo->getFechaNacimiento()) $hijosEncontrados->add($hijo);
        }

        return  $hijosEncontrados;
    }
}
