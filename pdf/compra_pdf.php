<?php
// Configuración de reporte de errores
error_reporting(E_ALL ^ E_WARNING);

// Iniciar el almacenamiento en búfer
ob_start();

// Cargar las clases necesarias
require_once '../class/class.compras.php';
$factura = new Compra();

require_once '../class/class.detallecompras.php';
$JSONdetalle = new DetalleCompra();

// Iniciar sesión
session_start();
$sesion = $_SESSION['usuario'];

// Obtener los detalles de la compra
$arrDetalles = $JSONdetalle->getDetalles($sesion);

// Contar los detalles de la compra
$count = 0;
foreach ($arrDetalles as $detalle) {
    $count++;
}

// Verificar si hay artículos agregados a la compra
if ($count == 0) {
    echo "<script>alert('No hay articulos agregados a la compra');</script>";
    echo "<script>window.close();</script>";
    exit;
}

// Cargar las librerías necesarias para la generación del PDF
require_once dirname(__FILE__) . '/../vendor/autoload.php';

use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

// Obtener las variables de la solicitud
$numero_factura = $_REQUEST['numero'];
$idproveedor = $_REQUEST['idproveedor'];
$fecha = $_REQUEST['fecha'];
$estado = $_REQUEST['estado'];
$idusuario = $_SESSION['idUsuario'];

// Obtener el contenido HTML
include(dirname('__FILE__') . '/documentos/compra_html.php');
$content = ob_get_clean();

// Intentar generar el PDF
try {
    // Inicializar HTML2PDF
    $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', array(0, 0, 0, 0));
    
    // Configurar el modo de visualización completo
    $html2pdf->pdf->SetDisplayMode('fullpage');
    
    // Convertir el contenido HTML a PDF
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    
    // Enviar el archivo PDF al navegador
    $html2pdf->Output('planillacompras' . $sesion . '.pdf');
} catch (Html2PdfException $e) {
    // Capturar errores en caso de fallo
    echo $e;
    exit;
}
?>
