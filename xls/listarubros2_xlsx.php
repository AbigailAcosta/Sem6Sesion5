<?php
include '../class/class.rubros.php';
$rubro = new Rubro();
$resultado = $rubro->getRubros();

//call the autoload
require '../vendor/autoload.php';
//load phpspreadsheet class using namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//call iofactory instead of xlsx writer
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

//styling arrays
//table head style
$tableHead = [
    'font'=>[
        'color'=>[
            'rgb'=>'FFFFFF'
        ],
        'bold'=>true,
        'size'=>16
    ],
    'fill'=>[
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'DC7633'
        ]
    ],
];
//even row
$evenRow = [
    'fill'=>[
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'EDBB99'
        ]
    ]
];
//odd row
$oddRow = [
    'fill'=>[
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'FBEEE6'
        ]
    ]
];

//styling arrays end

//make a new spreadsheet object
$spreadsheet = new Spreadsheet();
//get current active sheet (first sheet)
$sheet = $spreadsheet->getActiveSheet();

//set default font
$spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Arial')
    ->setSize(12);

//heading
$spreadsheet->getActiveSheet()
    ->setCellValue('B1',"Listado de Rubros");

//merge heading
$spreadsheet->getActiveSheet()->mergeCells("B1:C1");

// set font style
$spreadsheet->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);

// set cell alignment
$spreadsheet->getActiveSheet()->getStyle('B1')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

//setting column width
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);

//header text
$spreadsheet->getActiveSheet()
    ->setCellValue('B2',"Código")
    ->setCellValue('C2',"Nombre");

//set font style and background color
$spreadsheet->getActiveSheet()->getStyle('B2:C2')->applyFromArray($tableHead);

//the content
//loop through the data
$row = 3;
foreach($resultado as $registro) {
    $spreadsheet->getActiveSheet()
        ->setCellValue('B'.$row , $registro['idRubro'])
        ->setCellValue('C'.$row , $registro['nombre']);

    //set row style
    if( $row % 2 == 0 ){
        //even row
        $spreadsheet->getActiveSheet()->getStyle('B'.$row.':C'.$row)
            ->applyFromArray($evenRow);
    }else{
        //odd row
        $spreadsheet->getActiveSheet()->getStyle('B'.$row.':C'.$row)
            ->applyFromArray($oddRow);
    }
    //increment row
    $row++;
}

//autofilter
//define first row and last row
$firstRow = 2;
$lastRow = $row - 1;
//set the autofilter
$spreadsheet->getActiveSheet()->setAutoFilter("B".$firstRow.":C".$lastRow);

//set the header first, so the result will be treated as an xlsx file.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

//make it an attachment so we can define filename
header('Content-Disposition: attachment;filename="listadorubros.xlsx"');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
?>