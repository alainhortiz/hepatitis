<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TotalPoblacionController extends Controller
{
    /**
     * @Route("/gestionarTotalPoblacion", name="gestionarTotalPoblacion")
     */
    public function gestionarTotalPoblacionAction()
    {
        $em = $this->getDoctrine()->getManager();
        $totalPoblaciones  = $em->getRepository('AppBundle:TotalPoblacion')->findAll();

        return $this->render('Nomencladores/GestionTotalPoblacion/gestionTotalPoblacion.html.twig' , array('totalPoblaciones' => $totalPoblaciones));
    }

    /**
     * @Route("/addTotalPoblacion", name="addTotalPoblacion")
     */
    public function addTotalPoblacionAction()
    {
        return $this->render('Nomencladores/GestionTotalPoblacion/addTotalPoblacion.html.twig');
    }

    /**
     * @Route("/insertTotalPoblacion", name="insertTotalPoblacion")
     */
    public function insertTotalPoblacionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'year' => $peticion->request->get('year'),
            'total' => $peticion->request->get('total'),
            'totalFemenino' => $peticion->request->get('totalFemenino'),
            'totalMasculino' => $peticion->request->get('totalMasculino')
        );

        $resp = $em->getRepository('AppBundle:TotalPoblacion')->agregarTotalPoblacion($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Total de Población',
                'descripcion' => 'Se insertó el total de población del año: '.$data['year']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editTotalPoblacion/{idTotalPoblacion}", name="editTotalPoblacion")
     */
    public function editTotalPoblacionAction($idTotalPoblacion)
    {
        $em = $this->getDoctrine()->getManager();
        $totalPoblacion = $em->getRepository('AppBundle:TotalPoblacion')->find($idTotalPoblacion);

        return $this->render('Nomencladores/GestionTotalPoblacion/editTotalPoblacion.html.twig' , array('totalPoblacion' => $totalPoblacion));
    }

    /**
     * @Route("/updateTotalPoblacion", name="updateTotalPoblacion")
     */
    public function updateTotalPoblacionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idTotalPoblacion' => $peticion->request->get('idTotalPoblacion'),
            'year' => $peticion->request->get('year'),
            'total' => $peticion->request->get('total'),
            'totalFemenino' => $peticion->request->get('totalFemenino'),
            'totalMasculino' => $peticion->request->get('totalMasculino')
        );

        $resp = $em->getRepository('AppBundle:TotalPoblacion')->modificarTotalPoblacion($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar el total de población',
                'descripcion' => 'Se modificó el total de población del año:  '.$data['year']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteTotalPoblacion", name="deleteTotalPoblacion")
     */
    public function deleteTotalPoblacionAction()
    {
        $peticion = Request::createFromGlobals();
        $idTotalPoblacion = $peticion->request->get('idTotalPoblacion');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:TotalPoblacion')->eliminarTotalPoblacion($idTotalPoblacion);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar el total de población',
                'descripcion' => 'Se eliminó el total de población del año: '.$resp->getYear()
            ));
            return new Response('ok');
        }
    }
}
