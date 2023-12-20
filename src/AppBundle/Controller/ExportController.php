<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\ImprimirExcel;


class ExportController extends Controller
{
    /**
     * @Route("/excelExportacionGeneral", name="excelExportacionGeneral")
     */
    public function excelExportacionGeneralAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pacientes = $em->getRepository('AppBundle:Paciente')->findAll();
        $hijos = $em->getRepository('AppBundle:GestanteHijo')->findAll();

        $export = new ImprimirExcel\ImpExportacionGeneral();
        $export->DatosExcel($pacientes , $hijos);
    }

}