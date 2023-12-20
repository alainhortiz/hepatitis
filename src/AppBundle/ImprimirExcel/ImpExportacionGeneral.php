<?php


namespace AppBundle\ImprimirExcel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ImpExportacionGeneral
{
    public function DatosExcel($pacientes , $hijos)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->
        getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("YADRIAN y ALAIN")
            ->setTitle('Exportacion general')
            ->setSubject('pacientes')
            ->setDescription("Generado por Registro Nacional de Hepatitis")
            ->setKeywords("Hepatitis")
            ->setCategory("Exportacion");

        $objPHPExcel->createSheet();

         //TITULO HOJA 1
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:K2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'LISTADO GENERAL DE PACIENTES');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A2:O2')->applyFromArray($this->estiloTituloReporte());
        //TITULO HOJA 2
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A2:O2');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A2', 'LISTADO DE HIJOS');
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A2:O2')->applyFromArray($this->estiloTituloReporte());

        //ENCABEZADOS
        $this->TitlesCellBloq($objPHPExcel);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A4:AE4')->applyFromArray($this->estiloEncabezadosColumnas());
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A4:Q4')->applyFromArray($this->estiloEncabezadosColumnas());

        //DATOS
        $this->AllValues($objPHPExcel,$pacientes , $hijos);
        $lastFila = count($pacientes) + 4;
        $lastFila2 = count($hijos) + 4;
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A5:AE'.$lastFila)->applyFromArray($this->estiloDatos());
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A5:Q'.$lastFila2)->applyFromArray($this->estiloDatos());

        $objPHPExcel->setActiveSheetIndex(0)->freezePane('F5');
        $objPHPExcel->setActiveSheetIndex(1)->freezePane('E5');

        for($j = 'A'; $j <= 'Z'; $j++){

            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($j)->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension($j)->setAutoSize(true);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setTitle('PACIENTES');
        $objPHPExcel->setActiveSheetIndex(1)->setTitle('HIJOS');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="pacientes.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;
    }

    public function TitlesCellBloq($objPHPExcel)
    {
        // Se agregan los encabezados de la hoja 1

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4','No');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4','CARNET IDENTIDAD');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4','NOMBRE');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4','PRIMER APELLIDO');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4','SEGUNDO APELLIDO');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4','EDAD');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4','SEXO');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4','FECHA DIAGNOSTICO');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4','PROVINCIA ATENCION');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4','MUNICIPIO ATENCION');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4','UNIDAD ATENCION');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4','DIRECCION DE RESIDENCIA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4','PROVINCIA CARNET');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4','MUNICIPIO CARNET');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4','DIRECCION DE CARNET');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P4','OCUPACION');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4','NIVEL ESCOLARIDAD');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R4','ESTADO CIVIL');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S4','COLOR PIEL');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T4','GESTANTE');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U4','TRANSFUSION');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V4','ETIOLOGIA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W4','TIPO HEPATITIS');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X4','ESTADIO HEPATITIS');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y4','FORMA INFECCION');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z4','GRUPO VULNERABLE');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA4','FUENTE PESQUISA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB4','MOTIVO FUENTE PESQUISA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC4','EVOLUCION CLINICA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD4','FECHA EVOLUCION CLINICA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE4','CAUSA FALLECIMIENTO');

        // Se agregan los encabezados de la hoja 2
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A4','No');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B4','NOMBRE');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C4','PRIMER APELLIDO');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D4','SEGUNDO APELLIDO');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E4','CARNET MADRE');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F4','NOMBRE MADRE');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G4','PRIMER APELLIDO MADRE');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H4','SEGUNDO APELLIDO MADRE');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I4','FECHA NACIMIENTO');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J4','INMUNOGLOBULINA');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K4','FECHA INMUNOGLOBULINA');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L4','FECHA ALTA');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M4','PRUEBAS');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N4','1ra DOSIS');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O4','2da DOSIS');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P4','3ra DOSIS');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('Q4','REACTIVACION');
    }

    public function AllValues($objPHPExcel,$pacientes , $hijos){

        //CICLOS PARA LLENAR LAS CELDAS QUE POSEEN DATOS---------------------------------------------------

        $fila = 5;
        $i = 1;
        foreach ($pacientes as $paciente)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$fila, $i);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, (int)$paciente->getCarnetIdentidad());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $paciente->getNombre());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila, $paciente->getPrimerApellido());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $paciente->getSegundoApellido());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila, $paciente->getEdad());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila, $paciente->getSexo());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $paciente->getFechaDiagnostico()->format('Y-m-d'));
            if($paciente->getUnidadAtencion()) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $paciente->getUnidadAtencion()->getMunicipio()->getProvincia()->getNombre());
            if($paciente->getUnidadAtencion()) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, $paciente->getUnidadAtencion()->getMunicipio()->getNombre());
            if($paciente->getUnidadAtencion()) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $paciente->getUnidadAtencion()->getNombre());
            if(count($paciente->getResidenciaDirecciones()) != 0) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, $paciente->getResidenciaDirecciones()->last()->getDireccionResidencia());
            if($paciente->getMunicipioCarnet()) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila, $paciente->getMunicipioCarnet()->getProvincia()->getNombre());
            if($paciente->getMunicipioCarnet()) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila, $paciente->getMunicipioCarnet()->getNombre());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$fila, $paciente->getDireccionCarnet());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$fila, $paciente->getOcupacion()->getNombre());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$fila, $paciente->getNivelEscolaridad()->getNombre());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$fila, $paciente->getEstadoCivil()->getNombre());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$fila, $paciente->getColorPiel()->getNombre());
            if($paciente->getPacienteGestante()) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$fila, 'X');
            if($paciente->getTransfusion()) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$fila, 'X');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$fila, $paciente->getEtiologia()->getNombre());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$fila, $paciente->getTipoHepatitis()->getNombre());
            if($paciente->getEstadioHepatitis()) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$fila, $paciente->getEstadioHepatitis()->getNombre());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$fila, $paciente->getFormaInfeccion()->getNombre());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$fila, $paciente->getGrupoVulnerable()->getNombre());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$fila, $paciente->getFuentePesquisa()->getNombre());
            if($paciente->getMotivoFuentePesquisa()) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$fila, $paciente->getMotivoFuentePesquisa()->getNombre());
            if(count($paciente->getTratamientoResultados()) != 0 ){
                if($paciente->getTratamientoResultados()->last()->getEvolucionClinica()) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$fila, $paciente->getTratamientoResultados()->last()->getEvolucionClinica()->getNombre());
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$fila, $paciente->getTratamientoResultados()->last()->getFecha()->format('Y-m-d'));
            }
            if($paciente->getCausaFallecimiento()) $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE'.$fila, $paciente->getCausaFallecimiento()->getNombre());

            $i++;
            $fila++;
        }
        $fila = 5;
        $i = 1;
        foreach($hijos as $hijo)
        {
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$fila, $i);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$fila, $hijo->getNombre());
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$fila, $hijo->getPrimerApellido());
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$fila, $hijo->getSegundoApellido());
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$fila, (int)$hijo->getPacienteGestante()->getPaciente()->getCarnetIdentidad());
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$fila, $hijo->getPacienteGestante()->getPaciente()->getNombre());
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.$fila, $hijo->getPacienteGestante()->getPaciente()->getPrimerApellido());
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.$fila, $hijo->getPacienteGestante()->getPaciente()->getSegundoApellido());
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'.$fila, $hijo->getFechaNacimiento()->format('Y-m-d'));
            if($hijo->getInmunoglobulina()) $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J'.$fila, 'x');
            if($hijo->getInmunoglobulina()) $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K'.$fila, $hijo->getFechainmunoglobulina()->format('Y-m-d'));
            if($hijo->getFechaAlta() and $hijo->getFechaAlta()->format('Y-m-d') != '0001-01-01') $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L'.$fila, $hijo->getFechaAlta()->format('Y-m-d'));
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M'.$fila, $hijo->cantidadPruebas());

            if(count($hijo->getHijoVacunas()) != 0)
            {
                $lastEsquemaVacunacion = $hijo->getHijoVacunas()->last();
                if($lastEsquemaVacunacion->getFechaVacunaPrimera()  and $lastEsquemaVacunacion->getFechaVacunaPrimera()->format('Y-m-d') != '0001-01-01')
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N'.$fila, $lastEsquemaVacunacion->getFechaVacunaPrimera()->format('Y-m-d'));
                if($lastEsquemaVacunacion->getFechaVacunaSegunda() and $lastEsquemaVacunacion->getFechaVacunaSegunda()->format('Y-m-d') != '0001-01-01')
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O'.$fila, $lastEsquemaVacunacion->getFechaVacunaSegunda()->format('Y-m-d'));
                if($lastEsquemaVacunacion->getFechaVacunaTercera() and $lastEsquemaVacunacion->getFechaVacunaTercera()->format('Y-m-d') != '0001-01-01')
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P'.$fila, $lastEsquemaVacunacion->getFechaVacunaTercera()->format('Y-m-d'));
                if($lastEsquemaVacunacion->getFechaReactivacion() and $lastEsquemaVacunacion->getFechaReactivacion()->format('Y-m-d') != '0001-01-01')
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('Q'.$fila, $lastEsquemaVacunacion->getFechaReactivacion()->format('Y-m-d'));
            }

            $i++;
            $fila++;
        }
    }

    //Estilos
    private function estiloEncabezadosColumnas()
    {
        return [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 10,
                'color' => [
                    'rgb' => '#222222'
                ]
            ],
            'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            ]
        ];


    }

    private function estiloTituloReporte()
    {
        return array(
            'font' => array(
                'name' => 'Century Gothic',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 20,
                'color' => array(
                    'rgb' => '111111'
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '#ffffff')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_MEDIUM,
                    'color' => array('argb' => '000000')
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER_CONTINUOUS,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
    }

    private function estiloDatos()
    {
        return [
            'font' => [
                'name' => 'Arial',
                'bold' => false,
                'italic' => false,
                'strike' => false,
                'size' => 9,
                'color' => [
                    'rgb' => '#222222'
                ]
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'rotation' => 0,
                'wrap' => TRUE
            ]
        ];
    }

}