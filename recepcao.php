<?php
require_once "connection/conectar.php";
require_once "class/Acesso.class.php";
require_once "class/Formulario.class.php";

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

// Acesso
//Acesso::verificar();
if(isset($_POST['sair'])){Acesso::logout();}
!isset($_SESSION['nivel']) ? header("location: login") : "";
isset($_SESSION['nivel']) && $_SESSION['nivel'] < 3 ? header("location: admin") : "";

// Formulário
if(isset($_POST['presente'])){Formulario::presenca();}
if(isset($_POST['ausente'])){Formulario::presenca();}
if(isset($_POST['reagendar'])){Formulario::reagendar();}
?>

<!DOCTYPE html>
<html>
<head><?php require_once "head.php" ?></head>
<body>

<!-- INÍCIO DO TOPO -->
<?php require_once "topo.php" ?>
<!-- FIM DO TOPO -->

<!-- INÍCIO DO CONTEÚDO -->
<div class="content">
    <div class="main col-sm-12" data-root>
    <div class="container -default">
            <div class="page page-agenda">

                <div class="page-body">
                    <div class="page-title">
						<div class="col-sm-9">
                            <h3 style="margin-top:0; margin-bottom:20px;"><?= $_SESSION['nome'] ?></h3>
                        </div>
                        
						<div class="col-sm-3">
							<form action="novo" method="post">
								<button type="submit" class="btn btn-success main-button col-sm-11" id="posoperatorio" name="posoperatorio">
									<span class="-icon"><i class="fa fa-plus"></i></span>
									<span-label><b>Pós-Operatório</b></span-label>
								</button>
							</form>
                        </div>
                    </div>

                    <div id="main">
                        <ul class="nav nav-tabs" id="menu" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="formularios-tab" data-bs-toggle="tab" data-bs-target="#formularios" type="button" role="tab" aria-controls="formularios" aria-selected="true"><i class="fa-solid fa-file-medical"></i> Formulários</button>
                            </li>
							<li class="nav-item">
                                <button class="nav-link" id="agendados-tab" data-bs-toggle="tab" data-bs-target="#agendados" type="button" role="tab" aria-controls="agendados" aria-selected="true"><i class="fa-solid fa-file-circle-exclamation"></i> Agendados</button>
                            </li>
							<li class="nav-item">
                                <button class="nav-link" id="finalizados-tab" data-bs-toggle="tab" data-bs-target="#finalizados" type="button" role="tab" aria-controls="finalizados" aria-selected="true"><i class="fa-solid fa-file-circle-check"></i> Finalizados</button>
                            </li>
							<li class="nav-item">
                                <button class="nav-link" id="agenda-medico-tab" data-bs-toggle="tab" data-bs-target="#agenda-medico" type="button" role="tab" aria-controls="agenda-medico" aria-selected="false"><i class="fa-solid fa-book-medical"></i> Agenda do Médico</button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="formularios" role="tabpanel" aria-labelledby="formularios-tab">
                                <br>    
                                <table class="main-table" id="main-table-0">
									<thead>
                                        <th width=7%>ID</th>
                                        <th width=11%>Protocolo</th>
                                        <th width=20%>Especialidade</th>
                                        <th width=35%>Nome</th>
                                        <th width=15%>Telefone</th>
                                        <th width=6%>Ações</th>
                                    </thead>

                                    <tbody>
                                        <?php
                                            $formularios = R::getAll("SELECT formularios.id, formularios.protocolo, formularios.nome, formularios.telefone, especialidades.especialidade FROM formularios INNER JOIN especialidades ON formularios.especialidade = especialidades.id WHERE status = 'Em Análise'");
                                            foreach($formularios as $form):
                                        ?>
                                        <tr>
                                            <td width=7%><?= $form['id'] ?></td>
                                            <td width=11%><?= $form['protocolo'] ?></td>
                                            <td width=20%><?= $form['especialidade'] ?></td>
                                            <td width=35%><?= $form['nome'] ?></td>
                                            <td width=15%><?= $form['telefone'] ?></td>
                                            <td width=6%>
												<form action="paciente" method="post">
													<button type="submit" class="btn bg-success col-sm-10" id="formulario" name="formulario" title="Visualizar" value="<?= $form['id'] ?>"><i class="fa-solid fa-eye"></i></button>
												</form>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
							
							<div class="tab-pane fade show" id="agendados" role="tabpanel" aria-labelledby="agendados-tab">
                                <br>    
                                <table class="main-table">
                                    <thead>
                                        <th width=8%>ID</th>
                                        <th width=11%>Protocolo</th>
                                        <th width=20%>Especialidade</th>
                                        <th width=25%>Nome</th>
                                        <th width=15%>Telefone</th>
                                        <th width=20%>Ações</th>
                                    </thead>

                                    <tbody>
										<?php
                                            $formularios = R::getAll("SELECT formularios.id, formularios.protocolo, formularios.nome, formularios.telefone, especialidades.especialidade FROM formularios INNER JOIN especialidades ON formularios.especialidade = especialidades.id WHERE status = 'Agendado'");
                                            foreach($formularios as $form):
                                        ?>
                                        <tr>
                                            <td width=8%><?= $form['id'] ?></td>
                                            <td width=11%><?= $form['protocolo'] ?></td>
                                            <td width=20%><?= $form['especialidade'] ?></td>
                                            <td width=25%><?= $form['nome'] ?></td>
                                            <td width=15%><?= $form['telefone'] ?></td>
                                            <td width=20%>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <form action="paciente" method="post">
                                                            <button type="submit" class="btn bg-success col-sm-10" id="formulario" name="formulario" title="Visualizar" value="<?= $form['id'] ?>"><i class="fa-solid fa-eye"></i></button>
                                                        </form>
                                                    </div>
                                                
                                                    <div class="col-sm-4">
                                                        <form method="post">
                                                            <button type="submit" class="btn btn-info col-sm-10" id="presente" name="presente" title="Paciente Presente" value="<?= $form['id'] ?>"><i class="fa-solid fa-check"></i></button>
                                                        </form>
                                                    </div>
                                                        
                                                    <div class="col-sm-4">
                                                        <form method="post">
                                                            <button type="submit" class="btn btn-danger col-sm-10" id="ausente" name="ausente" title="Paciente Ausente" value="<?= $form['id'] ?>"><i class="fa-solid fa-xmark"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
							
							<div class="tab-pane fade show" id="finalizados" role="tabpanel" aria-labelledby="finalizados-tab">
                                <br>    
                                <table class="main-table">
                                    <thead>
                                        <th width=7%>ID</th>
                                        <th width=12%>Protocolo</th>
                                        <th width=20%>Especialidade</th>
                                        <th width=35%>Nome</th>
                                        <th width=15%>Telefone</th>
                                        <th width=6%>Ações</th>
                                    </thead>

                                    <tbody>
                                        <?php
                                            $formularios = R::getAll("SELECT formularios.id, formularios.protocolo, formularios.nome, formularios.telefone, especialidades.especialidade FROM formularios INNER JOIN especialidades ON formularios.especialidade = especialidades.id WHERE status IN ('Consultado', 'Ausente')");
                                            foreach($formularios as $form):
                                        ?>
                                        <tr>
                                            <td width=7%><?= $form['id'] ?></td>
                                            <td width=12%><?= $form['protocolo'] ?></td>
                                            <td width=20%><?= $form['especialidade'] ?></td>
                                            <td width=35%><?= $form['nome'] ?></td>
                                            <td width=15%><?= $form['telefone'] ?></td>
                                            <td width=6%>
												<form action="paciente" method="post">
													<button type="submit" class="btn bg-success col-sm-10" id="formulario" name="formulario" title="Visualizar" value="<?= $form['id'] ?>"><i class="fa-solid fa-eye"></i></button>
												</form>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade show" id="agenda-medico" role="tabpanel" aria-labelledby="agenda-medico-tab">
                                <br>
                                <table class="main-table">
                                    <thead>
                                        <th width=80%>Médico</th>
                                        <th width=20%>Ações</th>
                                    </thead>

                                    <tbody>
                                        <?php
                                            $medicos = R::findAll("medicos");
                                            foreach($medicos as $medico):
                                        ?>
                                        <tr>
                                            <td width=80%><?= $medico['medico'] ?></td>
                                            <td width=20%>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <form action="agenda-medico" method="post">
                                                            <button type="submit" class="btn btn-warning col-sm-10" id="agenda" name="agenda" title="Visualizar Agenda" value="<?= $medico['id'] ?>"><i class="fa-solid fa-calendar-check"></i></button>
                                                        </form>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <a title="Trocar Data de Agendamento" class="btn bg-danger col-sm-10" data-bs-toggle="modal" data-bs-target="#agenda<?= $medico['id'] ?>" style="color: white"><i class="fa-solid fa-calendar-day"></i></a>
                                                    </div>
                                                    
                                                    <div class="col-sm-4">
                                                        <a title="Boletim de <?= $medico['medico'] ?>" class="btn btn-info col-sm-10" data-bs-toggle="modal" data-bs-target="#boletim<?= $medico['id'] ?>"><i class="fa-solid fa-file-medical"></i></a>
                                                    </div>

                                                    <div class="modal fade" id="boletim<?= $medico['id'] ?>" tabindex="-1" aria-labelledby="labelboletim<?= $medico['id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="labelboletim<?= $medico['id'] ?>"><b>Data do Boletim</b></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="boletim" method="post" enctype="multipart/form-data">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label for="data_marcada" class="form-label">Data da Agenda</label>
                                                                                    <input type="date" class="form-control" id="data_marcada" name="data_marcada" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <button type="submit" class="btn btn-enviar btn-light" id="boletim" name="boletim" value="<?= $medico['id'] ?>">Gerar Boletim</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="agenda<?= $medico['id'] ?>" tabindex="-1" aria-labelledby="labelagenda<?= $medico['id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="labelagenda<?= $medico['id'] ?>"><b>Trocar data da consulta?</b></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label for="data_marcada" class="form-label">Data da Agenda</label>
                                                                                    <input type="date" class="form-control" id="data_marcada" name="data_marcada" min="<?= date('Y-m-d') ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label for="nova_data_marcada" class="form-label">Nova Data da Agenda</label>
                                                                                    <input type="date" class="form-control" id="nova_data_marcada" name="nova_data_marcada" min="<?= date('Y-m-d') ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <button type="submit" class="btn btn-enviar btn-light" id="reagendar" name="reagendar" value="<?= $medico['id'] ?>">Reagendar</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-footer" style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <b>Usuário:</b> <?= $_SESSION['email'] ?>
                    </div>
                    <form action="" method="post" style="display: inline">
                        <button type="submit" class="btn btn-xs btn-logout" id="sair" name="sair">Sair</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM DO CONTEÚDO -->

<!-- INÍCIO DO RODAPÉ -->
<?php require_once "rodape.php" ?>
<!-- FIM DO RODAPÉ -->

<!-- INÍCIO DOSCRIPTS -->
<?php require_once "scripts.php" ?>
<!-- FIM DOSCRIPTS -->

</body>
</html>