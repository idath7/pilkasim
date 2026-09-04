<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'NIS');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'Kelas');
$sheet->setCellValue('D1', 'Jenis Kelamin (L/P)');

// Optional styling
$styleArray = [
    'font' => [
        'bold' => true,
    ]
];
$sheet->getStyle('A1:D1')->applyFromArray($styleArray);

$writer = new Xlsx($spreadsheet);
$writer->save('public/template_pemilih.xlsx');
echo "Template created.\n";
