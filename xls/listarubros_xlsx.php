<?php
include '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_POST["file_content"])) {
    $temporary_html_file = 'temp/' . time() . '.html';

    file_put_contents($temporary_html_file, $_POST["file_content"]);

    $reader = IOFactory::createReader('Html');

    $spreadsheet = $reader->load($temporary_html_file);

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

    $filename = 'MiExcel-' . time() . '.xlsx';

    $writer->save($filename);

    header('Content-Type: application/x-www-form-urlencoded');

    header('Content-Transfer-Encoding: Binary');

    header("Content-disposition: attachment; filename=\"" . $filename . "\"");

    readfile($filename);

    unlink($temporary_html_file);

    unlink($filename);

    exit;
}
?>