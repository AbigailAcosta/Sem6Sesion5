<?php
// Incluimos la librería
require_once dirname(__FILE__).'/../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
// use Spipu\Html2Pdf\Exception\Html2PdfException;
// use Spipu\Html2Pdf\Exception\ExceptionFormatter;

// Recogemos el contenido de la vista
ob_start();
require_once 'documentos/listarubros_html.php';
$html = ob_get_clean();

// Pasamos esa vista a PDF

// Le indicamos el tipo de hoja y la codificación de caracteres
$mipdf = new HTML2PDF('P', 'A4', 'es', 'true', 'UTF-8');

// Escribimos el contenido en el PDF
$mipdf->writeHTML($html);

// Generamos el PDF
$mipdf->Output('listarubros.pdf');
?>
