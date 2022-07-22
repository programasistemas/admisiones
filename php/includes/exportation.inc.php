<?php

/**
 * Crea y retorna un string con la estructura HTML de la tabla para generar el reporte en formato PDF
 * 
 * @param array $data Array con los datos
 * @param array $columns Array con las columnas
 * @return string String que contiene el template HTML
 */

function createHtmlTableBody($data)
{
    $output = '';
    if (empty($data)) $output = '<tbody><tr>No se encontraron registros relacionados con su busqueda</tr></tbody>';
    else {
        $output = '<tbody>';
        foreach ($data as $item) {
            $output .= '<tr>';
            foreach ($item as $value) {
                $output .= '<td>' . $value . '</td>';
            }
            $output .= '</tr>';
        }
        $output .= '</tbody>';
    }

    return $output;
}

/**
 * Genera un csv en el browser del cliente
 * @param array $array Array con los datos a exportal
 * @param string $doc_name Nombre del documento exportado
 */
function exportCsvDocument($array, $doc_name, $ext = 'csv', $separator = ";")
{
    if (!ob_start("ob_gzhandler")) ob_start();

    $fecha_generacion = date('Y-m-d');
    $document_name = $doc_name . '_' . $fecha_generacion;

    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename=' . $document_name . '.' . $ext);
    header("Content-Transfer-Encoding: utf-8");

    $output = fopen('php://output', 'w');
    foreach ($array as $item) {
        fputcsv($output, $item, $separator);
    }
    fclose($output);
    ob_end_flush();
    readfile('php://output');
}

/**
 * Genera y retorna un documento excel con los datos pasados por parametro
 * 
 * @param array $data Array con todos los datos
 * @param array $header_names Array con los nombres de las columnas
 * @param string $title Nombre que tendra la hoja de excel
 * @param string $doc_name Nombre del documento resultante
 * @return array Array conteniendo el spread instance y el writer instance de excel
 */
function createExcelDocument(&$spread_instance, &$writer_instance, &$data, $header_names, $title, $doc_name)
{
    $fecha_generacion = date('Y-m-d');
    $hora_generacion = date('H-i-s');

    $document_name = $doc_name . '_' . $fecha_generacion . '_' . $hora_generacion;
    $active_sheet = $spread_instance->getActiveSheet();
    $active_sheet->setTitle($title);

    $col = 1;
    foreach ($header_names as $name) {
        $active_sheet->setCellValueByColumnAndRow($col, 1, $name);
        $col++;
    }

    $row = 2;
    foreach ($data as $item) {
        $col = 1;
        foreach ($item as $value) {
            $active_sheet->setCellValueByColumnAndRow($col, $row, $value);
            $col++;
        }
        $row++;
    }

    return [$spread_instance, $writer_instance, $document_name];
}

/**
 * Genera y descarga un archivo excel con los datos que se le pasen por parametro
 * 
 * @param array $data Array con todos los datos a exportar
 * @param array $header_names Array con los nombres de las columnas
 * @param string $doc_name Nombre del documento resultante
 */
function createAndExportExcelDocument(&$spread_instance, &$writer_instance, &$data, $header_names, $doc_name)
{
    if (!ob_start('ob_gzhandler')) ob_start();

    $fecha_generacion = date('Y-m-d');
    $hora_generacion = date('H-i-s');

    $document_name = $doc_name . '_' . $fecha_generacion . '_' . $hora_generacion;

    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename=' . $document_name . '.xlsx');
    header('Content-Transfer-Encoding: UTF-8');

    $active_sheet = $spread_instance->getActiveSheet();
    $active_sheet->setTitle($doc_name);

    $col = 1;
    foreach ($header_names as $name) {
        $active_sheet->setCellValueByColumnAndRow($col, 1, $name);
        $col++;
    }

    $row = 2;
    foreach ($data as $item) {
        $col = 1;
        foreach ($item as $value) {
            $active_sheet->setCellValueByColumnAndRow($col, $row, $value);
            $col++;
        }
        $row++;
    }

    $writer_instance->save('php://output');
    ob_end_flush();
    readfile('php://output');
}

/**
 * Genera y descarga un archivo excel con los datos que se le pasen por parametro
 * 
 * @param array $data Array con todos los datos necesarios para generar el archivo de exportacion
 * @param array $header_names Array con los nombres de las columnas 
 * @param string $doc_name Nombre del documento resultante
 */
function createAndExportExcelWithMultipleSheets(&$spread_instance, &$writer_instance, &$data, $doc_name)
{
    require_once VENDOR_AUTOLOAD_PATH;

    if (!ob_start("ob_gzhandler")) ob_start();

    $fecha_generacion = date('Y-m-d');

    $document_name = $doc_name . '_' . $fecha_generacion . '_' . date('H-i-s');

    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename=' . $document_name . '.xlsx');
    header("Content-Transfer-Encoding: UTF-8");

    $spread_instance->removeSheetByIndex(0);

    foreach ($data as $item) {
        $spread_instance->addSheet(new PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spread_instance, $item['name']));
        $spread_instance->setActiveSheetIndexByName($item['name']);

        $active_sheet = $spread_instance->getActiveSheet();

        switch ($item['direction']) {
            case 'row':
                $col = 1;
                foreach ($item['headers'] as $name) {
                    $active_sheet->setCellValueByColumnAndRow($col, 1, $name);
                    $col++;
                }

                $row = 2;
                foreach ($item['data'] as $item) {
                    $col = 1;
                    foreach ($item as $value) {
                        $active_sheet->setCellValueByColumnAndRow($col, $row, $value);
                        $col++;
                    }
                    $row++;
                }
                break;

            case 'column':
                $row = 1;
                $col = 1;

                foreach ($item['headers'] as $name) {
                    $active_sheet->setCellValueByColumnAndRow($col, $row, $name);
                    $row++;
                }

                $row = 1;
                foreach ($item['data'] as $item) {
                    $col = 2;

                    if (is_array($item)) {
                        foreach ($item as $value) {
                            $active_sheet->setCellValueByColumnAndRow($col, $row, $item);
                            $col++;
                        }
                    } else {
                        $active_sheet->setCellValueByColumnAndRow($col, $row, $item);
                        $row++;
                    }
                }
                break;
        }
    }

    $writer_instance->save('php://output');
    ob_end_flush();
    readfile('php://output');
}
