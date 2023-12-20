<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{


    /**
     * @Route("/gestionarProvincias", name="gestionarProvincias")
     */
    public function gestionarProvinciasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $provincias  = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Provincias',
            'descripcion' => 'Listado de provincias'
        ));

        return $this->render('Nomencladores/GestionProvincia/gestionProvincias.html.twig' , array('provincias' => $provincias));
    }

    /**
     * @Route("/addProvincia", name="addProvincia")
     */
    public function addProvinciaAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Provincias - Agregar Provincia',
            'descripcion' => 'Formulario para agregar una provincia'
        ));
        return $this->render('Nomencladores/GestionProvincia/addProvincia.html.twig');
    }

    /**
     * @Route("/insertProvincia", name="insertProvincia")
     */
    public function insertProvinciaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'codigo' => $peticion->request->get('codigo'),
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:Provincia')->agregarProvincia($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Provincia',
                'descripcion' => 'Se insertó una nueva provincia con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editProvincia/{idProvincia}", name="editProvincia")
     */
    public function editProvinciaAction($idProvincia)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia = $em->getRepository('AppBundle:Provincia')->find($idProvincia);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Provincias - Editar Provincia',
            'descripcion' => 'Formulario para editar la provincia: '.$provincia->getNombre()
        ));

        return $this->render('Nomencladores/GestionProvincia/editProvincia.html.twig' , array('provincia' => $provincia));
    }

    /**
     * @Route("/updateProvincia", name="updateProvincia")
     */
    public function updateProvinciaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idProvincia' => $peticion->request->get('idProvincia'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:Provincia')->modificarProvincia($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar provincia',
                'descripcion' => 'Se modificó la provincia:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteProvincia", name="deleteProvincia")
     */
    public function deleteProvinciaAction()
    {
        $peticion = Request::createFromGlobals();
        $idProvincia = $peticion->request->get('idProvincia');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Provincia')->eliminarProvincia($idProvincia);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Provincia',
                'descripcion' => 'Se eliminó la provincia: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarUnidades", name="gestionarUnidades")
     */
    public function gestionarUnidadesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $unidades  = $em->getRepository('AppBundle:Unidad')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Unidades',
            'descripcion' => 'Listado de unidades'
        ));

        return $this->render('Nomencladores/GestionUnidad/gestionUnidades.html.twig' , array('unidades' => $unidades));
    }

    /**
     * @Route("/addUnidad", name="addUnidad")
     */
    public function addUnidadAction()
    {
        $em = $this->getDoctrine()->getManager();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Unidades - Agregar Unidad',
            'descripcion' => 'Formulario para agregar una unidad'
        ));

        return $this->render('Nomencladores/GestionUnidad/addUnidad.html.twig' , array('municipios' => $municipios, 'provincias' => $provincias));
    }

    /**
     * @Route("/insertUnidad", name="insertUnidad")
     */
    public function insertUnidadAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'codigo' => $peticion->request->get('codigo'),
            'nombre' => $peticion->request->get('nombre'),
            'idMunicipio' => $peticion->request->get('municipio'),
        );
        $unidad = $em->getRepository('AppBundle:Unidad')->agregarUnidad($data);

        if(is_string($unidad)) return new Response($unidad);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Unidad',
                'descripcion' => 'Se insertó una nueva unidad con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editUnidad/{idUnidad}", name="editUnidad")
     */
    public function editUnidadAction($idUnidad)
    {
        $em = $this->getDoctrine()->getManager();
        $unidad = $em->getRepository('AppBundle:Unidad')->find($idUnidad);
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Unidades - Editar Unidad',
            'descripcion' => 'Formulario para editar la unidad: '.$unidad->getNombre()
        ));

        return $this->render('Nomencladores/GestionUnidad/editUnidad.html.twig' , array(
            'unidad' => $unidad,
            'municipios' => $municipios,
            'provincias' => $provincias
        ));
    }

    /**
     * @Route("/updateUnidad", name="updateUnidad")
     */
    public function updateUnidadAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idUnidad' => $peticion->request->get('idUnidad'),
            'nombre' => $peticion->request->get('nombre'),
            'idMunicipio' => $peticion->request->get('municipio')
        );

        $unidad = $em->getRepository('AppBundle:Unidad')->modificarUnidad($data);


        if(is_string($unidad)) return new Response($unidad);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Unidad',
                'descripcion' => 'Se modificó la unidad:  '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/deleteUnidad", name="deleteUnidad")
     */
    public function deleteUnidadAction()
    {
        $peticion = Request::createFromGlobals();
        $idUnidad = $peticion->request->get('idUnidad');
        $em = $this->getDoctrine()->getManager();

        $unidad  = $em->getRepository('AppBundle:Unidad')->eliminarUnidad($idUnidad);

        if(is_string($unidad)) return new Response($unidad);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Unidad',
                'descripcion' => 'Se eliminó la unidad: '.$unidad->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarMunicipios", name="gestionarMunicipios")
     */
    public function gestionarMunicipiosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $municipios  = $em->getRepository('AppBundle:Municipio')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Municipios',
            'descripcion' => 'Listado de municipios'
        ));

        return $this->render('Nomencladores/GestionMunicipio/gestionMunicipios.html.twig' , array('municipios' => $municipios));
    }

    /**
     * @Route("/addMunicipio", name="addMunicipio")
     */
    public function addMunicipioAction()
    {
        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Municipios - Agregar Municipio',
            'descripcion' => 'Formulario para agregar un municipio'
        ));

        return $this->render('Nomencladores/GestionMunicipio/addMunicipio.html.twig' , array('provincias' => $provincias));
    }

    /**
     * @Route("/insertMunicipio", name="insertMunicipio")
     */
    public function insertMunicipioAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'codigo' => $peticion->request->get('codigo'),
            'nombre' => $peticion->request->get('nombre'),
            'idProvincia' => $peticion->request->get('provincia'),
        );
        $resp = $em->getRepository('AppBundle:Municipio')->agregarMunicipio($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Municipio',
                'descripcion' => 'Se insertó un nuevo municipio con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editMunicipio/{idMunicipio}", name="editMunicipio")
     */
    public function editMunicipioAction($idMunicipio)
    {
        $em = $this->getDoctrine()->getManager();
        $municipio = $em->getRepository('AppBundle:Municipio')->find($idMunicipio);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Municipios - Editar Municipio',
            'descripcion' => 'Formulario para editar el municipio: '.$municipio->getNombre()
        ));

        return $this->render('Nomencladores/GestionMunicipio/editMunicipio.html.twig' , array('municipio' => $municipio , 'provincias' => $provincias));
    }

    /**
     * @Route("/updateMunicipio", name="updateMunicipio")
     */
    public function updateMunicipioAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idMunicipio' => $peticion->request->get('idMunicipio'),
            'nombre' => $peticion->request->get('nombre'),
            'idProvincia' => $peticion->request->get('provincia')
        );

        $resp = $em->getRepository('AppBundle:Municipio')->modificarMunicipio($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Municipio',
                'descripcion' => 'Se modificó el municipio:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteMunicipio", name="deleteMunicipio")
     */
    public function deleteMunicipioAction()
    {
        $peticion = Request::createFromGlobals();
        $idMunicipio = $peticion->request->get('idMunicipio');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Municipio')->eliminarMunicipio($idMunicipio);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Municipio',
                'descripcion' => 'Se eliminó el municipio: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarMedicamentos", name="gestionarMedicamentos")
     */
    public function gestionarMedicamentosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $medicamentos  = $em->getRepository('AppBundle:Medicamento')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Medicamentos',
            'descripcion' => 'Listado  de Medicamentos'
        ));

        return $this->render('Nomencladores/GestionMedicamento/gestionMedicamentos.html.twig' , array('medicamentos' => $medicamentos));
    }

    /**
     * @Route("/addMedicamento", name="addMedicamento")
     */
    public function addMedicamentoAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Medicamentos - Agregar Esquemas de Medicamentos',
            'descripcion' => 'Formulario para agregar un medicamentos'
        ));
        return $this->render('Nomencladores/GestionMedicamento/addMedicamento.html.twig');
    }
    /**
     * @Route("/insertMedicamento", name="insertMedicamento")
     */
    public function insertMedicamentoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:Medicamento')->agregarMedicamento($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Medicamento',
                'descripcion' => 'Se insertó el medicamento: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editMedicamento/{idMedicamento}", name="editMedicamento")
     */
    public function editMedicamentoAction($idMedicamento)
    {
        $em = $this->getDoctrine()->getManager();
        $medicamento = $em->getRepository('AppBundle:Medicamento')->find($idMedicamento);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Medicamentos  - Editar Esquema de Medicamento',
            'descripcion' => 'Formulario para editar el medicamento: '.$medicamento->getNombre()
        ));

        return $this->render('Nomencladores/GestionMedicamento/editMedicamento.html.twig' , array('medicamento' => $medicamento));
    }

    /**
     * @Route("/updateMedicamento", name="updateMedicamento")
     */
    public function updateMedicamentoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idMedicamento' => $peticion->request->get('idMedicamento'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:Medicamento')->modificarMedicamento($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar  Medicamento',
                'descripcion' => 'Se modificó el  medicamento:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteMedicamento", name="deleteMedicamento")
     */
    public function deleteMedicamentoAction()
    {
        $peticion = Request::createFromGlobals();
        $idMedicamento = $peticion->request->get('idMedicamento');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Medicamento')->eliminarMedicamento($idMedicamento);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar  Medicamentos',
                'descripcion' => 'Se eliminó el  medicamento: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarUsuarios", name="gestionarUsuarios")
     */
    public function gestionarUsuariosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $usuarios = $em->getRepository('AppBundle:Usuario')->listarUsuarios($user);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Usuarios',
            'descripcion' => 'Listado de usuarios'
        ));

        return $this->render('Nomencladores/GestionUsuario/gestionUsuarios.html.twig' , array('usuarios' => $usuarios));
    }

    /**
     * @Route("/addUsuario", name="addUsuario")
     */
    public function addUsuarioAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $unidades = $em->getRepository('AppBundle:Unidad')->listarUnidades($user);
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $niveles = $em->getRepository('AppBundle:NivelAcceso')->listarNivelesAcceso($user);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $roles = $em->getRepository('AppBundle:Role')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Usuarios - Agregar Usuario',
            'descripcion' => 'Formulario para agregar un usuario'
        ));


        return $this->render('Nomencladores/GestionUsuario/addUsuario.html.twig' , array(
                'unidades' => $unidades ,
                'provincias' => $provincias ,
                'municipios' => $municipios,
                'roles' => $roles,
                'nivelesAcceso' => $niveles)
        );
    }
    /**
     * @Route("/insertUsuario", name="insertUsuario")
     */
    public function insertUsuarioAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'username' => $peticion->request->get('username'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'nivelAcceso' => $peticion->request->get('nivelAcceso'),
            'unidad' => $peticion->request->get('unidad'),
            'roles' => $peticion->request->get('roles')
        );
        $resp = $em->getRepository('AppBundle:Usuario')->agregarUsuario($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Usuario',
                'descripcion' => 'Se insertó el usuario: '.$data['nombre']. ' '. $data['primerApellido']. ' '.$data['segundoApellido']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editUsuario/{idUsuario}", name="editUsuario")
     */
    public function editUsuarioAction($idUsuario)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $usuario = $em->getRepository('AppBundle:Usuario')->find($idUsuario);
        $unidades = $em->getRepository('AppBundle:Unidad')->listarUnidades($user);
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $niveles = $em->getRepository('AppBundle:NivelAcceso')->listarNivelesAcceso($user);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $roles = $em->getRepository('AppBundle:Role')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Usuarios  - Editar Usuario',
            'descripcion' => 'Formulario para editar el usuario: '.$usuario->getNombre(). ' '. $usuario->getPrimerApellido().' '.$usuario->getSegundoApellido()
        ));

        return $this->render('Nomencladores/GestionUsuario/editUsuario.html.twig' , array(
                'usuario' => $usuario,
                'unidades' => $unidades ,
                'provincias' => $provincias ,
                'municipios' => $municipios,
                'roles' => $roles,
                'nivelesAcceso' => $niveles)
        );
    }

    /**
     * @Route("/updateUsuario", name="updateUsuario")
     */
    public function updateUsuarioAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'idUsuario' => $peticion->request->get('idUsuario'),
            'username' => $peticion->request->get('username'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'nivelAcceso' => $peticion->request->get('nivelAcceso'),
            'unidad' => $peticion->request->get('unidad'),
            'roles' => $peticion->request->get('roles')
        );

        $resp = $em->getRepository('AppBundle:Usuario')->modificarUsuario($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Usuario',
                'descripcion' => 'Se modificó el usuario:  '.$data['nombre']. ' '. $data['primerApellido'].' '.$data['segundoApellido']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteUsuario", name="deleteUsuario")
     */
    public function deleteUsuarioAction()
    {
        $peticion = Request::createFromGlobals();
        $idUsuario = $peticion->request->get('idUsuario');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Usuario')->eliminarUsuario($idUsuario);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Usuario',
                'descripcion' => 'Se eliminó el usuario: '.$resp->getNombre(). ' ' .$resp->getPrimerApellido(). ' '.$resp->getSegundoApellido()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarTiposHepatitis", name="gestionarTiposHepatitis")
     */
    public function gestionarTiposHepatitisAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tiposHepatitis  = $em->getRepository('AppBundle:TipoHepatitis')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Tipos de Hepatitis',
            'descripcion' => 'Listado de Tipos de Hepatitis'
        ));

        return $this->render('Nomencladores/GestionTipoHepatitis/gestionTiposHepatitis.html.twig' , array('tiposHepatitis' => $tiposHepatitis));
    }

    /**
     * @Route("/addTipoHepatitis", name="addTipoHepatitis")
     */
    public function addTipoHepatitisAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Tipos de Hepatitis - Agregar Tipo de Hepatitis',
            'descripcion' => 'Formulario para agregar un Tipo de Hepatitis'
        ));
        return $this->render('Nomencladores/GestionTipoHepatitis/addTipoHepatitis.html.twig');
    }

    /**
     * @Route("/insertTipoHepatitis", name="insertTipoHepatitis")
     */
    public function insertTipoHepatitisAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:TipoHepatitis')->agregarTipoHepatitis($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Tipo de Hepatitis',
                'descripcion' => 'Se insertó un nuevo tipo de hepatitis con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editTipoHepatitis/{idTipoHepatitis}", name="editTipoHepatitis")
     */
    public function editTipoHepatitisAction($idTipoHepatitis)
    {
        $em = $this->getDoctrine()->getManager();
        $tipoHepatitis = $em->getRepository('AppBundle:TipoHepatitis')->find($idTipoHepatitis);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Tipos de Hepatitis - Editar Tipo de Hepatitis',
            'descripcion' => 'Formulario para editar un tipo de hepatitis: '.$tipoHepatitis->getNombre()
        ));

        return $this->render('Nomencladores/GestionTipoHepatitis/editTipoHepatitis.html.twig' , array('tipoHepatitis' => $tipoHepatitis));
    }

    /**
     * @Route("/updateTipoHepatitis", name="updateTipoHepatitis")
     */
    public function updateTipoHepatitisAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idTipoHepatitis' => $peticion->request->get('idTipoHepatitis'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:TipoHepatitis')->modificarTipoHepatitis($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Tipo de Hepatitis',
                'descripcion' => 'Se modificó el tipo de hepatitis:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteTipoHepatitis", name="deleteTipoHepatitis")
     */
    public function deleteTipoHepatitisAction()
    {
        $peticion = Request::createFromGlobals();
        $idTipoHepatitis = $peticion->request->get('idTipoHepatitis');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:TipoHepatitis')->eliminarTipoHepatitis($idTipoHepatitis);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Tipo de Hepatitis',
                'descripcion' => 'Se eliminó el tipo de hepatitis: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarEstadiosHepatitis", name="gestionarEstadiosHepatitis")
     */
    public function gestionarEstadiosHepatitisAction()
    {
        $em = $this->getDoctrine()->getManager();
        $estadiosHepatitis  = $em->getRepository('AppBundle:EstadioHepatitis')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Estadíos de Hepatitis',
            'descripcion' => 'Listado de Estadíos de Hepatitis'
        ));

        return $this->render('Nomencladores/GestionEstadioHepatitis/gestionEstadiosHepatitis.html.twig' , array('estadiosHepatitis' => $estadiosHepatitis));
    }

    /**
     * @Route("/addEstadioHepatitis", name="addEstadioHepatitis")
     */
    public function addEstadioHepatitisAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Estadíos de Hepatitis - Agregar Estadío de Hepatitis',
            'descripcion' => 'Formulario para agregar un Estadío de Hepatitis'
        ));
        return $this->render('Nomencladores/GestionEstadioHepatitis/addEstadioHepatitis.html.twig');
    }

    /**
     * @Route("/insertEstadioHepatitis", name="insertEstadioHepatitis")
     */
    public function insertEstadioHepatitisAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:EstadioHepatitis')->agregarEstadioHepatitis($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Estadío de Hepatitis',
                'descripcion' => 'Se insertó un nuevo estadío de hepatitis con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editEstadioHepatitis/{idEstadioHepatitis}", name="editEstadioHepatitis")
     */
    public function editEstadioHepatitisAction($idEstadioHepatitis)
    {
        $em = $this->getDoctrine()->getManager();
        $estadioHepatitis = $em->getRepository('AppBundle:EstadioHepatitis')->find($idEstadioHepatitis);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Estadío de Hepatitis - Editar Estadío de Hepatitis',
            'descripcion' => 'Formulario para editar un estadío de hepatitis: '.$estadioHepatitis->getNombre()
        ));

        return $this->render('Nomencladores/GestionEstadioHepatitis/editEstadioHepatitis.html.twig' , array('estadioHepatitis' => $estadioHepatitis));
    }

    /**
     * @Route("/updateEstadioHepatitis", name="updateEstadioHepatitis")
     */
    public function updateEstadioHepatitisAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idEstadioHepatitis' => $peticion->request->get('idEstadioHepatitis'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:EstadioHepatitis')->modificarEstadioHepatitis($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Estadío de Hepatitis',
                'descripcion' => 'Se modificó el estadío de hepatitis:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteEstadioHepatitis", name="deleteEstadioHepatitis")
     */
    public function deleteEstadioHepatitisAction()
    {
        $peticion = Request::createFromGlobals();
        $idEstadioHepatitis = $peticion->request->get('idEstadioHepatitis');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:EstadioHepatitis')->eliminarEstadioHepatitis($idEstadioHepatitis);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Estadío de Hepatitis',
                'descripcion' => 'Se eliminó el estadío de hepatitis: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarEvolucionClinica", name="gestionarEvolucionClinica")
     */
    public function gestionarEvolucionClinicaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evolucionClinicas  = $em->getRepository('AppBundle:EvolucionClinica')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Evolución Clínica',
            'descripcion' => 'Listado de evoluciones clínicas'
        ));

        return $this->render('Nomencladores/GestionEvolucionClinica/gestionEvolucionClinica.html.twig' , array('evolucionClinicas' => $evolucionClinicas));

    }

    /**
     * @Route("/addEvolucionClinica", name="addEvolucionClinica")
     */
    public function addEvolucionClinicaAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Evolución Clínica - Agregar evolución clínica',
            'descripcion' => 'Formulario para agregar una evolución clínica'
        ));
        return $this->render('Nomencladores/GestionEvolucionClinica/addEvolucionClinica.html.twig');
    }

    /**
     * @Route("/insertEvolucionClinica", name="insertEvolucionClinica")
     */
    public function insertEvolucionClinicaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:EvolucionClinica')->agregarEvolucionClinica($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Evolución Clínica',
                'descripcion' => 'Se insertó una nueva evolución clínica con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editEvolucionClinica/{idEvolucionClinica}", name="editEvolucionClinica")
     */
    public function editEvolucionClinicaAction($idEvolucionClinica)
    {
        $em = $this->getDoctrine()->getManager();
        $evolucionClinica = $em->getRepository('AppBundle:EvolucionClinica')->find($idEvolucionClinica);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Evolución Clínica - Editar Evolución Clínica',
            'descripcion' => 'Formulario para editar la evolución clínica: '.$evolucionClinica->getNombre()
        ));

        return $this->render('Nomencladores/GestionEvolucionClinica/editEvolucionClinica.html.twig' , array('evolucionClinica' => $evolucionClinica));
    }

    /**
     * @Route("/updateEvolucionClinica", name="updateEvolucionClinica")
     */
    public function updateEvolucionClinicaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idEvolucionClinica' => $peticion->request->get('idEvolucionClinica'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:EvolucionClinica')->modificarEvolucionClinica($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar evolución clínica',
                'descripcion' => 'Se modificó la evolución clínica:  '.$data['nombre']
            ));
            return new Response('ok');

        }
    }

    /**
     * @Route("/deleteEvolucionClinica", name="deleteEvolucionClinica")
     */
    public function deleteEvolucionClinicaAction()
    {
        $peticion = Request::createFromGlobals();
        $idEvolucionClinica = $peticion->request->get('idEvolucionClinica');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:EvolucionClinica')->eliminarEvolucionClinica($idEvolucionClinica);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Evolución clínica',
                'descripcion' => 'Se eliminó la evolución clínica: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }


    /**
     * @Route("/gestionarFuentePesquisa", name="gestionarFuentePesquisa")
     */
    public function gestionarFuentePesquisaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $fuentePesquisas  = $em->getRepository('AppBundle:FuentePesquisa')->findAll();

        /* $this->forward('AppBundle:Traza:insertTraza' , array(
             'operacion' => 'Nomencladores - Gestionar Fuentes de pesquisa',
             'descripcion' => 'Listado de fuentes de pesquisa'
         ));*/

        return $this->render('Nomencladores/GestionFuentePesquisa/gestionFuentePesquisa.html.twig' , array('fuentePesquisas' => $fuentePesquisas));

    }

    /**
     * @Route("/addFuentePesquisa", name="addFuentePesquisa")
     */
    public function addFuentePesquisaAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Fuentes de Pesquisa - Agregar Fuente de Pesquisa',
            'descripcion' => 'Formulario para agregar una fuente de pesquisa'
        ));
        return $this->render('Nomencladores/GestionFuentePesquisa/addFuentePesquisa.html.twig');
    }

    /**
     * @Route("/insertFuentePesquisa", name="insertFuentePesquisa")
     */
    public function insertFuentePesquisaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:FuentePesquisa')->agregarFuentePesquisa($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Fuente de Pesquisa',
                'descripcion' => 'Se insertó una nueva fuente de pesquisa con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editFuentePesquisa/{idFuentePesquisa}", name="editFuentePesquisa")
     */
    public function editFuentePesquisaAction($idFuentePesquisa)
    {
        $em = $this->getDoctrine()->getManager();
        $fuentePesquisa = $em->getRepository('AppBundle:FuentePesquisa')->find($idFuentePesquisa);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Fuentes de Pesquisa - Editar Fuente de Pesquisa',
            'descripcion' => 'Formulario para editar la fuente de pesquisa: '.$fuentePesquisa->getNombre()
        ));

        return $this->render('Nomencladores/GestionFuentePesquisa/editFuentePesquisa.html.twig' , array('fuentePesquisa' => $fuentePesquisa));
    }

    /**
     * @Route("/updateFuentePesquisa", name="updateFuentePesquisa")
     */
    public function updateFuentePesquisaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idFuentePesquisa' => $peticion->request->get('idFuentePesquisa'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:FuentePesquisa')->modificarFuentePesquisa($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar fuente de pesquisa',
                'descripcion' => 'Se modificó la fuente de pesquisa:  '.$data['nombre']
            ));
            return new Response('ok');

        }
    }

    /**
     * @Route("/deleteFuentePesquisa", name="deleteFuentePesquisa")
     */
    public function deleteFuentePesquisaAction()
    {
        $peticion = Request::createFromGlobals();
        $idFuentePesquisa = $peticion->request->get('idFuentePesquisa');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:FuentePesquisa')->eliminarFuentePesquisa($idFuentePesquisa);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Fuente de pesquisa',
                'descripcion' => 'Se eliminó la fuente de pesquisa: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarMotivoFuentePesquisa", name="gestionarMotivoFuentePesquisa")
     */
    public function gestionarMotivoFuentePesquisaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $motivoFuentePesquisas  = $em->getRepository('AppBundle:MotivoFuentePesquisa')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Motivo Fuente Pesquisa',
            'descripcion' => 'Listado de los motivos de fuente pesquisa'
        ));

        return $this->render('Nomencladores/GestionMotivoFuentePesquisa/gestionMotivoFuentePesquisa.html.twig' , array('motivoFuentePesquisas' => $motivoFuentePesquisas));
    }

    /**
     * @Route("/addMotivoFuentePesquisa", name="addMotivoFuentePesquisa")
     */
    public function addMotivoFuentePesquisaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $fuentePesquisas = $em->getRepository('AppBundle:FuentePesquisa')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Motivos de fuente pesquisa - Agregar Motivo de fuente pesquisa',
            'descripcion' => 'Formulario para agregar un motivo de fuente pesquisa'
        ));

        return $this->render('Nomencladores/GestionMotivoFuentePesquisa/addMotivoFuentePesquisa.html.twig' , array('fuentePesquisas' => $fuentePesquisas));
    }

    /**
     * @Route("/insertMotivoFuentePesquisa", name="insertMotivoFuentePesquisa")
     */
    public function insertMotivoFuentePesquisaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:MotivoFuentePesquisa')->agregarMotivoFuentePesquisia($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Motivo de Fuente Pesquisa',
                'descripcion' => 'Se insertó un nuevo motivo de fuente pesquisa con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editMotivoFuentePesquisa/{idMotivoFuentePesquisa}", name="editMotivoFuentePesquisa")
     */
    public function editMotivoFuentePesquisaAction($idMotivoFuentePesquisa)
    {
        $em = $this->getDoctrine()->getManager();
        $motivoFuentePesquisa = $em->getRepository('AppBundle:MotivoFuentePesquisa')->find($idMotivoFuentePesquisa);
        $fuentePesquisas = $em->getRepository('AppBundle:FuentePesquisa')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Motivos de fuente pesquisa - Editar Motivos de fuente pesquisa',
            'descripcion' => 'Formulario para editar el Motivo de fuente pesquisa: '.$motivoFuentePesquisa->getNombre()
        ));

        return $this->render('Nomencladores/GestionMotivoFuentePesquisa/editMotivoFuentePesquisa.html.twig' , array('motivoFuentePesquisa' => $motivoFuentePesquisa , 'fuentePesquisas' => $fuentePesquisas));
    }

    /**
     * @Route("/updateMotivoFuentePesquisa", name="updateMotivoFuentePesquisa")
     */
    public function updateMotivoFuentePesquisaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idMotivoFuentePesquisa' => $peticion->request->get('idMotivoFuentePesquisa'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:MotivoFuentePesquisa')->modificarMotivoFuentePesquisia($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Motivo de fuente pesquisa',
                'descripcion' => 'Se modificó el motivo de fuente pesquisa:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteMotivoFuentePesquisa", name="deleteMotivoFuentePesquisa")
     */
    public function deleteMotivoFuentePesquisaAction()
    {
        $peticion = Request::createFromGlobals();
        $idMotivoFuentePesquisa = $peticion->request->get('idMotivoFuentePesquisa');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:MotivoFuentePesquisa')->eliminarMotivoFuentePesquisia($idMotivoFuentePesquisa);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Motivo Fuente Pesquisa',
                'descripcion' => 'Se eliminó el motivo fuente pesquisa: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }


    /**
     * @Route("/gestionarOcupacion", name="gestionarOcupacion")
     */
    public function gestionarOcupacionAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ocupaciones  = $em->getRepository('AppBundle:Ocupacion')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar ocupación',
            'descripcion' => 'Listado de las ocupaciones'
        ));

        return $this->render('Nomencladores/GestionOcupacion/gestionOcupacion.html.twig' , array('ocupaciones' => $ocupaciones));
    }

    /**
     * @Route("/addOcupacion", name="addOcupacion")
     */
    public function addOcupacionAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Ocupación - Agregar Ocupación',
            'descripcion' => 'Formulario para agregar una Ocupación'
        ));
        return $this->render('Nomencladores/GestionOcupacion/addOcupacion.html.twig');
    }

    /**
     * @Route("/insertOcupacion", name="insertOcupacion")
     */
    public function insertOcupacion()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:Ocupacion')->agregarOcupacion($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Ocupación',
                'descripcion' => 'Se insertó una ocupación con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editOcupacion/{idOcupacion}", name="editOcupacion")
     */
    public function editOcupacionAction($idOcupacion)
    {
        $em = $this->getDoctrine()->getManager();
        $ocupacion = $em->getRepository('AppBundle:Ocupacion')->find($idOcupacion);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Ocupación - Editar Ocupación',
            'descripcion' => 'Formulario para editar una ocupación: '.$ocupacion->getNombre()
        ));

        return $this->render('Nomencladores/GestionOcupacion/editOcupacion.html.twig' , array('ocupacion' => $ocupacion));
    }

    /**
     * @Route("/updateOcupacion", name="updateOcupacion")
     */
    public function updateOcupacionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idOcupacion' => $peticion->request->get('idOcupacion'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:Ocupacion')->modificarOcupacion($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar ocupación',
                'descripcion' => 'Se modificó la ocupación:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteOcupacion", name="deleteOcupacion")
     */
    public function deleteOcupacionAction()
    {
        $peticion = Request::createFromGlobals();
        $idOcupacion = $peticion->request->get('idOcupacion');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Ocupacion')->eliminarOcupacion($idOcupacion);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar ocupación',
                'descripcion' => 'Se eliminó la ocupación: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }


    /**
     * @Route("/gestionarGrupoVulnerable", name="gestionarGrupoVulnerable")
     */
    public function gestionarGrupoVulnerableAction()
    {
        $em = $this->getDoctrine()->getManager();
        $gruposVulnerables  = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar grupo vulnerable',
            'descripcion' => 'Listado de los grupos vulnerables'
        ));

        return $this->render('Nomencladores/GestionGrupoVulnerable/gestionGrupoVulnerable.html.twig' , array('gruposVulnerables' => $gruposVulnerables));
    }

    /**
     * @Route("/addGrupoVulnerable", name="addGrupoVulnerable")
     */
    public function addGrupoVulnerableAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Grupo Vulnerable - Agregar grupo vulnerable',
            'descripcion' => 'Formulario para agregar un grupo vulnerable'
        ));
        return $this->render('Nomencladores/GestionGrupoVulnerable/addGrupoVulnerable.html.twig');
    }

    /**
     * @Route("/insertGrupoVulnerable", name="insertGrupoVulnerable")
     */
    public function insertGrupoVulnerable()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:GrupoVulnerable')->agregarGrupoVulnerable($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar grupo vulnerable',
                'descripcion' => 'Se insertó un grupo vulnerable con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editGrupoVulnerable/{idGrupoVulnerable}", name="editGrupoVulnerable")
     */
    public function editGrupoVulnerableAction($idGrupoVulnerable)
    {
        $em = $this->getDoctrine()->getManager();
        $grupoVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->find($idGrupoVulnerable);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar grupo vulnerable - Editar grupo vulnerable',
            'descripcion' => 'Formulario para editar un grupo vulnerable: '.$grupoVulnerable->getNombre()
        ));

        return $this->render('Nomencladores/GestionGrupoVulnerable/editGrupoVulnerable.html.twig' , array('grupoVulnerable' => $grupoVulnerable));
    }

    /**
     * @Route("/updateGrupoVulnerable", name="updateGrupoVulnerable")
     */
    public function updateGrupoVulnerableAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idGrupoVulnerable' => $peticion->request->get('idGrupoVulnerable'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:GrupoVulnerable')->modificarGrupoVulnerable($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar grupo vulnerable',
                'descripcion' => 'Se modificó el grupo vulnerable:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteGrupoVulnerable", name="deleteGrupoVulnerable")
     */
    public function deleteGrupoVulnerableAction()
    {
        $peticion = Request::createFromGlobals();
        $idGrupoVulnerable = $peticion->request->get('idGrupoVulnerable');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:GrupoVulnerable')->eliminarGrupoVulnerable($idGrupoVulnerable);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar grupo vulnerable',
                'descripcion' => 'Se eliminó el grupo vulnerable: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarAntecedentePatologico", name="gestionarAntecedentePatologico")
     */
    public function gestionarAntecedentePatologicoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $antecedentesPatologicos  = $em->getRepository('AppBundle:AntecedentePatologico')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar antecedentes patológicos',
            'descripcion' => 'Listado de los antecedentes patologicos'
        ));

        return $this->render('Nomencladores/GestionAntecedentePatologico/gestionAntecedentePatologico.html.twig' , array('antecedentesPatologicos' => $antecedentesPatologicos));
    }

    /**
     * @Route("/addAntecedentePatologico", name="addAntecedentePatologico")
     */
    public function addAntecedentePatologicoAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Antecedente patológico - Agregar antecedente patológico',
            'descripcion' => 'Formulario para agregar un antecedente patológico'
        ));
        return $this->render('Nomencladores/GestionAntecedentePatologico/addAntecedentePatologico.html.twig');
    }

    /**
     * @Route("/insertAntecedentePatologico", name="insertAntecedentePatologico")
     */
    public function insertAntecedentePatologico()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:AntecedentePatologico')->agregarAntecedentePatologico($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Antecedente patológico',
                'descripcion' => 'Se insertó un antecedente patológico con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editAntecedentePatologico/{idAntecedentePatologico}", name="editAntecedentePatologico")
     */
    public function editAntecedentePatologicoAction($idAntecedentePatologico)
    {
        $em = $this->getDoctrine()->getManager();
        $antecedentePatologico = $em->getRepository('AppBundle:AntecedentePatologico')->find($idAntecedentePatologico);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Antecedente patológico - Editar Antecedente patológico',
            'descripcion' => 'Formulario para editar un antecedente patológico: '.$antecedentePatologico->getNombre()
        ));

        return $this->render('Nomencladores/GestionAntecedentePatologico/editAntecedentePatologico.html.twig', array('antecedentePatologico' => $antecedentePatologico));
    }

    /**
     * @Route("/updateAntecedentePatologico", name="updateAntecedentePatologico")
     */
    public function updateAntecedentePatologicoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idAntecedentePatologico' => $peticion->request->get('idAntecedentePatologico'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:AntecedentePatologico')->modificarAntecedentePatologico($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar antecedente patológico',
                'descripcion' => 'Se modificó el antecedente patológico:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteAntecedentePatologico", name="deleteAntecedentePatologico")
     */
    public function deleteAntecedentePatologicoAction()
    {
        $peticion = Request::createFromGlobals();
        $idAntecedentePatologico = $peticion->request->get('idAntecedentePatologico');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:AntecedentePatologico')->eliminarAntecedentePatologico($idAntecedentePatologico);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar antecedente patológico',
                'descripcion' => 'Se eliminó el antecedente patológico: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarCoinfeccion", name="gestionarCoinfeccion")
     */
    public function gestionarCoinfeccionAction()
    {
        $em = $this->getDoctrine()->getManager();
        $coinfecciones  = $em->getRepository('AppBundle:Coinfeccion')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar coinfección',
            'descripcion' => 'Listado de las coinfecciones'
        ));

        return $this->render('Nomencladores/GestionCoinfeccion/gestionCoinfeccion.html.twig' , array('coinfecciones' => $coinfecciones));
    }

    /**
     * @Route("/addCoinfeccion", name="addCoinfeccion")
     */
    public function addCoinfeccionAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Coinfección - Agregar Coinfección',
            'descripcion' => 'Formulario para agregar una Coinfección'
        ));
        return $this->render('Nomencladores/GestionCoinfeccion/addCoinfeccion.html.twig');
    }

    /**
     * @Route("/insertCoinfeccion", name="insertCoinfeccion")
     */
    public function insertCoinfeccion()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:Coinfeccion')->agregarCoinfeccion($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Coinfección',
                'descripcion' => 'Se insertó una coinfección con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editCoinfeccion/{idCoinfeccion}", name="editCoinfeccion")
     */
    public function editCoinfeccionAction($idCoinfeccion)
    {
        $em = $this->getDoctrine()->getManager();
        $coinfeccion = $em->getRepository('AppBundle:Coinfeccion')->find($idCoinfeccion);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Coinfección - Editar Coinfección',
            'descripcion' => 'Formulario para editar una coinfección: '.$coinfeccion->getNombre()
        ));

        return $this->render('Nomencladores/GestionCoinfeccion/editCoinfeccion.html.twig' , array('coinfeccion' => $coinfeccion));
    }

    /**
     * @Route("/updateCoinfeccion", name="updateCoinfeccion")
     */
    public function updateCoinfeccionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idCoinfeccion' => $peticion->request->get('idCoinfeccion'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:Coinfeccion')->modificarCoinfeccion($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar coinfección',
                'descripcion' => 'Se modificó la coinfección:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteCoinfeccion", name="deleteCoinfeccion")
     */
    public function deleteCoinfeccionAction()
    {
        $peticion = Request::createFromGlobals();
        $idCoinfeccion = $peticion->request->get('idCoinfeccion');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Coinfeccion')->eliminarCoinfeccion($idCoinfeccion);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar coinfección',
                'descripcion' => 'Se eliminó la coinfección: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarEstadoCivil", name="gestionarEstadoCivil")
     */
    public function gestionarEstadoCivilAction()
    {
        $em = $this->getDoctrine()->getManager();
        $estadosCiviles  = $em->getRepository('AppBundle:EstadoCivil')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar estado civil',
            'descripcion' => 'Listado de los estados civiles'
        ));

        return $this->render('Nomencladores/GestionEstadoCivil/gestionEstadoCivil.html.twig' , array('estadosCiviles' => $estadosCiviles));
    }

    /**
     * @Route("/addEstadoCivil", name="addEstadoCivil")
     */
    public function addEstadoCivilAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Coinfección - Agregar Estado Civil',
            'descripcion' => 'Formulario para agregar un Estado Civil'
        ));
        return $this->render('Nomencladores/GestionEstadoCivil/addEstadoCivil.html.twig');
    }

    /**
     * @Route("/insertEstadoCivil", name="insertEstadoCivil")
     */
    public function insertEstadoCivil()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:EstadoCivil')->agregarEstadoCivil($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Estado Civil',
                'descripcion' => 'Se insertó un estado civil con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editEstadoCivil/{idEstadoCivil}", name="editEstadoCivil")
     */
    public function editEstadoCivilAction($idEstadoCivil)
    {
        $em = $this->getDoctrine()->getManager();
        $estadoCivil = $em->getRepository('AppBundle:EstadoCivil')->find($idEstadoCivil);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Estado Civil - Editar Estado Civil',
            'descripcion' => 'Formulario para editar un estado civil: '.$estadoCivil->getNombre()
        ));

        return $this->render('Nomencladores/GestionEstadoCivil/editEstadoCivil.html.twig' , array('estadoCivil' => $estadoCivil));
    }

    /**
     * @Route("/updateEstadoCivil", name="updateEstadoCivil")
     */
    public function updateEstadoCivilAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idEstadoCivil' => $peticion->request->get('idEstadoCivil'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:EstadoCivil')->modificarEstadoCivil($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar estado civil',
                'descripcion' => 'Se modificó el estado civil:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteEstadoCivil", name="deleteEstadoCivil")
     */
    public function deleteEstadoCivilAction()
    {
        $peticion = Request::createFromGlobals();
        $idEstadoCivil = $peticion->request->get('idEstadoCivil');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:EstadoCivil')->eliminarEstadoCivil($idEstadoCivil);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar estado civil',
                'descripcion' => 'Se eliminó el estado civil: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarNivelEscolaridad", name="gestionarNivelEscolaridad")
     */
    public function gestionarNivelEscolaridadAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nivelesEscolaridad  = $em->getRepository('AppBundle:NivelEscolaridad')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar nivel de escolaridad',
            'descripcion' => 'Listado de los niveles de escolaridad'
        ));

        return $this->render('Nomencladores/GestionNivelEscolaridad/gestionNivelEscolaridad.html.twig' , array('nivelesEscolaridad' => $nivelesEscolaridad));
    }

    /**
     * @Route("/addNivelEscolaridad", name="addNivelEscolaridad")
     */
    public function addNivelEscolaridadAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Nivel de Escolaridad - Agregar Nivel de Escolaridad',
            'descripcion' => 'Formulario para agregar un Nivel de Escolaridad'
        ));
        return $this->render('Nomencladores/GestionNivelEscolaridad/addNivelEscolaridad.html.twig');
    }

    /**
     * @Route("/insertNivelEscolaridad", name="insertNivelEscolaridad")
     */
    public function insertNivelEscolaridad()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:NivelEscolaridad')->agregarNivelEscolaridad($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Nivel de Escolaridad',
                'descripcion' => 'Se insertó un nivel de escolaridad con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editNivelEscolaridad/{idNivelEscolaridad}", name="editNivelEscolaridad")
     */
    public function editNivelEscolaridadAction($idNivelEscolaridad)
    {
        $em = $this->getDoctrine()->getManager();
        $nivelEscolaridad = $em->getRepository('AppBundle:NivelEscolaridad')->find($idNivelEscolaridad);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Nivel de Escolaridad - Editar Nivel de Escolaridad',
            'descripcion' => 'Formulario para editar un nivel de escolaridad: '.$nivelEscolaridad->getNombre()
        ));

        return $this->render('Nomencladores/GestionNivelEscolaridad/editNivelEscolaridad.html.twig' , array('nivelEscolaridad' => $nivelEscolaridad));
    }

    /**
     * @Route("/updateNivelEscolaridad", name="updateNivelEscolaridad")
     */
    public function updateNivelEscolaridadAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idNivelEscolaridad' => $peticion->request->get('idNivelEscolaridad'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:NivelEscolaridad')->modificarNivelEscolaridad($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar nivel de escolaridad',
                'descripcion' => 'Se modificó el nivel de escolaridad:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteNivelEscolaridad", name="deleteNivelEscolaridad")
     */
    public function deleteNivelEscolaridadAction()
    {
        $peticion = Request::createFromGlobals();
        $idNivelEscolaridad = $peticion->request->get('idNivelEscolaridad');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:NivelEscolaridad')->eliminarNivelEscolaridad($idNivelEscolaridad);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar nivel de escolaridad',
                'descripcion' => 'Se eliminó el nivel de escolaridad: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarVacuna", name="gestionarVacuna")
     */
    public function gestionarVacunaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $vacunas  = $em->getRepository('AppBundle:Vacuna')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar vacuna',
            'descripcion' => 'Listado de las vacunas'
        ));

        return $this->render('Nomencladores/GestionVacuna/gestionVacuna.html.twig' , array('vacunas' => $vacunas));
    }

    /**
     * @Route("/addVacuna", name="addVacuna")
     */
    public function addVacunaAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Vacuna - Agregar Vacuna',
            'descripcion' => 'Formulario para agregar una Vacuna'
        ));
        return $this->render('Nomencladores/GestionVacuna/addVacuna.html.twig');
    }

    /**
     * @Route("/insertVacuna", name="insertVacuna")
     */
    public function insertVacuna()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:Vacuna')->agregarVacuna($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Vacuna',
                'descripcion' => 'Se insertó una vacuna con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editVacuna/{idVacuna}", name="editVacuna")
     */
    public function editVacunaAction($idVacuna)
    {
        $em = $this->getDoctrine()->getManager();
        $vacuna = $em->getRepository('AppBundle:Vacuna')->find($idVacuna);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Vacuna - Editar Vacuna',
            'descripcion' => 'Formulario para editar una vacuna: '.$vacuna->getNombre()
        ));

        return $this->render('Nomencladores/GestionVacuna/editVacuna.html.twig' , array('vacuna' => $vacuna));
    }

    /**
     * @Route("/updateVacuna", name="updateVacuna")
     */
    public function updateVacunaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idVacuna' => $peticion->request->get('idVacuna'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:Vacuna')->modificarVacuna($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar vacuna',
                'descripcion' => 'Se modificó la vacuna:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteVacuna", name="deleteVacuna")
     */
    public function deleteVacunaAction()
    {
        $peticion = Request::createFromGlobals();
        $idVacuna = $peticion->request->get('idVacuna');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Vacuna')->eliminarVacuna($idVacuna);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar vacuna',
                'descripcion' => 'Se eliminó la vacuna: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarPrueba", name="gestionarPrueba")
     */
    public function gestionarPruebaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pruebas  = $em->getRepository('AppBundle:Prueba')->findAll();
        $tiposEtiologias = $em->getRepository('AppBundle:TipoEtiologia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar prueba',
            'descripcion' => 'Listado de las pruebas'
        ));

        return $this->render('Nomencladores/GestionPrueba/gestionPrueba.html.twig' , array('pruebas' => $pruebas,
            'tiposEtiologias' => $tiposEtiologias,));
    }

    /**
     * @Route("/addPrueba", name="addPrueba")
     */
    public function addPruebaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tiposEtiologias = $em->getRepository('AppBundle:TipoEtiologia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Prueba - Agregar Prueba',
            'descripcion' => 'Formulario para agregar una prueba'
        ));
        return $this->render('Nomencladores/GestionPrueba/addPrueba.html.twig', array('tiposEtiologias' => $tiposEtiologias,));
    }

    /**
     * @Route("/insertPrueba", name="insertPrueba")
     */
    public function insertPrueba()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
            'valor' => $peticion->request->get('valor'),
            'tipoEtiologia' => $peticion->request->get('tipoEtiologia'),
        );

        $resp = $em->getRepository('AppBundle:Prueba')->agregarPrueba($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Prueba',
                'descripcion' => 'Se insertó una prueba con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editPrueba/{idPrueba}", name="editPrueba")
     */
    public function editPruebaAction($idPrueba)
    {
        $em = $this->getDoctrine()->getManager();
        $prueba = $em->getRepository('AppBundle:Prueba')->find($idPrueba);
        $tiposEtiologias = $em->getRepository('AppBundle:TipoEtiologia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Prueba - Editar Prueba',
            'descripcion' => 'Formulario para editar una prueba: '.$prueba->getNombre()
        ));

        return $this->render('Nomencladores/GestionPrueba/editPrueba.html.twig' , array('prueba' => $prueba,'tiposEtiologias' => $tiposEtiologias,));
    }

    /**
     * @Route("/updatePrueba", name="updatePrueba")
     */
    public function updatePruebaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idPrueba' => $peticion->request->get('idPrueba'),
            'nombre' => $peticion->request->get('nombre'),
            'valor' => $peticion->request->get('valor'),
            'tipoEtiologia' => $peticion->request->get('tipoEtiologia'),
        );

        $resp = $em->getRepository('AppBundle:Prueba')->modificarPrueba($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar prueba',
                'descripcion' => 'Se modificó la prueba:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deletePrueba", name="deletePrueba")
     */
    public function deletePruebaAction()
    {
        $peticion = Request::createFromGlobals();
        $idPrueba = $peticion->request->get('idPrueba');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Prueba')->eliminarPrueba($idPrueba);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar prueba',
                'descripcion' => 'Se eliminó la prueba: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarResultadoPrueba/{idPrueba}", name="gestionarResultadoPrueba")
     */
    public function gestionarResultadoPruebaAction($idPrueba)
    {
        $em = $this->getDoctrine()->getManager();
        $resultadosPruebas  = $em->getRepository('AppBundle:ResultadoPrueba')->findBy(array('prueba' => $idPrueba));
        $prueba = $em->getRepository('AppBundle:Prueba')->find($idPrueba);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Resultados de las Pruebas',
            'descripcion' => 'Listado de los Resultados de las Pruebas'
        ));

        return $this->render('Nomencladores/GestionResultadoPrueba/gestionResultadoPrueba.html.twig' , ['resultadosPruebas' => $resultadosPruebas,'prueba' => $prueba]);
    }

    /**
     * @Route("/addResultadoPrueba/{idPrueba}", name="addResultadoPrueba")
     */
    public function addResultadoPruebaAction($idPrueba)
    {
        $em = $this->getDoctrine()->getManager();
        $prueba = $em->getRepository('AppBundle:Prueba')->find($idPrueba);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Resultados de las pruebas - Agregar resultado de la prueba',
            'descripcion' => 'Formulario para agregar un resultado de la prueba'
        ));

        return $this->render('Nomencladores/GestionResultadoPrueba/addResultadoPrueba.html.twig' , array('prueba' => $prueba));
    }

    /**
     * @Route("/insertResultadoPrueba", name="insertResultadoPrueba")
     */
    public function insertResultadoPruebaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'resultado' => $peticion->request->get('resultado'),
            'idPrueba' => $peticion->request->get('prueba'),
        );
        $resp = $em->getRepository('AppBundle:ResultadoPrueba')->agregarResultadoPrueba($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Resultado de la Prueba',
                'descripcion' => 'Se insertó el nuevo resultado: '.$data['resultado']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editResultadoPrueba/{idResultadoPrueba}", name="editResultadoPrueba")
     */
    public function editResultadoPruebaAction($idResultadoPrueba)
    {
        $em = $this->getDoctrine()->getManager();
        $resultadoPrueba = $em->getRepository('AppBundle:ResultadoPrueba')->find($idResultadoPrueba);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Resultado de la prueba - Editar Resultado de la prueba',
            'descripcion' => 'Formulario para editar el resultado: '.$resultadoPrueba->getResultadoPrueba()
        ));

        return $this->render('Nomencladores/GestionResultadoPrueba/editResultadoPrueba.html.twig' , array('resultadoPrueba' => $resultadoPrueba));
    }

    /**
     * @Route("/updateResultadoPrueba", name="updateResultadoPrueba")
     */
    public function updateResultadoPruebaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idResultadoPrueba' => $peticion->request->get('idResultadoPrueba'),
            'resultado' => $peticion->request->get('resultado'),
        );

        $resp = $em->getRepository('AppBundle:ResultadoPrueba')->modificarResultadoPrueba($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Resultado de la Prueba',
                'descripcion' => 'Se modificó el resultado:  '.$data['resultado']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteResultadoPrueba", name="deleteResultadoPrueba")
     */
    public function deleteResultadoPruebaAction()
    {
        $peticion = Request::createFromGlobals();
        $idResultadoPrueba = $peticion->request->get('idResultadoPrueba');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:ResultadoPrueba')->eliminarResultadoPrueba($idResultadoPrueba);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Resultado de la Prueba',
                'descripcion' => 'Se eliminó el resultado: '.$resp->getResultadoPrueba()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarEtiologia", name="gestionarEtiologia")
     */
    public function gestionarEtiologiaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $etiologias  = $em->getRepository('AppBundle:Etiologia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Etiologia',
            'descripcion' => 'Listado de Etiologia de Hepatitis'
        ));

        return $this->render('Nomencladores/GestionEtiologia/gestionEtiologia.html.twig' , array('etiologias' => $etiologias));
    }

    /**
     * @Route("/addEtiologia", name="addEtiologia")
     */
    public function addEtiologiaAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Etiologia de Hepatitis - Agregar Etiologia de Hepatitis',
            'descripcion' => 'Formulario para agregar un Etiologia de Hepatitis'
        ));
        return $this->render('Nomencladores/GestionEtiologia/addEtiologia.html.twig');
    }

    /**
     * @Route("/insertEtiologia", name="insertEtiologia")
     */
    public function insertEtiologiaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:Etiologia')->agregarEtiologia($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Etiologia de Hepatitis',
                'descripcion' => 'Se insertó una nueva etiologia de hepatitis con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editEtiologia/{idEtiologia}", name="editEtiologia")
     */
    public function editEtiologiaAction($idEtiologia)
    {
        $em = $this->getDoctrine()->getManager();
        $etiologia = $em->getRepository('AppBundle:Etiologia')->find($idEtiologia);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Tipos de Hepatitis - Editar Etiologia de Hepatitis',
            'descripcion' => 'Formulario para editar una etiologia de hepatitis: '.$etiologia->getNombre()
        ));

        return $this->render('Nomencladores/GestionEtiologia/editEtiologia.html.twig' , array('etiologia' => $etiologia));
    }

    /**
     * @Route("/updateEtiologia", name="updateEtiologia")
     */
    public function updateEtiologiaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idEtiologia' => $peticion->request->get('idEtiologia'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:Etiologia')->modificarEtiologia($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Etiologia de Hepatitis',
                'descripcion' => 'Se modificó la etiologia de hepatitis:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteEtiologia", name="deleteEtiologia")
     */
    public function deleteEtiologiaAction()
    {
        $peticion = Request::createFromGlobals();
        $idEtiologia = $peticion->request->get('idEtiologia');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Etiologia')->eliminarEtiologia($idEtiologia);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Etiologia de Hepatitis',
                'descripcion' => 'Se eliminó la etiologia de hepatitis: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }


    /**
     * @Route("/gestionarCausaFallecimiento", name="gestionarCausaFallecimiento")
     */
    public function gestionarCausaFallecimientoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $causasFallecimiento  = $em->getRepository('AppBundle:CausaFallecimiento')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Causa de Fallecimiento',
            'descripcion' => 'Listado de las Causas de Fallecimiento'
        ));

        return $this->render('Nomencladores/GestionCausaFallecimiento/gestionCausaFallecimiento.html.twig' , array('causasFallecimiento' => $causasFallecimiento));
    }

    /**
     * @Route("/addCausaFallecimiento", name="addCausaFallecimiento")
     */
    public function addCausaFallecimientoAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Causas de Fallecimiento - Agregar Causa de Fallecimiento',
            'descripcion' => 'Formulario para agregar una Causa de Fallecimiento'
        ));
        return $this->render('Nomencladores/GestionCausaFallecimiento/addCausaFallecimiento.html.twig');
    }

    /**
     * @Route("/insertCausaFallecimiento", name="insertCausaFallecimiento")
     */
    public function insertCausaFallecimientoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:CausaFallecimiento')->agregarCausaFallecimiento($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Causa de Fallecimiento',
                'descripcion' => 'Se insertó una nueva causa de fallecimiento con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editCausaFallecimiento/{idCausaFallecimiento}", name="editCausaFallecimiento")
     */
    public function editCausaFallecimientoAction($idCausaFallecimiento)
    {
        $em = $this->getDoctrine()->getManager();
        $causaFallecimiento = $em->getRepository('AppBundle:CausaFallecimiento')->find($idCausaFallecimiento);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Causas de Fallecimiento - Editar Causa de Fallecimiento',
            'descripcion' => 'Formulario para editar una causa de fallecimiento: '.$causaFallecimiento->getNombre()
        ));

        return $this->render('Nomencladores/GestionCausaFallecimiento/editCausaFallecimiento.html.twig' , array('causaFallecimiento' => $causaFallecimiento));
    }

    /**
     * @Route("/updateCausaFallecimiento", name="updateCausaFallecimiento")
     */
    public function updateCausaFallecimientoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idCausaFallecimiento' => $peticion->request->get('idCausaFallecimiento'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:CausaFallecimiento')->modificarCausaFallecimiento($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Causas de Fallecimiento',
                'descripcion' => 'Se modificó la causa de fallecimiento:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteCausaFallecimiento", name="deleteCausaFallecimiento")
     */
    public function deleteCausaFallecimientoAction()
    {
        $peticion = Request::createFromGlobals();
        $idCausaFallecimiento = $peticion->request->get('idCausaFallecimiento');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:CausaFallecimiento')->eliminarCausaFallecimiento($idCausaFallecimiento);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Causa de Fallecimiento',
                'descripcion' => 'Se eliminó la causa de fallecimiento: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarFormaInfeccion", name="gestionarFormaInfeccion")
     */
    public function gestionarFormaInfeccionAction()
    {
        $em = $this->getDoctrine()->getManager();
        $formasInfeccion  = $em->getRepository('AppBundle:FormaInfeccion')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Formas de Infección',
            'descripcion' => 'Listado de las Formas de Infección '
        ));

        return $this->render('Nomencladores/GestionFormaInfeccion/gestionFormaInfeccion.html.twig' , array('formasInfeccion' => $formasInfeccion));
    }

    /**
     * @Route("/addFormaInfeccion", name="addFormaInfeccion")
     */
    public function addFormaInfeccionAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Formas de Infección - Agregar Forma de Infección',
            'descripcion' => 'Formulario para agregar una Forma de Infección'
        ));
        return $this->render('Nomencladores/GestionFormaInfeccion/addFormaInfeccion.html.twig');
    }

    /**
     * @Route("/insertFormaInfeccion", name="insertFormaInfeccion")
     */
    public function insertFormaInfeccionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:FormaInfeccion')->agregarFormaInfeccion($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Forma de Infección',
                'descripcion' => 'Se insertó una nueva forma de infección con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editFormaInfeccion/{idFormaInfeccion}", name="editFormaInfeccion")
     */
    public function editFormaInfeccionAction($idFormaInfeccion)
    {
        $em = $this->getDoctrine()->getManager();
        $formaInfeccion = $em->getRepository('AppBundle:FormaInfeccion')->find($idFormaInfeccion);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Formas de Infección - Editar Forma de Infección',
            'descripcion' => 'Formulario para editar una forma de infección: '.$formaInfeccion->getNombre()
        ));

        return $this->render('Nomencladores/GestionFormaInfeccion/editFormaInfeccion.html.twig' , array('formaInfeccion' => $formaInfeccion));
    }

    /**
     * @Route("/updateFormaInfeccion", name="updateFormaInfeccion")
     */
    public function updateFormaInfeccionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idFormaInfeccion' => $peticion->request->get('idFormaInfeccion'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:FormaInfeccion')->modificarFormaInfeccion($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Formas de Infección',
                'descripcion' => 'Se modificó la forma de infección:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteFormaInfeccion", name="deleteFormaInfeccion")
     */
    public function deleteFormaInfeccionAction()
    {
        $peticion = Request::createFromGlobals();
        $idFormaInfeccion = $peticion->request->get('idFormaInfeccion');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:FormaInfeccion')->eliminarFormaInfeccion($idFormaInfeccion);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Forma de Infección',
                'descripcion' => 'Se eliminó la forma de infección: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }


}
