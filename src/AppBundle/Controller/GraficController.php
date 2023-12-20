<?php

namespace AppBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GraficController extends Controller
{

    //Dashboards de hemodialisis

    /**
     * @Route("/graficoHemodialisis", name="graficoHemodialisis")
     */
    public function graficoHemodialisisAction()
    {
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'fechaInicial' => '',
            'fechaFinal' => '',
            'etiologia' => '0',
            'provincia' => '0',
            'municipio' => '0',
        );
        $user = $this->getUser();

        if ($user->getNivelAcceso()->getNivel() == 'provincial')
            $data['provincia'] = $user->getUnidad()->getMunicipio()->getProvincia()->getId();
        if ($user->getNivelAcceso()->getNivel() == 'municipal')
            $data['municipio'] = $user->getUnidad()->getMunicipio()->getId();

        $etiologias = $em->getRepository('AppBundle:Paciente')->graficoEtiologia($data);
        $hemodialisis = $em->getRepository('AppBundle:Paciente')->graficoHemodialisis($data);
        $tiposProvHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHepatitisB($data);
        $tiposProvHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHepatitisC($data);
        $tiposProvHemodialisisB = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHemodialisisB($data);
        $tiposProvHemodialisisC = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHemodialisisC($data);
        $sexos = $em->getRepository('AppBundle:Paciente')->graficoSexo($data);
        $sexosProvHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHepatitisB($data);
        $sexosProvHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHepatitisC($data);
        $sexosProvHemodialisisB = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHemodialisisB($data);
        $sexosProvHemodialisisC = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHemodialisisC($data);
        $coinfecciones = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccion($data);
        $coinfeccionesProvHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHepatitisB($data);
        $coinfeccionesProvHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHepatitisC($data);
        $coinfeccionesProvHemodialisisB = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHemodialisisB($data);
        $coinfeccionesProvHemodialisisC = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHemodialisisC($data);

        if (count($etiologias) == 0) {
            return $this->render('Graficos/DashboardHemodialisis/graficoHemodialisis.html.twig', array(
                'etiologias' => $etiologias,
                'hemodialisis' => $hemodialisis,
                'tiposProvHepatitisB' => $tiposProvHepatitisB,
                'tiposProvHepatitisC' => $tiposProvHepatitisC,
                'tiposProvHemodialisisB' => $tiposProvHemodialisisB,
                'tiposProvHemodialisisC' => $tiposProvHemodialisisC,
                'sexos' => $sexos,
                'sexosProvHepatitisB' => $sexosProvHepatitisB,
                'sexosProvHepatitisC' => $sexosProvHepatitisC,
                'sexosProvHemodialisisB' => $sexosProvHemodialisisB,
                'sexosProvHemodialisisC' => $sexosProvHemodialisisC,
                'hayDatosRango' => false,
                'coinfecciones' => $coinfecciones,
                'coinfeccionesProvHepatitisB' => $coinfeccionesProvHepatitisB,
                'coinfeccionesProvHepatitisC' => $coinfeccionesProvHepatitisC,
                'coinfeccionesProvHemodialisisB' => $coinfeccionesProvHemodialisisB,
                'coinfeccionesProvHemodialisisC' => $coinfeccionesProvHemodialisisC,
            ));
        } else {
            return $this->render('Graficos/DashboardHemodialisis/graficoHemodialisis.html.twig', array(
                'etiologias' => $etiologias,
                'hemodialisis' => $hemodialisis,
                'tiposProvHepatitisB' => $tiposProvHepatitisB,
                'tiposProvHepatitisC' => $tiposProvHepatitisC,
                'tiposProvHemodialisisB' => $tiposProvHemodialisisB,
                'tiposProvHemodialisisC' => $tiposProvHemodialisisC,
                'sexos' => $sexos,
                'sexosProvHepatitisB' => $sexosProvHepatitisB,
                'sexosProvHepatitisC' => $sexosProvHepatitisC,
                'sexosProvHemodialisisB' => $sexosProvHemodialisisB,
                'sexosProvHemodialisisC' => $sexosProvHemodialisisC,
                'hayDatosRango' => true,
                'coinfecciones' => $coinfecciones,
                'coinfeccionesProvHepatitisB' => $coinfeccionesProvHepatitisB,
                'coinfeccionesProvHepatitisC' => $coinfeccionesProvHepatitisC,
                'coinfeccionesProvHemodialisisB' => $coinfeccionesProvHemodialisisB,
                'coinfeccionesProvHemodialisisC' => $coinfeccionesProvHemodialisisC,
            ));
        }
    }

    /**
     * @Route("/resultHemodialisis", name="resultHemodialisis")
     */
    public function resultHemodialisisAction()
    {
        $fechaInicial = $_POST['fechaInicial'];
        $fechaFinal = $_POST['fechaFinal'];
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'etiologia' => '0',
            'provincia' => '0',
            'municipio' => '0',
        );
        $user = $this->getUser();

        if ($user->getNivelAcceso()->getNivel() == 'provincial')
            $data['provincia'] = $user->getUnidad()->getMunicipio()->getProvincia()->getId();
        if ($user->getNivelAcceso()->getNivel() == 'municipal')
            $data['municipio'] = $user->getUnidad()->getMunicipio()->getId();

        $etiologias = $em->getRepository('AppBundle:Paciente')->graficoEtiologia($data);
        $hemodialisis = $em->getRepository('AppBundle:Paciente')->graficoHemodialisis($data);
        $tiposProvHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHepatitisB($data);
        $tiposProvHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHepatitisC($data);
        $tiposProvHemodialisisB = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHemodialisisB($data);
        $tiposProvHemodialisisC = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHemodialisisC($data);
        $sexos = $em->getRepository('AppBundle:Paciente')->graficoSexo($data);
        $sexosProvHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHepatitisB($data);
        $sexosProvHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHepatitisC($data);
        $sexosProvHemodialisisB = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHemodialisisB($data);
        $sexosProvHemodialisisC = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHemodialisisC($data);
        $coinfecciones = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccion($data);
        $coinfeccionesProvHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHepatitisB($data);
        $coinfeccionesProvHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHepatitisC($data);
        $coinfeccionesProvHemodialisisB = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHemodialisisB($data);
        $coinfeccionesProvHemodialisisC = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHemodialisisC($data);


        if (count($etiologias) == 0) {
            $hayDatosRango = false;
            $data['fechaInicial'] = '';
            $data['fechaFinal'] = '';
            $etiologias = $em->getRepository('AppBundle:Paciente')->graficoEtiologia($data);
            $hemodialisis = $em->getRepository('AppBundle:Paciente')->graficoHemodialisis($data);
            $tiposProvHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHepatitisB($data);
            $tiposProvHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHepatitisC($data);
            $tiposProvHemodialisisB = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHemodialisisB($data);
            $tiposProvHemodialisisC = $em->getRepository('AppBundle:Paciente')->graficoProvTipoHemodialisisC($data);
            $sexos = $em->getRepository('AppBundle:Paciente')->graficoSexo($data);
            $sexosProvHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHepatitisB($data);
            $sexosProvHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHepatitisC($data);
            $sexosProvHemodialisisB = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHemodialisisB($data);
            $sexosProvHemodialisisC = $em->getRepository('AppBundle:Paciente')->graficoSexoProvHemodialisisC($data);
            $coinfecciones = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccion($data);
            $coinfeccionesProvHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHepatitisB($data);
            $coinfeccionesProvHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHepatitisC($data);
            $coinfeccionesProvHemodialisisB = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHemodialisisB($data);
            $coinfeccionesProvHemodialisisC = $em->getRepository('AppBundle:Paciente')->graficoCoinfeccionProvHemodialisisC($data);


        } else $hayDatosRango = true;

        return $this->render('Graficos/DashboardHemodialisis/graficoHemodialisis.html.twig', array(
            'etiologias' => $etiologias,
            'hemodialisis' => $hemodialisis,
            'tiposProvHepatitisB' => $tiposProvHepatitisB,
            'tiposProvHepatitisC' => $tiposProvHepatitisC,
            'tiposProvHemodialisisB' => $tiposProvHemodialisisB,
            'tiposProvHemodialisisC' => $tiposProvHemodialisisC,
            'sexos' => $sexos,
            'sexosProvHepatitisB' => $sexosProvHepatitisB,
            'sexosProvHepatitisC' => $sexosProvHepatitisC,
            'sexosProvHemodialisisB' => $sexosProvHemodialisisB,
            'sexosProvHemodialisisC' => $sexosProvHemodialisisC,
            'hayDatosRango' => $hayDatosRango,
            'coinfecciones' => $coinfecciones,
            'coinfeccionesProvHepatitisB' => $coinfeccionesProvHepatitisB,
            'coinfeccionesProvHepatitisC' => $coinfeccionesProvHepatitisC,
            'coinfeccionesProvHemodialisisB' => $coinfeccionesProvHemodialisisB,
            'coinfeccionesProvHemodialisisC' => $coinfeccionesProvHemodialisisC,));
    }

    //Dashboards de provincias

    /**
     * @Route("/graficoProvincias", name="graficoProvincias")
     */
    public function graficoProvinciasAction()
    {
        $em = $this->getDoctrine()->getManager();

        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $graficosPacientesProvincias = $em->getRepository('AppBundle:Paciente')->graficoPacientesProvincias();
        $totalHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoTotalHepatitisB();
        $totalHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoTotalHepatitisC();
        //Edades
        $graficosEdadesMenor5 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdadesMenores5();
        $graficosEdades5y14 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades5y14();
        $graficosEdades15y19 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades15y19();
        $graficosEdades20y24 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades20y24();
        $graficosEdades25y59 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades25y59();
        $graficosEdades60y65 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades60y65();
        $graficosEdadesMas65 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdadesMas65();

        if (!empty($totalHepatitisB)) {
            $totalHepatitisB = $totalHepatitisB[0]['cantidad'];
        } else {
            $totalHepatitisB = 0;
        }

        if (!empty($totalHepatitisC)) {
            $totalHepatitisC = $totalHepatitisC[0]['cantidad'];
        } else {
            $totalHepatitisB = 0;
        }

        if (!empty($graficosEdadesMenor5)) {
            $graficosEdadesMenor5 = $graficosEdadesMenor5[0]['cantidad'];
        } else {
            $graficosEdadesMenor5 = 0;
        }

        if (!empty($graficosEdades5y14)) {
            $graficosEdades5y14 = $graficosEdades5y14[0]['cantidad'];
        } else {
            $graficosEdades5y14 = 0;
        }

        if (!empty($graficosEdades15y19)) {
            $graficosEdades15y19 = $graficosEdades15y19[0]['cantidad'];
        } else {
            $graficosEdades15y19 = 0;
        }

        if (!empty($graficosEdades20y24)) {
            $graficosEdades20y24 = $graficosEdades20y24[0]['cantidad'];
        } else {
            $graficosEdades20y24 = 0;
        }

        if (!empty($graficosEdades25y59)) {
            $graficosEdades25y59 = $graficosEdades25y59[0]['cantidad'];
        } else {
            $graficosEdades25y59 = 0;
        }

        if (!empty($graficosEdades60y65)) {
            $graficosEdades60y65 = $graficosEdades60y65[0]['cantidad'];
        } else {
            $graficosEdades60y65 = 0;
        }

        if (!empty($graficosEdadesMas65)) {
            $graficosEdadesMas65 = $graficosEdadesMas65[0]['cantidad'];
        } else {
            $graficosEdadesMas65 = 0;
        }

        return $this->render('Graficos/DashboardProvincias/graficoProvincias.html.twig', array(
            'provincias' => $provincias,
            'graficosPacientesProvincias' => $graficosPacientesProvincias,
            'totalHepatitisB' => $totalHepatitisB,
            'totalHepatitisC' => $totalHepatitisC,
            'graficosEdadesMenor5' => $graficosEdadesMenor5,
            'graficosEdades5y14' => $graficosEdades5y14,
            'graficosEdades15y19' => $graficosEdades15y19,
            'graficosEdades20y24' => $graficosEdades20y24,
            'graficosEdades25y59' => $graficosEdades25y59,
            'graficosEdades60y65' => $graficosEdades60y65,
            'graficosEdadesMas65' => $graficosEdadesMas65,

        ));

    }

    /**
     * @Route("/graficoProvinciasHepatitis", name="graficoProvinciasHepatitis")
     */
    public function graficoProvinciasHepatitisAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $idEtiologia = $peticion->request->get('idEtiologia');

        $graficosPacientesProvincias = $em->getRepository('AppBundle:Paciente')->graficoPacientesProvinciasEtiologia($idEtiologia);
        //Edades
        $graficosEdadesMenor5 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdadesMenores5Etiologia($idEtiologia);
        $graficosEdades5y14 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades5y14Etiologia($idEtiologia);
        $graficosEdades15y19 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades15y19Etiologia($idEtiologia);
        $graficosEdades20y24 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades20y24Etiologia($idEtiologia);
        $graficosEdades25y59 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades25y59Etiologia($idEtiologia);
        $graficosEdades60y65 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades60y65Etiologia($idEtiologia);
        $graficosEdadesMas65 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdadesMas65Etiologia($idEtiologia);

        if (!empty($graficosEdadesMenor5)) {
            $graficosEdadesMenor5 = $graficosEdadesMenor5[0]['cantidad'];
        } else {
            $graficosEdadesMenor5 = 0;
        }

        if (!empty($graficosEdades5y14)) {
            $graficosEdades5y14 = $graficosEdades5y14[0]['cantidad'];
        } else {
            $graficosEdades5y14 = 0;
        }

        if (!empty($graficosEdades15y19)) {
            $graficosEdades15y19 = $graficosEdades15y19[0]['cantidad'];
        } else {
            $graficosEdades15y19 = 0;
        }

        if (!empty($graficosEdades20y24)) {
            $graficosEdades20y24 = $graficosEdades20y24[0]['cantidad'];
        } else {
            $graficosEdades20y24 = 0;
        }

        if (!empty($graficosEdades25y59)) {
            $graficosEdades25y59 = $graficosEdades25y59[0]['cantidad'];
        } else {
            $graficosEdades25y59 = 0;
        }

        if (!empty($graficosEdades60y65)) {
            $graficosEdades60y65 = $graficosEdades60y65[0]['cantidad'];
        } else {
            $graficosEdades60y65 = 0;
        }

        if (!empty($graficosEdadesMas65)) {
            $graficosEdadesMas65 = $graficosEdadesMas65[0]['cantidad'];
        } else {
            $graficosEdadesMas65 = 0;
        }

        $graficos = array(
            'pacientesProvinciasEtiologia' => $graficosPacientesProvincias,
            'rangoEdadEtiologiaMenor5' => $graficosEdadesMenor5,
            'rangoEdadEtiologia5y14' => $graficosEdades5y14,
            'rangoEdadEtiologia15y19' => $graficosEdades15y19,
            'rangoEdadEtiologia20y24' => $graficosEdades20y24,
            'rangoEdadEtiologia25y59' => $graficosEdades25y59,
            'rangoEdadEtiologia60y65' => $graficosEdades60y65,
            'rangoEdadEtiologiamayor65' => $graficosEdadesMas65
        );

        if (is_string($graficosPacientesProvincias)) {
            return new Response($graficosPacientesProvincias);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

    /**
     * @Route("/graficoProvinciaMunicipio", name="graficoProvinciaMunicipio")
     */
    public function graficoProvinciaMunicipioAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $idProvincia = $peticion->request->get('idProvincia');

        $graficosPacientesProvincias = $em->getRepository('AppBundle:Paciente')->graficoPacientesProvinciasMunicipios($idProvincia);
        $totalHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoTotalHepatitisBProvincia($idProvincia);
        $totalHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoTotalHepatitisCProvincia($idProvincia);
        //Edades
        $graficosEdadesMenor5 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdadesMenores5Provincia($idProvincia);
        $graficosEdades5y14 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades5y14Provincia($idProvincia);
        $graficosEdades15y19 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades15y19Provincia($idProvincia);
        $graficosEdades20y24 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades20y24Provincia($idProvincia);
        $graficosEdades25y59 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades25y59Provincia($idProvincia);
        $graficosEdades60y65 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdades60y65Provincia($idProvincia);
        $graficosEdadesMas65 = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdadesMas65Provincia($idProvincia);

        if (!empty($totalHepatitisB)) {
            $totalHepatitisB = $totalHepatitisB[0]['cantidad'];
        } else {
            $totalHepatitisB = 0;
        }

        if (!empty($totalHepatitisC)) {
            $totalHepatitisC = $totalHepatitisC[0]['cantidad'];
        } else {
            $totalHepatitisB = 0;
        }

        if (!empty($graficosEdadesMenor5)) {
            $graficosEdadesMenor5 = $graficosEdadesMenor5[0]['cantidad'];
        } else {
            $graficosEdadesMenor5 = 0;
        }

        if (!empty($graficosEdades5y14)) {
            $graficosEdades5y14 = $graficosEdades5y14[0]['cantidad'];
        } else {
            $graficosEdades5y14 = 0;
        }

        if (!empty($graficosEdades15y19)) {
            $graficosEdades15y19 = $graficosEdades15y19[0]['cantidad'];
        } else {
            $graficosEdades15y19 = 0;
        }

        if (!empty($graficosEdades20y24)) {
            $graficosEdades20y24 = $graficosEdades20y24[0]['cantidad'];
        } else {
            $graficosEdades20y24 = 0;
        }

        if (!empty($graficosEdades25y59)) {
            $graficosEdades25y59 = $graficosEdades25y59[0]['cantidad'];
        } else {
            $graficosEdades25y59 = 0;
        }

        if (!empty($graficosEdades60y65)) {
            $graficosEdades60y65 = $graficosEdades60y65[0]['cantidad'];
        } else {
            $graficosEdades60y65 = 0;
        }

        if (!empty($graficosEdadesMas65)) {
            $graficosEdadesMas65 = $graficosEdadesMas65[0]['cantidad'];
        } else {
            $graficosEdadesMas65 = 0;
        }

        $graficos = array(
            'totalHepatitisB' => $totalHepatitisB,
            'totalHepatitisC' => $totalHepatitisC,
            'pacientesProvinciasEtiologia' => $graficosPacientesProvincias,
            'rangoEdadEtiologiaMenor5' => $graficosEdadesMenor5,
            'rangoEdadEtiologia5y14' => $graficosEdades5y14,
            'rangoEdadEtiologia15y19' => $graficosEdades15y19,
            'rangoEdadEtiologia20y24' => $graficosEdades20y24,
            'rangoEdadEtiologia25y59' => $graficosEdades25y59,
            'rangoEdadEtiologia60y65' => $graficosEdades60y65,
            'rangoEdadEtiologiamayor65' => $graficosEdadesMas65
        );

        if (is_string($graficosPacientesProvincias)) {
            return new Response($graficosPacientesProvincias);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

    /**
     * @Route("/graficoRangoEdad", name="graficoRangoEdad")
     */
    public function graficoRangoEdadAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $edad = $peticion->request->get('edad');

        switch ($edad) {
            case '< 5':
                $edadInicio = 0;
                $edadFinal = 5;
                break;
            case '5 y 14':
                $edadInicio = 5;
                $edadFinal = 14;
                break;
            case '15 y 19':
                $edadInicio = 15;
                $edadFinal = 19;
                break;
            case '20 y 24':
                $edadInicio = 20;
                $edadFinal = 24;
                break;
            case '25 y 59':
                $edadInicio = 25;
                $edadFinal = 59;
                break;
            case '60 y 65':
                $edadInicio = 60;
                $edadFinal = 65;
                break;
            case '> 65':
                $edadInicio = 1;
                $edadFinal = 65;
                break;
        }

        $graficosPacientesProvincias = $em->getRepository('AppBundle:Paciente')->graficoPacientesEdadSeleccionada($edadInicio, $edadFinal);
        $totalHepatitisB = $em->getRepository('AppBundle:Paciente')->graficoTotalHepatitisBEdad($edadInicio, $edadFinal);
        $totalHepatitisC = $em->getRepository('AppBundle:Paciente')->graficoTotalHepatitisCEdad($edadInicio, $edadFinal);

        if (!empty($totalHepatitisB)) {
            $totalHepatitisB = $totalHepatitisB[0]['cantidad'];
        } else {
            $totalHepatitisB = 0;
        }

        if (!empty($totalHepatitisC)) {
            $totalHepatitisC = $totalHepatitisC[0]['cantidad'];
        } else {
            $totalHepatitisB = 0;
        }

        $graficos = array(
            'totalHepatitisB' => $totalHepatitisB,
            'totalHepatitisC' => $totalHepatitisC,
            'pacientesProvinciasEtiologia' => $graficosPacientesProvincias
        );

        if (is_string($graficosPacientesProvincias)) {
            return new Response($graficosPacientesProvincias);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

    //Dashboards de tasas

    /**
     * @Route("/graficoTasas", name="graficoTasas")
     */
    public function graficoTasasAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tasasB = [];
        $tasasC = [];
        $prevalenciasB = [];
        $prevalenciasC = [];

        for ($i = 1; $i <= 12; $i++) {
            $tasasB [$i] = array(
                'mes' => $i,
                'total' => 0);
            $tasasC [$i] = array(
                'mes' => $i,
                'total' => 0);
            $prevalenciasB [$i] = array(
                'mes' => $i,
                'total' => 0);
            $prevalenciasC [$i] = array(
                'mes' => $i,
                'total' => 0);
        }


        $inicial = new \DateTime('Now');
        $year = $inicial->format('Y');

        //Total Poblacion
        $totalPoblacionYearActual = $em->getRepository('AppBundle:TotalPoblacion')->graficoTotalPoblacionYearActual($year);

        $tasaIncidenciasB = $em->getRepository('AppBundle:Paciente')->graficoPacientesIncidenciaB($year);
        $tasaIncidenciasC = $em->getRepository('AppBundle:Paciente')->graficoPacientesIncidenciaC($year);
        $prevalenciaIncidenciasB = $em->getRepository('AppBundle:Paciente')->graficoPacientesPrevalenciaB($year);
        $prevalenciaIncidenciasC = $em->getRepository('AppBundle:Paciente')->graficoPacientesPrevalenciaC($year);


        if (!empty($totalPoblacionYearActual)) {
            $totalPoblacionYearActual = $totalPoblacionYearActual[0]['total'];
            foreach ($tasaIncidenciasB as $t) {
                $pos = (int)$t['mes'];
                $tasasB[$pos]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }
            foreach ($tasaIncidenciasC as $t) {
                $pos = (int)$t['mes'];
                $tasasC[$pos]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }
            foreach ($prevalenciaIncidenciasB as $t) {
                $pos = (int)$t['mes'];
                $prevalenciasB[$pos]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }
            foreach ($prevalenciaIncidenciasC as $t) {
                $pos = (int)$t['mes'];
                $prevalenciasC[$pos]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }

        } else {
            $totalPoblacionYearActual = 0;
        }

        /*var_dump($totalPoblacionYearActual);
        exit();*/

        return $this->render('Graficos/DashboardTasas/graficoTasas.html.twig', array(
            'year' => $year,
            'tasaIncidenciasB' => $tasasB,
            'tasaIncidenciasC' => $tasasC,
            'tasaPrevalenciasB' => $prevalenciasB,
            'tasaPrevalenciasC' => $prevalenciasC
        ));

    }

    /**
     * @Route("/graficoTasasSexo", name="graficoTasasSexo")
     */
    public function graficoTasasSexoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $year = $peticion->request->get('year');
        $sexo = $peticion->request->get('sexo');

        $tasasB = [];
        $tasasC = [];
        $prevalenciasB = [];
        $prevalenciasC = [];

        for ($i = 1; $i <= 12; $i++) {
            $tasasB [] = array(
                'mes' => $i,
                'total' => 0);
            $tasasC [] = array(
                'mes' => $i,
                'total' => 0);
            $prevalenciasB [] = array(
                'mes' => $i,
                'total' => 0);
            $prevalenciasC [] = array(
                'mes' => $i,
                'total' => 0);
        }

        //Total Poblacion
        $totalPoblacionYearActual = $em->getRepository('AppBundle:TotalPoblacion')->graficoTotalPoblacionYearSexo($year, $sexo);

        $totalPacientes = $em->getRepository('AppBundle:Paciente')->graficoTotalPacientesIncidenciaSexo($year, $sexo);
        $tasaIncidenciasB = $em->getRepository('AppBundle:Paciente')->graficoPacientesIncidenciaBSexo($year, $sexo);
        $tasaIncidenciasC = $em->getRepository('AppBundle:Paciente')->graficoPacientesIncidenciaCSexo($year, $sexo);
        $prevalenciaIncidenciasB = $em->getRepository('AppBundle:Paciente')->graficoPacientesPrevalenciaBSexo($year, $sexo);
        $prevalenciaIncidenciasC = $em->getRepository('AppBundle:Paciente')->graficoPacientesPrevalenciaCSexo($year, $sexo);


        if (!empty($totalPoblacionYearActual)) {
            $totalPoblacionYearActual = $totalPoblacionYearActual[0]['total'];
            foreach ($tasaIncidenciasB as $t) {
                $pos = (int)$t['mes'];
                $tasasB[$pos - 1]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }
            foreach ($tasaIncidenciasC as $t) {
                $pos = (int)$t['mes'];
                $tasasC[$pos - 1]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }
            foreach ($prevalenciaIncidenciasB as $t) {
                $pos = (int)$t['mes'];
                $prevalenciasB[$pos - 1]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }
            foreach ($prevalenciaIncidenciasC as $t) {
                $pos = (int)$t['mes'];
                $prevalenciasC[$pos - 1]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }

        } else {
            $totalPoblacionYearActual = 0;
        }

        $graficos = array(
            'year' => $year,
            'totalPacientes' => $totalPacientes,
            'tasaIncidenciasB' => $tasasB,
            'tasaIncidenciasC' => $tasasC,
            'tasaPrevalenciasB' => $prevalenciasB,
            'tasaPrevalenciasC' => $prevalenciasC
        );

        if (is_string($totalPacientes)) {
            return new Response($totalPacientes);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

    /**
     * @Route("/graficoTasasYear", name="graficoTasasYear")
     */
    public function graficoTasasYearAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $year = $peticion->request->get('year');

        $tasasB = [];
        $tasasC = [];
        $prevalenciasB = [];
        $prevalenciasC = [];

        for ($i = 1; $i <= 12; $i++) {
            $tasasB [] = array(
                'mes' => $i,
                'total' => 0);
            $tasasC [] = array(
                'mes' => $i,
                'total' => 0);
            $prevalenciasB [] = array(
                'mes' => $i,
                'total' => 0);
            $prevalenciasC [] = array(
                'mes' => $i,
                'total' => 0);
        }

        //Total Poblacion
        $totalPoblacionYearActual = $em->getRepository('AppBundle:TotalPoblacion')->graficoTotalPoblacionYearActual($year);

        $totalPacientes = $em->getRepository('AppBundle:Paciente')->graficoTotalPacientesIncidencia($year);
        $tasaIncidenciasB = $em->getRepository('AppBundle:Paciente')->graficoPacientesIncidenciaB($year);
        $tasaIncidenciasC = $em->getRepository('AppBundle:Paciente')->graficoPacientesIncidenciaC($year);
        $prevalenciaIncidenciasB = $em->getRepository('AppBundle:Paciente')->graficoPacientesPrevalenciaB($year);
        $prevalenciaIncidenciasC = $em->getRepository('AppBundle:Paciente')->graficoPacientesPrevalenciaC($year);


        if (!empty($totalPoblacionYearActual)) {
            $totalPoblacionYearActual = $totalPoblacionYearActual[0]['total'];
            foreach ($tasaIncidenciasB as $t) {
                $pos = (int)$t['mes'];
                $tasasB[$pos - 1]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }
            foreach ($tasaIncidenciasC as $t) {
                $pos = (int)$t['mes'];
                $tasasC[$pos - 1]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }
            foreach ($prevalenciaIncidenciasB as $t) {
                $pos = (int)$t['mes'];
                $prevalenciasB[$pos - 1]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }
            foreach ($prevalenciaIncidenciasC as $t) {
                $pos = (int)$t['mes'];
                $prevalenciasC[$pos - 1]['total'] = ($t['cantidad'] / $totalPoblacionYearActual) * 100000;
            }

        } else {
            $totalPoblacionYearActual = 0;
        }

        $graficos = array(
            'year' => $year,
            'totalPacientes' => $totalPacientes,
            'tasaIncidenciasB' => $tasasB,
            'tasaIncidenciasC' => $tasasC,
            'tasaPrevalenciasB' => $prevalenciasB,
            'tasaPrevalenciasC' => $prevalenciasC
        );

        if (is_string($totalPacientes)) {
            return new Response($totalPacientes);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

    //Dashboards de Mortalidad

    /**
     * @Route("/graficoMortalidad", name="graficoMortalidad")
     */
    public function graficoMortalidadAction()
    {
        $em = $this->getDoctrine()->getManager();

        $inicial = new \DateTime('Now');
        $year = $inicial->format('Y');
        $mortalidadB = '';
        $mortalidadC = '';

        //Total Poblacion
        $totalPoblacionYearActual = $em->getRepository('AppBundle:TotalPoblacion')->graficoTotalPoblacionYearActual($year);

        if (!empty($totalPoblacionYearActual)) {
            $totalPoblacionYearActual = $totalPoblacionYearActual[0]['total'];
            $mortalidadB = $em->getRepository('AppBundle:Paciente')->graficoMortalidadBYear($year, $totalPoblacionYearActual);
            $mortalidadC = $em->getRepository('AppBundle:Paciente')->graficoMortalidadCYear($year, $totalPoblacionYearActual);
        }

        return $this->render('Graficos/DashboardMortalidad/graficoMortalidad.html.twig', array(
            'year' => $year,
            'mortalidadB' => $mortalidadB,
            'mortalidadC' => $mortalidadC
        ));

    }

    /**
     * @Route("/graficoMortalidadSexo", name="graficoMortalidadSexo")
     */
    public function graficoMortalidadSexoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $year = $peticion->request->get('year');
        $sexo = $peticion->request->get('sexo');

        //Total Poblacion
        $totalPoblacionYearActual = $em->getRepository('AppBundle:TotalPoblacion')->graficoTotalPoblacionYearSexo($year, $sexo);

        if (!empty($totalPoblacionYearActual)) {
            $totalPoblacionYearActual = $totalPoblacionYearActual[0]['total'];
            $mortalidadB = $em->getRepository('AppBundle:Paciente')->graficoMortalidadBYearSexo($year, $totalPoblacionYearActual, $sexo);
            $mortalidadC = $em->getRepository('AppBundle:Paciente')->graficoMortalidadCYearSexo($year, $totalPoblacionYearActual, $sexo);
        } else {
            $totalPoblacionYearActual = 0;
        }

        $graficos = array(
            'year' => $year,
            'mortalidadB' => $mortalidadB,
            'mortalidadC' => $mortalidadC
        );

        if (is_string($totalPoblacionYearActual)) {
            return new Response($totalPoblacionYearActual);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

    /**
     * @Route("/graficoMortalidadYear", name="graficoMortalidadYear")
     */
    public function graficoMortalidadYearAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $year = $peticion->request->get('year');

        //Total Poblacion
        $totalPoblacionYearActual = $em->getRepository('AppBundle:TotalPoblacion')->graficoTotalPoblacionYearActual($year);

        if (!empty($totalPoblacionYearActual)) {
            $totalPoblacionYearActual = $totalPoblacionYearActual[0]['total'];
            $mortalidadB = $em->getRepository('AppBundle:Paciente')->graficoMortalidadBYear($year, $totalPoblacionYearActual);
            $mortalidadC = $em->getRepository('AppBundle:Paciente')->graficoMortalidadCYear($year, $totalPoblacionYearActual);
        } else {
            $totalPoblacionYearActual = 0;
            $mortalidadB = '';
            $mortalidadC = '';
        }

        $graficos = array(
            'year' => $year,
            'mortalidadB' => $mortalidadB,
            'mortalidadC' => $mortalidadC
        );

        if (is_string($totalPoblacionYearActual)) {
            return new Response($totalPoblacionYearActual);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

}
