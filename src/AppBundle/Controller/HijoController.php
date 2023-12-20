<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HijoController extends Controller
{
    /**
     * @Route("/gestionarTodosHijos", name="gestionarTodosHijos")
     */
    public function gestionarTodosHijosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $hijos  = $em->getRepository('AppBundle:GestanteHijo')->findAll();
        $pruebas = $em->getRepository('AppBundle:Prueba')->findAll();
        $resultadosPruebas = $em->getRepository('AppBundle:ResultadoPrueba')->findAll();

        return $this->render('Pacientes/GestionHijo/gestionTodosHijos.html.twig' , ['hijos' => $hijos,'pruebas' => $pruebas,'resultadosPruebas' => $resultadosPruebas]);
    }

    /**
     * @Route("/gestionarHijo/{idGestante}/{origen}", name="gestionarHijo")
     */
    public function gestionarHijoAction($idGestante , $origen)
    {
        $em = $this->getDoctrine()->getManager();
        $gestante = $em->getRepository('AppBundle:PacienteGestante')->find($idGestante);
        $hijos  = $em->getRepository('AppBundle:GestanteHijo')->findBy(array('pacienteGestante' => $gestante));
        $pruebas = $em->getRepository('AppBundle:Prueba')->findAll();
        $resultadosPruebas = $em->getRepository('AppBundle:ResultadoPrueba')->findAll();

        return $this->render('Pacientes/GestionHijo/gestionHijo.html.twig' , array(
            'hijos' => $hijos,
            'gestante' => $gestante,
            'pruebas' => $pruebas,
            'resultadosPruebas' => $resultadosPruebas,
            'origen' => $origen
        ));
    }

     /**
     * @Route("/insertHijo", name="insertHijo")
     */
    public function insertHijoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idGestante' => $peticion->request->get('idGestante'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'sexo' => $peticion->request->get('sexo'),
            'inmunoglobulina' => $peticion->request->get('inmunoglobulina'),
            'fechaNacimiento' => $peticion->request->get('fechaNacimiento'),
            'fechaInmunoglobulina' => $peticion->request->get('fechaInmunoglobulina'),
            'fechaAlta' => $peticion->request->get('fechaAlta'),
            'alta' => $peticion->request->get('alta'),
        );

        $hijos = $em->getRepository('AppBundle:GestanteHijo')->agregarHijo($data);
        $hijoPruebas = $peticion->request->get('hijosPruebas');
        $hijoVacunas = $peticion->request->get('hijosVacunas');

        if (is_string($hijos)) return new Response($hijos);
        else {

            if($hijoVacunas)
            {
                $resp = $em->getRepository('AppBundle:HijoVacuna')->agregarVacunas($hijoVacunas, $hijos);
            }
            else $resp = 'ok';

            if($resp != 'ok') return new Response($resp);

            if ($hijoPruebas) {
                $resp = $em->getRepository('AppBundle:HijoPrueba')->agregarPruebas($hijoPruebas, $hijos);
            }
            else $resp = 'ok';

            if($resp != 'ok') return new Response($resp);

            return new Response('ok');

        }
    }

    /**
     * @Route("/updateHijo", name="updateHijo")
     */
    public function updateHijoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idHijo' => $peticion->request->get('idHijo'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'sexo' => $peticion->request->get('sexo'),
            'inmunoglobulina' => $peticion->request->get('inmunoglobulina'),
            'alta' => $peticion->request->get('alta'),
            'fechaNacimiento' => $peticion->request->get('fechaNacimiento'),
            'fechaInmunoglobulina' => $peticion->request->get('fechaInmunoglobulina'),
            'fechaAlta' => $peticion->request->get('fechaAlta'),
        );

        $hijos = $em->getRepository('AppBundle:GestanteHijo')->modificarHijo($data);
        $hijoPruebas = $peticion->request->get('hijosPruebas');
        $hijoVacunas = $peticion->request->get('hijosVacunas');

        if (is_string($hijos)) return new Response($hijos);
        else {

            if($hijoVacunas)
            {
                $resp = $em->getRepository('AppBundle:HijoVacuna')->modificarVacunas($hijoVacunas, $hijos);
            }
            else $resp = 'ok';

            if($resp != 'ok') return new Response($resp);

            if ($hijoPruebas) {
                $resp = $em->getRepository('AppBundle:HijoPrueba')->modificarPruebas($hijoPruebas, $hijos);
            }
            else $resp = 'ok';

            if($resp != 'ok') return new Response($resp);

            return new Response('ok');

        }
    }

    /**
     * @Route("/deleteHijo", name="deleteHijo")
     */
    public function deleteHijoAction()
    {
        $peticion = Request::createFromGlobals();
        $idHijo = $peticion->request->get('idHijo');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:GestanteHijo')->eliminarHijo($idHijo);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Hijo',
                'descripcion' => 'Se eliminó el hijo con el nombre: '.$resp->nombreCompleto()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/listadoHijosSinInmunoglobulina", name="listadoHijosSinInmunoglobulina")
     */
    public function listadoHijosSinInmunoglobulinaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $hijos = $em->getRepository('AppBundle:GestanteHijo')->hijosSinInmunoglobulina($user);
        $pruebas = $em->getRepository('AppBundle:Prueba')->findAll();
        $resultadosPruebas = $em->getRepository('AppBundle:ResultadoPrueba')->findAll();

        return $this->render('Alertas/listadoHijosSinInmunoglobulina.html.twig' , array(

                'pruebas' => $pruebas,
                'resultadosPruebas' => $resultadosPruebas,
                'hijos' => $hijos)
        );

    }

    /**
     * @Route("/listadoHijosSinPruebas", name="listadoHijosSinPruebas")
     */
    public function listadoHijosSinPruebasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $hijos = $em->getRepository('AppBundle:GestanteHijo')->hijosSinPruebas($user);
        $pruebas = $em->getRepository('AppBundle:Prueba')->findAll();
        $resultadosPruebas = $em->getRepository('AppBundle:ResultadoPrueba')->findAll();

        return $this->render('Alertas/listadoHijosSinPruebas.html.twig' , array(

                'pruebas' => $pruebas,
                'resultadosPruebas' => $resultadosPruebas,
                'hijos' => $hijos)
        );

    }

    /**
     * @Route("/listadoHijosFaltanVacunas", name="listadoHijosFaltanVacunas")
     */
    public function listadoHijosFaltanVacunasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $hijos = $em->getRepository('AppBundle:GestanteHijo')->hijosFaltanVacunas($user);
        $pruebas = $em->getRepository('AppBundle:Prueba')->findAll();
        $resultadosPruebas = $em->getRepository('AppBundle:ResultadoPrueba')->findAll();

        return $this->render('Alertas/listadoHijosFaltanVacunas.html.twig' , array(

                'pruebas' => $pruebas,
                'resultadosPruebas' => $resultadosPruebas,
                'hijos' => $hijos)
        );
    }
}
