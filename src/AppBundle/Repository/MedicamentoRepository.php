<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Medicamento;


/**
 * MedicamentoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MedicamentoRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarMedicamento($data)
    {
        try{
            $em = $this->getEntityManager();
            $medicamento = new Medicamento();
            $medicamento->setNombre($data['nombre']);

            $em->persist($medicamento);
            $em->flush();
            $msg = $medicamento;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'El Medicamento ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar el Medicamento';
            }
        }

        return $msg;
    }

    public function modificarMedicamento($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $medicamento = $em->getRepository('AppBundle:Medicamento')->find($data['idMedicamento']);
            $medicamento->setNombre($data['nombre']);

            $em->persist($medicamento);
            $em->flush();
            $msg = $medicamento;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el Medicamento';
        }

        return $msg;
    }

    public function eliminarMedicamento($id)
    {
        try {
            $em = $this->getEntityManager();
            $medicamento = $em->getRepository('AppBundle:Medicamento')->find($id);

            $em->remove($medicamento);
            $em->flush();
            $msg = $medicamento;

        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'foreign key') > 0) {
                $msg = 'Existen pacientes con este Medicamento en su tratamiento , no se puede eliminar';
            } else {
                $msg = 'Se produjo un error al eliminar el Medicamento';
            }
        }
        return $msg;
    }
}
