<?php

require('scripts/fpdf/fpdf.php');
require('connection/conectar.php');

$medico = R::findOne("medicos", "id = $_POST[boletim]");
$formularios = R::findAll("formularios", "id_medico = $medico[id] AND data_marcada = '" . $_POST['data_marcada'] . "'");
$especialidade = R::findOne("especialidades", "id = $medico[especialidade]");


$pdf = new FPDF('L','mm','A4');
$pdf->SetAutoPageBreak(true, 1);
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);

// Layout
$pdf->SetXY(10,10);$pdf->Cell(54,15,'','LTB');
$pdf->SetXY(64,10);$pdf->Cell(93,15,'','LTB');
$pdf->SetXY(157,10);$pdf->Cell(63,15,'','LTB');
$pdf->SetXY(220,10);$pdf->Cell(4,15,'','LTB');
$pdf->SetXY(224,10);$pdf->Cell(63,15,'','LTBR');

$y = 20;
for ($i = 0; $i <= 32; $i++) { 
    $y = $y+5;
    $pdf->SetXY(10,$y); $i > 0 ? $pdf->Cell(7,5,$i < 10 ? "0$i" : $i,'LB') :  $pdf->Cell(7,5,"",'LB');
    $pdf->SetXY(17,$y); $pdf->Cell(95,5,'','LB');
    $pdf->SetXY(112,$y); $pdf->Cell(30,5,'','LB'); 
    $pdf->SetXY(142,$y); $pdf->Cell(30,5,'','LB');
    $pdf->SetXY(172,$y); $pdf->Cell(8,5,'','LB');
    $pdf->SetXY(180,$y); $pdf->Cell(8,5,'','LB');
    $pdf->SetXY(188,$y); $pdf->Cell(8,5,'','LB');
    $pdf->SetXY(196,$y); $pdf->Cell(8,5,'','LB');
    $pdf->SetXY(204,$y); $pdf->Cell(8,5,'','LB');
    $pdf->SetXY(212,$y); $pdf->Cell(75,5,'','LBR');
}



// Cabeçalho
$pdf->SetFont('Arial','B',6);
$pdf->SetXY(10,10);$pdf->MultiCell(54,5,"GEA-SECRETARIA DO ESTADO DA SAUDE",'','C');
$pdf->SetXY(10,15);$pdf->MultiCell(54,5,"HOSPITAL DE CLINICAS DR. ALBERTO LIMA",'','C');

$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(54,5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",'AMBULATÓRIO'),'','C');
$pdf->SetXY(64,10); $pdf->MultiCell(93,8,"BOLETIM DE ATENDIMENTO DE",'','C');
$pdf->SetXY(64,18); $pdf->MultiCell(93,7,"CONSULTA",'','C');

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(157,10); $pdf->MultiCell(63,8,"DATA: _____/_____/_____",'','L');
$pdf->SetXY(157,18); $pdf->MultiCell(63,7,"HORA: _____:_____",'','L');

$pdf->SetXY(224,10); $pdf->MultiCell(63,8,"ESPECI.:",'','L');
$pdf->SetXY(224,18); $pdf->MultiCell(63,7,iconv("UTF-8", "ISO-8859-1//TRANSLIT","MÉDICO:"),'','L');

// Titulo
$pdf->SetXY(10,25); $pdf->MultiCell(7,5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",'Nº'),'','C');
$pdf->SetXY(17,25); $pdf->MultiCell(95,5,'NOME','','C');
$pdf->SetXY(112,25); $pdf->MultiCell(30,5,'PRONTUARIO','','C');
$pdf->SetXY(142,25); $pdf->MultiCell(30,5,'D.N.','','C');
$pdf->SetXY(212,25); $pdf->MultiCell(75,5,'DIAGNOSTICO','','C');

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(172,25); $pdf->MultiCell(8,5,'SEX','','C');
$pdf->SetXY(188,25); $pdf->MultiCell(8,5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",'1ºA'),'','C');
$pdf->SetXY(196,25); $pdf->MultiCell(8,5,'RET','','C');
$pdf->SetXY(204,25); $pdf->MultiCell(8,5,'POS','','C');

$pdf->SetFont('Arial','B',6);
$pdf->SetXY(180,25); $pdf->MultiCell(8,5,'idade','','C');


// Dados
$pdf->SetFont('Arial','',10);
$pdf->SetXY(170,11); $pdf->MultiCell(10,5,date_format(date_create($_POST['data_marcada']), 'd'),'','C');
$pdf->SetXY(181,11); $pdf->MultiCell(10,5,date_format(date_create($_POST['data_marcada']), 'm'),'','C');
$pdf->SetXY(192,11); $pdf->MultiCell(10,5,date_format(date_create($_POST['data_marcada']), 'Y'),'','C');
$pdf->SetXY(240,10); $pdf->MultiCell(47,$especialidade['id'] == 5 ? 4 : 8,iconv("UTF-8", "ISO-8859-1//TRANSLIT",$especialidade['especialidade']),'','L');
$pdf->SetXY(240,18); $pdf->MultiCell(47,mb_strlen($medico['medico']) > 26 ? 3.5 : 7,iconv("UTF-8", "ISO-8859-1//TRANSLIT",$medico['medico']),'','L');

$y = 25;
foreach ($formularios as $form) {
    $y = $y+5;
    $dn = new DateTime($form['data_nascimento']);
    $idade = $dn->diff(new DateTime(date('Y-m-d')));
    $pdf->SetXY(17,$y); $pdf->MultiCell(95,5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",$form['nome_social'] ? $form['nome_social'] : $form['nome']));
    $pdf->SetXY(112,$y); $pdf->MultiCell(30,5,$form['prontuario'],'','C'); 
    $pdf->SetXY(142,$y); $pdf->MultiCell(30,5,date_format(date_create($form['data_nascimento']), 'd/m/Y'),'','C');
    $pdf->SetXY(172,$y); $pdf->MultiCell(8,5,$form['sexo'] == 1 ? 'M' : 'F' ,'','C');
    $pdf->SetXY(180,$y); $pdf->MultiCell(8,5,$idade->format('%Y'),'','C');
    $pdf->SetXY(188,$y); $pdf->MultiCell(8,5,$form['atendimento'] == "1º Atendimento" ? 'X' : '','','C');
    $pdf->SetXY(196,$y); $pdf->MultiCell(8,5,$form['atendimento'] == "Retorno" ? 'X' : '','','C');
    $pdf->SetXY(204,$y); $pdf->MultiCell(8,5,$form['atendimento'] == "Pós Operatório" ? 'X' : '','','C');
}

$pdf->Output('I', "Boletim de $medico[medico].pdf", true);

?>