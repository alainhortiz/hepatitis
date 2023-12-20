<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    /**
     * @Route("/formEtiologia", name="formEtiologia")
     */
    public function formEtiologiaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $etiologias = $em->getRepository('AppBundle:Etiologia')->findAll();


        return $this->render('Reportes/reportEtiologia.html.twig', array(
            'municipios' => $municipios,
            'provincias' => $provincias,
            'etiologias' => $etiologias,
        ));
    }
    /**
     * @Route("/reportEtiologia", name="reportEtiologia")
     */
    public function reportEtiologiaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'fechaInicial' => $peticion->request->get('fechaInicial'),
            'fechaFinal' => $peticion->request->get('fechaFinal'),
            'etiologia' => $peticion->request->get('etiologia'),
            'provincia' => $peticion->request->get('provincia'),
            'municipio' => $peticion->request->get('municipio'),
        );

        $pacientes = $em->getRepository('AppBundle:Paciente')->reportEtiologia($data);

        if(is_string($pacientes)) return new Response($pacientes);
        else return new Response($this->renderView('Reportes/tablaReportEtiologia.html.twig', array('pacientes' => $pacientes)));
    }

    /**
     * @Route("/formSexo", name="formSexo")
     */
    public function formSexoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();

        return $this->render('Reportes/reportSexo.html.twig', array(
            'municipios' => $municipios,
            'provincias' => $provincias,
        ));
    }
    /**
     * @Route("/reportSexo", name="reportSexo")
     */
    public function reportSexoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'fechaInicial' => $peticion->request->get('fechaInicial'),
            'fechaFinal' => $peticion->request->get('fechaFinal'),
            'sexo' => $peticion->request->get('sexo'),
            'provincia' => $peticion->request->get('provincia'),
            'municipio' => $peticion->request->get('municipio'),
        );
        $pacientes = $em->getRepository('AppBundle:Paciente')->reportSexo($data);

        if(is_string($pacientes)) return new Response($pacientes);
        else return new Response($this->renderView('Reportes/tablaReportSexo.html.twig', array('pacientes' => $pacientes)));
    }

    /**
     * @Route("/formCoinfeccion", name="formCoinfeccion")
     */
    public function formCoinfeccionAction()
    {
        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $coinfecciones = $em->getRepository('AppBundle:Coinfeccion')->findAll();

        return $this->render('Reportes/reportCoinfeccion.html.twig', array(
            'municipios' => $municipios,
            'provincias' => $provincias,
            'coinfecciones' => $coinfecciones,
        ));
    }
    /**
     * @Route("/reportCoinfeccion", name="reportCoinfeccion")
     */
    public function reportCoinfeccionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'fechaInicial' => $peticion->request->get('fechaInicial'),
            'fechaFinal' => $peticion->request->get('fechaFinal'),
            'coinfeccion' => $peticion->request->get('coinfeccion'),
            'provincia' => $peticion->request->get('provincia'),
            'municipio' => $peticion->request->get('municipio'),
        );
        $pacientes = $em->getRepository('AppBundle:Paciente')->reportCoinfeccion($data);

        if(is_string($pacientes)) return new Response($pacientes);
        else return new Response($this->renderView('Reportes/tablaReportCoinfeccion.html.twig', array('pacientes' => $pacientes)));
    }

    /**
     * @Route("/formEvolucionClinica", name="formEvolucionClinica")
     */
    public function formEvolucionClinicaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $etiologias = $em->getRepository('AppBundle:Etiologia')->findAll();
        $coinfecciones = $em->getRepository('AppBundle:Coinfeccion')->findAll();
        $evoluciones = $em->getRepository('AppBundle:EvolucionClinica')->findAll();



        return $this->render('Reportes/reportEvolucionClinica.html.twig', array(
            'municipios' => $municipios,
            'provincias' => $provincias,
            'etiologias' => $etiologias,
            'coinfecciones' => $coinfecciones,
            'evoluciones' => $evoluciones,
        ));
    }
    /**
     * @Route("/reportEvolucionClinica", name="reportEvolucionClinica")
     */
    public function reportEvolucionClinicaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'fechaInicial' => $peticion->request->get('fechaInicial'),
            'fechaFinal' => $peticion->request->get('fechaFinal'),
            'etiologia' => $peticion->request->get('etiologia'),
            'coinfeccion' => $peticion->request->get('coinfeccion'),
            'evolucionClinica' => $peticion->request->get('evolucionClinica'),
            'provincia' => $peticion->request->get('provincia'),
            'municipio' => $peticion->request->get('municipio'),
        );
        $pacientes = $em->getRepository('AppBundle:Paciente')->reportEvolucionClinica($data);

        if(is_string($pacientes)) return new Response($pacientes);
        else return new Response($this->renderView('Reportes/tablaReportEvolucionClinica.html.twig', array('pacientes' => $pacientes)));
    }

    /**
     * @Route("/formHemodialisis", name="formHemodialisis")
     */
    public function formHemodialisisAction()
    {
        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $etiologias = $em->getRepository('AppBundle:Etiologia')->findAll();
        $coinfecciones = $em->getRepository('AppBundle:Coinfeccion')->findAll();


        return $this->render('Reportes/reportHemodialisis.html.twig', array(
            'municipios' => $municipios,
            'provincias' => $provincias,
            'etiologias' => $etiologias,
            'coinfecciones' => $coinfecciones,
        ));
    }
    /**
     * @Route("/reportHemodialisis", name="reportHemodialisis")
     */
    public function reportHemodialisisAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'fechaInicial' => $peticion->request->get('fechaInicial'),
            'fechaFinal' => $peticion->request->get('fechaFinal'),
            'etiologia' => $peticion->request->get('etiologia'),
            'coinfeccion' => $peticion->request->get('coinfeccion'),
            'provincia' => $peticion->request->get('provincia'),
            'municipio' => $peticion->request->get('municipio'),
        );
        $pacientes = $em->getRepository('AppBundle:Paciente')->reportHemodialisis($data);

        if(is_string($pacientes)) return new Response($pacientes);
        else return new Response($this->renderView('Reportes/tablaReportHemodialisis.html.twig', array('pacientes' => $pacientes)));
    }




}
