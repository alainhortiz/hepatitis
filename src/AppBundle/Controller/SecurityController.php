<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('Inicio/login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error' => $error,
            ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function login_checkAction()
    {
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/inicio", name="inicio")
     */
    public function inicioAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $gestantesSinHijos = $em->getRepository('AppBundle:PacienteGestante')->gestantesFueraDeTiempoSinHijos($user);
        $hijosSinInmunoglobulina = $em->getRepository('AppBundle:GestanteHijo')->hijosSinInmunoglobulina($user);
        $hijosSinPruebas = $em->getRepository('AppBundle:GestanteHijo')->hijosSinPruebas($user);
        $hijosFaltanVacunas = $em->getRepository('AppBundle:GestanteHijo')->hijosFaltanVacunas($user);

        return $this->render('Inicio/Inicio.html.twig' , array(
            'cantidadGestantesSinHijos' => count($gestantesSinHijos),
            'cantidadHijosSinInmunoglobulina' => count($hijosSinInmunoglobulina),
            'cantidadHijosSinPruebas' => count($hijosSinPruebas),
            'cantidadHijosFaltanVacunas' => count($hijosFaltanVacunas),
        ));
    }

    /**
     * @Route("/passwordForm", name="passwordForm")
     */
    public function passwordFormdAction()
    {
        return $this->render('Inicio/cambiarPassword.html.twig');
    }

    /**
     * @Route("/changePassword", name="changePassword")
     */
    public function changePasswordAction()
    {
        $peticion = Request::createFromGlobals();
        $username = $peticion->request->get('username');
        $passAnt = $peticion->request->get('passAnt');
        $passNew = $peticion->request->get('passNew');

        $encoder = $this->container->get('security.password_encoder');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Usuario');
        $user = $repository->findOneBy(array('username' => $username));
        $valid = $encoder->isPasswordValid($user , $passAnt);

        if($valid == 1)
        {
            $resp = $em->getRepository('AppBundle:Usuario')->cambiarPassword($username , $passNew);
            if(is_string($resp)) return new Response($resp);
            else{
                $this->forward('AppBundle:Traza:insertTraza' , array(
                    'operacion' => 'Cambiar contraseña',
                    'descripcion' => 'El usuario '.$user->getNombre().' '.$user->getPrimerApellido().' '.$user->getSegundoApellido().' ha cambiado su contraseña.',
                ));
                return new Response('ok');
            }
        }
        else
        {
            return new Response('Error: Contraseña actual errónea');
        }
    }


}
