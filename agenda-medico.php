<?php
require_once "connection/conectar.php";
require_once "class/Acesso.class.php";

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

Acesso::verificar();

if(isset($_SESSION['nivel'])){
	if(isset($_POST['agenda'])){
		$med = R::findOne("medicos", "id = $_POST[agenda]");
	} else {
		$_SESSION['nivel'] != 3 ? header("location: admin") : header("location: recepcao");
	}
} else {
    header("location: login");
}
?>

<!DOCTYPE html>
<html>
<head><?php require_once "head.php" ?></head>
<body>

<!-- INÍCIO DO TOPO -->
<?php require_once "topo.php" ?>
<!-- FIM DO TOPO -->

<!-- INÍCIO DO CONTEÚDO -->
<form method="post">
<div class="content">
    <div class="main col-sm-12" data-root>
    <div class="container -default">
            <div class="page page-agenda">

                <div class="page-body">
                    <div class="page-title">
                        <h3 style="margin-top:0; margin-bottom:20px;">Agenda do(a) <?= $med['medico'] ?></h3>
                    </div>

                    <div id="main">
                        <ul class="nav nav-tabs" id="menu" role="tablist">
						<?php
							$mes = ['jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez'];
							for($i = 0; $i < count($mes); $i++):
						?>
						<li class="nav-item">
							<button class="nav-link <?php if($i == date('m')-1){echo 'active';} ?>" id="<?= $mes[$i] ?>-tab" data-bs-toggle="tab" data-bs-target="#<?= $mes[$i] ?>" type="button" role="tab" aria-controls="<?= $mes[$i] ?>" aria-selected="<?php if($i == date('m')-1){echo 'true';}else{echo 'false';} ?>"><?= strtoupper($mes[$i]) ?></button>
						</li>
						<?php endfor ?>
						</ul>

						<div class="tab-content">
							<?php for($i = 0; $i < count($mes); $i++): ?>
							<div class="tab-pane fade show <?php if($i == date('m')-1){echo 'active';} ?>" id="<?= $mes[$i] ?>" role="tabpanel" aria-labelledby="<?= $mes[$i] ?>-tab">
								<br>
								<table class="doctor-schedule" width=100%>
									<thead>
										<tr>
											<th width=10%>Protocolo</th>
											<th width=35%>Paciente</th>
											<th width=20%>Status</th>
											<th width=11%>Dia</th>
											<th width=12%>Hora</th>
											<th width=12%>Ano</th>
										</tr>
									</thead>
									
									<tbody>
										<?php
											$formularios = R::findAll("formularios", "id_medico = $med[id] AND MONTH(data_marcada) = $i+1 ORDER BY data_marcada ASC, id ASC");
											foreach($formularios as $form):
										?>
										<tr>
											<td width=10%><?= $form['protocolo'] ?></td>
											<td width=35%><?= $form['nome'] ?></td>
											<td width=20%><?= $form['status'] ?></td>
											<td width=11% class="text-center"><?= date_format(date_create($form['data_marcada']), 'd') ?></td>
											<td width=12% class="text-center"><?= date_format(date_create($form['hora_marcada']), 'H:i') ?></td>
											<td width=12% class="text-center"><?= date_format(date_create($form['data_marcada']), 'Y') ?></td>
										</tr>
										<?php endforeach ?>
									</tbody>
								</table>
							</div>
							<?php endfor ?>
						</div>
                    </div>
                </div>

                <div class="page-footer" style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <b>Usuário:</b> <?= $_SESSION['email'] ?>
                    </div>
                    <form action="" method="post" style="display: inline">
                        <button class="btn btn-xs btn-logout" onclick="window.close()">Voltar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<!-- FIM DO CONTEÚDO -->

<!-- INÍCIO DO RODAPÉ -->
<?php require_once "rodape.php" ?>
<!-- FIM DO RODAPÉ -->

<!-- INÍCIO DO SCRIPTS -->
<?php require_once "scripts.php" ?>
<!-- FIM DO SCRIPTS -->

</body>
</html>