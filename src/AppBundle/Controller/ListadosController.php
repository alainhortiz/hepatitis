<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ListadosController extends Controller
{
    // LOS SIGUIENTES LISTADOS SE CARGAN EN UN DATATABLE CON AJAX
    /**
     * @Route("/listadoGeneralPacientes", name="listadoGeneralPacientes")
     */
    public function listadoGeneralPacientesAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('Pacientes/GestionPaciente/listadoPacientesGenerico.html.twig' , array(

                'titulo' => 'Listado General de Pacientes',
                'origen' => 'listadoGeneralPacientes')
        );
    }

    /**
     * @Route("/listadoGeneralPacientesAjax", name="listadoGeneralPacientesAjax")
     */
    public function listadoGeneralPacientesAjax()
    {
        $consulta = "SELECT p.id,p.carnetIdentidad,p.nombre,p.primerApellido,p.segundoApellido,p.fechaDiagnostico,prov.nombre AS provincia,mun.nombre AS municipio,
                    e.nombre AS etiologia,th.nombre AS tipoHepatitis,p.gestante,SIZE(g.gestanteHijos) AS hijos, g.id AS idGestante
                    FROM AppBundle:Paciente p LEFT JOIN p.etiologia e LEFT JOIN p.tipoHepatitis th  LEFT JOIN p.pacienteGestante g
                    LEFT JOIN p.unidadAtencion ua LEFT JOIN ua.municipio mun LEFT JOIN mun.provincia prov";

        $totalRecords = "SELECT COUNT(p.id) FROM AppBundle:Paciente p LEFT JOIN p.etiologia e LEFT JOIN p.tipoHepatitis th   
                        LEFT JOIN p.unidadAtencion ua LEFT JOIN ua.municipio mun LEFT JOIN mun.provincia prov";

        $cadena = str_replace("AND" , "WHERE" , $this->wherePorNivelesAccceso());

        $consulta .= $cadena;
        $totalRecords .= $cadena;

        $output = $this->dataTablePacienteAjax($consulta ,$totalRecords , 'listadoGeneralPacientes');

        return new Response(json_encode($output));

    }

    /**
     * @Route("/listadoGestantes", name="listadoGestantes")
     */
    public function listadoGestantesAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('Pacientes/GestionPaciente/listadoPacientesGenerico.html.twig' , array(

                'titulo' => 'Listado de Pacientes Gestantes',
                'origen' => 'listadoGestantes')
        );
    }

    /**
     * @Route("/listadoGestantesAjax", name="listadoGestantesAjax")
     */
    public function listadoGestantesAjax()
    {
        $consulta = "SELECT p.id,p.carnetIdentidad,p.nombre,p.primerApellido,p.segundoApellido,p.fechaDiagnostico,prov.nombre AS provincia,mun.nombre AS municipio,
                    e.nombre AS etiologia,th.nombre AS tipoHepatitis,p.gestante,SIZE(g.gestanteHijos) AS hijos, g.id AS idGestante
                    FROM AppBundle:Paciente p LEFT JOIN p.etiologia e LEFT JOIN p.tipoHepatitis th  LEFT JOIN p.pacienteGestante g
                    LEFT JOIN p.unidadAtencion ua LEFT JOIN ua.municipio mun LEFT JOIN mun.provincia prov
                    WHERE p.gestante = 1";

        $totalRecords = "SELECT COUNT(p.id) FROM AppBundle:Paciente p LEFT JOIN p.etiologia e LEFT JOIN p.tipoHepatitis th   
                        LEFT JOIN p.unidadAtencion ua LEFT JOIN ua.municipio mun LEFT JOIN mun.provincia prov WHERE p.gestante = 1";


        $consulta .= $this->wherePorNivelesAccceso();
        $totalRecords .= $this->wherePorNivelesAccceso();

        $output = $this->dataTablePacienteAjax($consulta ,$totalRecords ,'listadoGestantes');

        return new Response(json_encode($output));
    }

    //genera la parte del where que se refiere al codigo de: provincia , municipio ,
    //depende del nivel de acceso del usuario
    private function wherePorNivelesAccceso()
    {
        $user = $this->getUser();
        if($user->getNivelAcceso()->getNivel() == 'provincial')
        {
            $provincia = $user->getUnidad()->getMunicipio()->getProvincia()->getCodigo();
            return " AND prov.codigo = ".$provincia."";
        }
        if($user->getNivelAcceso()->getNivel() == 'municipal')
        {
            $municipio = $user->getUnidad()->getMunicipio()->getCodigo();
            return " AND mun.codigo = ".$municipio."";
        }
        return "";
    }

    //genera la cadena de ordenamiento pare devolver los valores en el datatable
    private function orderDataTableAjax($orders)
    {
        $camposOrden = '';
        foreach ($orders as $order)
        {
            if($order['column'] != "")
            {
                switch ($order['column'])
                {
                    case '0':
                        $camposOrden .= ' TRIM(prov.nombre) '.$order['dir'].',';
                        break;
                    case '1':
                        $camposOrden .= ' TRIM(mun.nombre) '.$order['dir'].',';
                        break;
                    case '2':
                        $camposOrden .= ' TRIM(p.nombre) '.$order['dir'].',';
                        break;
                    case '3':
                        $camposOrden .= ' TRIM(p.primerApellido) '.$order['dir'].',';
                        break;
                    case '4':
                        $camposOrden .= ' TRIM(p.segundoApellido) '.$order['dir'].',';
                        break;
                    case '5':
                        $camposOrden .= ' TRIM(p.carnetIdentidad) '.$order['dir'].',';
                        break;
                    case '6':
                        $camposOrden .= ' TRIM(p.fechaDiagnostico) '.$order['dir'].',';
                        break;
                    case '7':
                        $camposOrden .= ' TRIM(e.nombre) '.$order['dir'].',';
                        break;
                    case '8':
                        $camposOrden .= ' TRIM(th.nombre) '.$order['dir'].',';
                        break;

                }
            }
        }
        return $camposOrden;
    }

    private function dataTablePacienteAjax($consulta ,$totalRecords , $origen)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $dql = $consulta;
        $dqlTotalRecords = $totalRecords;
        $dqlCountFiltered = $totalRecords;

        $sqlFilter = "";

        if (!empty($_GET['search']['value'])) {
            $strMainSearch = $_GET['search']['value'];

            $sqlFilter .= " (p.nombre LIKE '%".$strMainSearch."%' OR "
                ."p.primerApellido  LIKE '%".$strMainSearch."%' OR "
                ."p.segundoApellido  LIKE '%".$strMainSearch."%' OR "
                ."p.carnetIdentidad  LIKE '%".$strMainSearch."%' OR "
                ."p.fechaDiagnostico  LIKE '%".$strMainSearch."%' OR "
                ."prov.nombre  LIKE '%".$strMainSearch."%' OR "
                ."mun.nombre  LIKE '%".$strMainSearch."%' OR "
                ."e.nombre  LIKE '%".$strMainSearch."%' OR "
                ."th.nombre LIKE '%".$strMainSearch."%') ";

        }

        // Filter columns with AND restriction
        $strColSearch = "";
        foreach ($_GET['columns'] as $column) {
            if (!empty($column['search']['value'])) {
                if (!empty($strColSearch)) {
                    $strColSearch .= ' AND ';
                }
                /*$strColSearch .= ' t.'.$column['name']." LIKE '%".$column['search']['value']."%'";*/
                if (!empty($column['search']['value']))
                {
                    switch ($column['name'])
                    {
                        case 'provincia': $strColSearch .= " prov.nombre LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'municipio': $strColSearch .= " mun.nombre LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'nombre':  $strColSearch .= " p.nombre LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'primerApellido':  $strColSearch .= " p.primerApellido LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'segundoApellido':  $strColSearch .= " p.segundoApellido LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'carnetIdentidad':  $strColSearch .= " p.carnetIdentidad LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'fechaDiagnostico':  $strColSearch .= " p.fechaDiagnostico LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'etiologia':  $strColSearch .= " e.nombre LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'tipoHepatitis':  $strColSearch .= " th.nombre LIKE '%".$column['search']['value']."%' ";
                            break;
                    }
                }
            }
        }
        if (!empty($sqlFilter) and !empty($strColSearch)) {
            $sqlFilter .= ' AND ('.$strColSearch.')';
        } else {
            $sqlFilter .= $strColSearch;
        }

        if (!empty($sqlFilter)) {
            if(strpos($dql , 'WHERE'))
            {
                $dql .= ' AND'.$sqlFilter;
                $dqlCountFiltered .= ' AND'.$sqlFilter;
            }else{
                $dql .= ' WHERE'.$sqlFilter;
                $dqlCountFiltered .= ' WHERE'.$sqlFilter;
            }
        }

        //order
        $camposOrden = $this->orderDataTableAjax($_GET['order']);
        if(substr($camposOrden , -1) === ',') $camposOrden = substr($camposOrden, 0, -1);
        $dql .=' ORDER BY'.$camposOrden;

        $items = $entityManager
            ->createQuery($dql)
            ->setFirstResult($_GET['start'])
            ->setMaxResults($_GET['length'])
            ->getResult();

        $data = array();
        foreach ($items as $key => $value) {
            $provincia = $value['provincia'] != '' ?  $value['provincia'] :'';
            $municipio = $value['municipio'] != '' ?  $value['municipio'] :'';
            $id = $value['id'];
            $vinculoEditarPaciente = $this->generateUrl('editPaciente', array('idPaciente' => $id , 'origen' => $origen));

            $acciones = "<a href=\"$vinculoEditarPaciente\"
                                   class=\"btn btn-primary btn-xs\"><i class=\"fa fa-pencil\"></i> Editar</a>";

            if($value['gestante']){
                $idGestante = $value['idGestante'];
                $vinculoGestionarHijo = $this->generateUrl('gestionarHijo', array('idGestante' => $idGestante , 'origen' => $origen));

                $acciones .= "  <a href=\"$vinculoGestionarHijo\"
                                       class=\"btn btn-info  btn-xs\">
                                        <span class=\"badge\">".$value['hijos']."</span>
                                        <i class=\"fa fa-check\"></i>
                                        Hijos
                                    </a>";
            }

            $acciones .= "  <a href=\"#\" name=\"$id\"   id=\"$id\" class=\"btn btn-danger btn-xs delete\"><i class=\"fa fa-trash-o \"></i> Borrar</a>";


            $data[] = array(
                $provincia,
                $municipio,
                $value['nombre'],
                $value['primerApellido'],
                $value['segundoApellido'],
                $value['carnetIdentidad'],
                $value['fechaDiagnostico']->format('Y-m-d'),
                $value['etiologia'],
                $value['tipoHepatitis'],
                $acciones,
            );
        }

        $recordsTotal = $entityManager
            ->createQuery($dqlTotalRecords)
            ->getSingleScalarResult();

        $recordsFiltered = $entityManager
            ->createQuery($dqlCountFiltered)
            ->getSingleScalarResult();

        $output = array(
            'draw' => 0,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'dql' => $dql,
            'dqlCountFiltered' => $dqlCountFiltered,
        );

        return $output;
    }

}