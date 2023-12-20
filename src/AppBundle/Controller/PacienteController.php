<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PacienteController extends Controller
{

    /**
     * @Route("gestionarPacientes", name="gestionarPacientes")
     */
    public function gestionarPacientesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nivelesEscolaridad = $em->getRepository('AppBundle:NivelEscolaridad')->findAll();
        $estadosCiviles = $em->getRepository('AppBundle:EstadoCivil')->findAll();
        $ocupaciones = $em->getRepository('AppBundle:Ocupacion')->findAll();
        $unidades = $em->getRepository('AppBundle:Unidad')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $etiologias = $em->getRepository('AppBundle:Etiologia')->findAll();
        $tiposHepatitis = $em->getRepository('AppBundle:TipoHepatitis')->findAll();
        $estadiosHepatitis = $em->getRepository('AppBundle:EstadioHepatitis')->findAll();
        $formasInfeccion = $em->getRepository('AppBundle:FormaInfeccion')->findAll();
        $fuentesPesquisa = $em->getRepository('AppBundle:FuentePesquisa')->findAll();
        $motivosFuentePesquisa = $em->getRepository('AppBundle:MotivoFuentePesquisa')->findAll();
        $gruposVulnerables = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();
        $coloresPiel = $em->getRepository('AppBundle:ColorPiel')->findAll();
        $antecedentesPatologicos = $em->getRepository('AppBundle:AntecedentePatologico')->findAll();
        $coinfecciones = $em->getRepository('AppBundle:Coinfeccion')->findAll();
        $medicamentos = $em->getRepository('AppBundle:Medicamento')->findAll();
        $pruebas = $em->getRepository('AppBundle:Prueba')->findAll();
        $resultadosPruebas = $em->getRepository('AppBundle:ResultadoPrueba')->findAll();
        $evolucionesClinicas = $em->getRepository('AppBundle:EvolucionClinica')->findAll();
        $causasFallecimiento = $em->getRepository('AppBundle:CausaFallecimiento')->findAll();




        return $this->render('Pacientes/GestionPaciente/gestionPaciente.html.twig', array(
            'nivelesEscolaridad' => $nivelesEscolaridad,
            'estadosCiviles' => $estadosCiviles,
            'ocupaciones' => $ocupaciones,
            'unidades' => $unidades,
            'municipios' => $municipios,
            'provincias' => $provincias,
            'etiologias' => $etiologias,
            'tiposHepatitis' => $tiposHepatitis,
            'estadiosHepatitis' => $estadiosHepatitis,
            'formasInfeccion' => $formasInfeccion,
            'fuentesPesquisa' => $fuentesPesquisa,
            'motivosFuentePesquisa' => $motivosFuentePesquisa,
            'gruposVulnerables' => $gruposVulnerables,
            'coloresPiel' => $coloresPiel,
            'antecedentesPatologicos' => $antecedentesPatologicos,
            'coinfecciones' => $coinfecciones,
            'pruebas' => $pruebas,
            'resultadosPruebas' => $resultadosPruebas,
            'medicamentos' => $medicamentos,
            'evolucionesClinicas' => $evolucionesClinicas,
            'causasFallecimiento' => $causasFallecimiento,
        ));
    }

    /**
     * @Route("/localizarPaciente", name="localizarPaciente")
     */
    public function localizarPacienteAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'carnetIdentidad' => $peticion->request->get('carnetIdentidad'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
        );
        $pacientes = $em->getRepository('AppBundle:Paciente')->buscarPaciente($data);

        if(is_string($pacientes)) return new Response($pacientes);
        else return new Response($this->renderView('Pacientes/GestionPaciente/tablaPacientesEncontrados.html.twig', array('pacientes' => $pacientes)));
    }

    /**
     * @Route("/buscarCarnetIdentidad", name="buscarCarnetIdentidad")
     */
    public function buscarCarnetIdentidadAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $carnetIdentidad = $peticion->request->get('carnetIdentidad');
        $paciente = $em->getRepository('AppBundle:Paciente')->findOneBy(array('carnetIdentidad' => $carnetIdentidad));

        if(!is_object($paciente)) return new Response('Nuevo');
        else return new Response($this->renderView('Pacientes/GestionPaciente/tablaPacientesEncontrados.html.twig', array(
            'pacientes' => array($paciente),
        )));
    }

    /**
     * @Route("/insertPaciente", name="insertPaciente")
     */
    public function insertPacienteAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $data = array(
            'carnetIdentidad' => $peticion->request->get('carnetIdentidad'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'edad' => $peticion->request->get('edad'),
            'sexo' => $peticion->request->get('sexo'),
            'colorPiel' => $peticion->request->get('colorPiel'),
            'estadoCivil' => $peticion->request->get('estadoCivil'),
            'nivelEscolaridad' => $peticion->request->get('nivelEscolaridad'),
            'ocupacion' => $peticion->request->get('ocupacion'),
            'gestante' => $peticion->request->get('gestante'),
            'direccionCarnet' => $peticion->request->get('direccionCarnet'),
            'municipioCarnet' => $peticion->request->get('municipioCarnet'),
            'unidadAtencion' => $peticion->request->get('unidadAtencion'),
            'fechaDiagnostico' => $peticion->request->get('fechaDiagnostico'),
            'etiologia' => $peticion->request->get('etiologia'),
            'tipoHepatitis' => $peticion->request->get('tipoHepatitis'),
            'estadioHepatitis' => $peticion->request->get('estadioHepatitis'),
            'formaInfeccion' => $peticion->request->get('formaInfeccion'),
            'grupoVulnerable' => $peticion->request->get('grupoVulnerable'),
            'fuentePesquisa' => $peticion->request->get('fuentePesquisa'),
            'motivoFuentePesquisa' => $peticion->request->get('motivoFuentePesquisa'),
            'transfusion' => $peticion->request->get('transfusion'),
            'antecedentesPatologicos' => $peticion->request->get('antecedentesPatologicos'),
            'coinfecciones' => $peticion->request->get('coinfecciones'),
            'orientacionesSexuales' => $peticion->request->get('orientacionesSexuales'),
            'pacienteEsquemasMedicamentos' => $peticion->request->get('pacienteEsquemasMedicamentos'),
            'pacientePruebas' => $peticion->request->get('pacientePruebas'),
            'evolucionesClinicas' => $peticion->request->get('evolucionesClinicas'),
            'idCausaFallecimiento' => $peticion->request->get('idCausaFallecimiento'),
        );


        $dataGestante = [];
        if($data['gestante'] == '1'){

            $dataGestante = array(
                'fechaEdadGestacional' => $peticion->request->get('fechaEdadGestacional'),
                'semanaGestacional' => $peticion->request->get('semanaGestacional'),
                'diasGestacional' => $peticion->request->get('diasGestacional'),
            );
        }
        $dataDireccionResidencia = array(
            'direccionResidencia' => $peticion->request->get('direccionResidencia'),
            'municipioResidencia' => $peticion->request->get('municipioResidencia'),
        );

        $user = $this->getUser();
        $paciente  =  $em->getRepository('AppBundle:Paciente')->masterAgregarPaciente($data , $dataGestante , $dataDireccionResidencia , $user);
        if(is_string($paciente)) return new Response($paciente);
        else{
            return new Response($this->renderView('Pacientes/GestionPaciente/tablaPacientesEncontradosInsert.html.twig', array(
                'pacientes' => array($paciente),
                'gestante' => $paciente->getPacienteGestante(),
            )));
        }
    }

    /**
     * @Route("/editPaciente/{idPaciente}/{origen}", name="editPaciente")
     */
    public function editPacienteAction($idPaciente ,$origen)
    {
        $em = $this->getDoctrine()->getManager();
        $paciente = $em->getRepository('AppBundle:Paciente')->find($idPaciente);
        $coloresPiel = $em->getRepository('AppBundle:ColorPiel')->findAll();
        $nivelesEscolaridad = $em->getRepository('AppBundle:NivelEscolaridad')->findAll();
        $estadosCiviles = $em->getRepository('AppBundle:EstadoCivil')->findAll();
        $ocupaciones = $em->getRepository('AppBundle:Ocupacion')->findAll();
        $unidades = $em->getRepository('AppBundle:Unidad')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $etiologias = $em->getRepository('AppBundle:Etiologia')->findAll();
        $tiposHepatitis = $em->getRepository('AppBundle:TipoHepatitis')->findAll();
        $estadiosHepatitis = $em->getRepository('AppBundle:EstadioHepatitis')->findAll();
        $formasInfeccion = $em->getRepository('AppBundle:FormaInfeccion')->findAll();
        $fuentesPesquisa = $em->getRepository('AppBundle:FuentePesquisa')->findAll();
        $motivosFuentePesquisa = $em->getRepository('AppBundle:MotivoFuentePesquisa')->findAll();
        $gruposVulnerables = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();
        $causasFallecimiento = $em->getRepository('AppBundle:CausaFallecimiento')->findAll();
        $antecedentes = $em->getRepository('AppBundle:AntecedentePatologico')->findAll();
        $coinfecciones = $em->getRepository('AppBundle:Coinfeccion')->findAll();
        $medicamentos = $em->getRepository('AppBundle:Medicamento')->findAll();
        $evolucionesClinicas = $em->getRepository('AppBundle:EvolucionClinica')->findAll();
        $pruebas = $em->getRepository('AppBundle:Prueba')->findAll();
        $resultadosPruebas = $em->getRepository('AppBundle:ResultadoPrueba')->findAll();


        return $this->render('Pacientes/GestionPaciente/editPaciente.html.twig' , array(
            'paciente' => $paciente,
            'coloresPiel'=>$coloresPiel,
            'nivelesEscolaridad' => $nivelesEscolaridad,
            'estadosCiviles' => $estadosCiviles,
            'ocupaciones' => $ocupaciones,
            'unidades' => $unidades,
            'municipios' => $municipios,
            'provincias' => $provincias,
            'etiologias' => $etiologias,
            'tiposHepatitis' => $tiposHepatitis,
            'estadiosHepatitis' => $estadiosHepatitis,
            'formasInfeccion' => $formasInfeccion,
            'fuentesPesquisa' => $fuentesPesquisa,
            'motivosFuentePesquisa' => $motivosFuentePesquisa,
            'gruposVulnerables' => $gruposVulnerables,
            'causasFallecimiento' => $causasFallecimiento,
            'antecedentes' => $antecedentes,
            'coinfecciones' => $coinfecciones,
            'medicamentos' => $medicamentos,
            'evolucionesClinicas' => $evolucionesClinicas,
            'pruebas' => $pruebas,
            'resultadosPruebas' => $resultadosPruebas,
            'origen' => $origen,
        ));
    }

    /**
     * @Route("/updatePacienteGeneral", name="updatePacienteGeneral")
     */
    public function updateGeneralAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idPaciente' => $peticion->request->get('idPaciente'),
            'carnetIdentidad' => $peticion->request->get('carnetIdentidad'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'edad' => $peticion->request->get('edad'),
            'sexo' => $peticion->request->get('sexo'),
            'colorPiel' => $peticion->request->get('colorPiel'),
            'estadoCivil' => $peticion->request->get('estadoCivil'),
            'nivelEscolaridad' => $peticion->request->get('nivelEscolaridad'),
            'ocupacion' => $peticion->request->get('ocupacion'),
            'gestante' => $peticion->request->get('gestante'),
            'fechaEdadGestacional' => $peticion->request->get('fechaEdadGestacional'),
            'semanaGestacional' => $peticion->request->get('semanaGestacional'),
            'diasGestacional' => $peticion->request->get('diasGestacional'),
            'orientacionesSexuales' => $peticion->request->get('orientacionesSexuales'),
        );

        $dataGestante = [];
        if($data['gestante'] == 1){

            $dataGestante = array(
                'fechaEdadGestacional' => $peticion->request->get('fechaEdadGestacional'),
                'semanaGestacional' => $peticion->request->get('semanaGestacional'),
                'diasGestacional' => $peticion->request->get('diasGestacional'),
            );

        }
        $user = $this->getUser();
        $resp = $em->getRepository('AppBundle:Paciente')->modificarPacienteGeneral($data , $dataGestante ,$user);
        return new Response($resp);
    }

    /**
     * @Route("/updatePacienteLocalizacion", name="updatePacienteLocalizacion")
     */
    public function updatePacienteLocalizacionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idPaciente' => $peticion->request->get('idPaciente'),
            'direccionCarnet' => $peticion->request->get('direccionCarnet'),
            'municipioCarnet' => $peticion->request->get('municipioCarnet'),
            'unidadAtencion' => $peticion->request->get('unidadAtencion'),
            'direccionResidencia' => $peticion->request->get('direccionResidencia'),
            'municipioResidencia' => $peticion->request->get('municipioResidencia'),
        );

        $user = $this->getUser();
        $resp = $em->getRepository('AppBundle:Paciente')->modificarPacienteLocalizacion($data , $user);
        return new Response($resp);

    }

    /**
     * @Route("/updatePacienteDiagnostico", name="updatePacienteDiagnostico")
     */
    public function updatePacienteDiagnosticoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idPaciente' => $peticion->request->get('idPaciente'),
            'fechaDiagnostico' => $peticion->request->get('fechaDiagnostico'),
            'tipoHepatitis' => $peticion->request->get('tipoHepatitis'),
            'etiologia' => $peticion->request->get('etiologia'),
            'estadioHepatitis' => $peticion->request->get('estadioHepatitis'),
            'formaInfeccion' => $peticion->request->get('formaInfeccion'),
            'grupoVulnerable' => $peticion->request->get('grupoVulnerable'),
            'fuentePesquisa' => $peticion->request->get('fuentePesquisa'),
            'motivoFuentePesquisa' => $peticion->request->get('motivoFuentePesquisa'),
            'transfusion' => $peticion->request->get('transfusion'),
            'evolucionesClinicas' => $peticion->request->get('evolucionesClinicas'),
            'idCausaFallecimiento' => $peticion->request->get('idCausaFallecimiento'),
        );

        $user = $this->getUser();
        $resp = $em->getRepository('AppBundle:Paciente')->modificarPacienteDiagnostico($data , $user);
        return new Response($resp);
    }

    /**
     * @Route("/updatePacienteEnfermedades", name="updatePacienteEnfermedades")
     */
    public function updatePacienteEnfermedadesAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idPaciente' => $peticion->request->get('idPaciente'),
            'antecedentesPatologicos' => $peticion->request->get('antecedentesPatologicos'),
            'coinfecciones' => $peticion->request->get('coinfecciones'),
        );

        $user = $this->getUser();
        $resp = $em->getRepository('AppBundle:Paciente')->modificarPacienteEnfemedades($data , $user);
        return new Response($resp);
    }

    /**
     * @Route("/updatePacienteTratamiento", name="updatePacienteTratamiento")
     */
    public function updatePacienteTratamientoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $paciente = $em->getRepository('AppBundle:Paciente')->find($peticion->request->get('idPaciente'));
        $pacienteEsquemasMedicamentos = $peticion->request->get('pacienteEsquemasMedicamentos');

        $user = $this->getUser();
        $resp = $em->getRepository('AppBundle:PacienteEsquemaMedicamento')->modificarEsquemasMedicamentos($pacienteEsquemasMedicamentos , $paciente ,$user);
        return new Response($resp);
    }

    /**
     * @Route("/updatePacientePrueba", name="updatePacientePrueba")
     */
    public function updatePacientePruebaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $paciente = $em->getRepository('AppBundle:Paciente')->find($peticion->request->get('idPaciente'));
        $pacientePruebas = $peticion->request->get('pruebasPaciente');

        $user = $this->getUser();
        $resp = $em->getRepository('AppBundle:PacientePrueba')->modificarPruebas($pacientePruebas, $paciente , $user);
        return new Response($resp);
    }

    /**
     * @Route("/deletePaciente", name="deletePaciente")
     */
    public function deletePacienteAction()
    {
        $peticion = Request::createFromGlobals();
        $idPaciente = $peticion->request->get('idPaciente');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Paciente')->eliminarPaciente($idPaciente);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Paciente',
                'descripcion' => 'Se eliminó el paciente: '.$resp->nombreCompleto()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/listadoGestantesSinHijosFueraTiempo", name="listadoGestantesSinHijosFueraTiempo")
     */
    public function listadoGestantesSinHijosFueraTiempoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $gestantes = $em->getRepository('AppBundle:PacienteGestante')->gestantesFueraDeTiempoSinHijos($user);

        return $this->render('Alertas/listadoGestantesSinHijos.html.twig' , array(

                'gestantes' => $gestantes)
        );

    }

    /**
     * @Route("foneticoPaciente", name="fonetico_paciente")
     */
    public function foneticoPacienteAction()
    {

        $em = $this->getDoctrine()->getManager();
        $pacientes = $em->getRepository('AppBundle:Paciente')->updateFonetico();


        if (count($pacientes) > 0) {
            foreach ($pacientes as $paciente) {
                $paciente->setFonNombre(metaphone($paciente->getNombre(), 5));
                $paciente->setFonPrimerApellido(metaphone($paciente->getPrimerApellido(), 5));
                $paciente->setFonsegundoApellido(metaphone($paciente->getSegundoApellido(), 5));
                $em->persist($paciente);
            }
            $em->flush();



            $this->addFlash('mensaje', 'Se actualizó el fonético en ' . count($pacientes) . ' pacientes');
        } else {
            $this->addFlash('mensaje', 'No es necesario actualizar el fonético');
        }
        return $this->redirectToRoute('inicio');
    }
}
