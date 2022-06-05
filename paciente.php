<?php
require_once "connection/conectar.php";
require_once "class/Acesso.class.php";
require_once "class/Formulario.class.php";

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

//Acesso::verificar();
//!isset($_SESSION['nivel']) ? header("location: login") : "";

if(isset($_POST['prosseguir'])){Formulario::agendar();}
if(isset($_POST['prosseguirce'])){Formulario::arq_err();}

if(isset($_POST['formulario'])){
	$form = R::findOne("formularios", "id = $_POST[formulario]");
	$esp = R::findOne("especialidades", "id = $form[especialidade]");
} /*else {
	header("location: login");
}*/
$arqs = array($form['arq_doc_foto'], $form['arq_doc_foto_opc'], $form['arq_cartao_sus'], $form['arq_enc_medico'],
			  $form['arq_doc_med_comp'], $form['arq_cartao_consulta_frente'], $form['arq_cartao_consulta_verso']);


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
        <div class="container" data-page>
            <div class="voltar">
                <a href="<?= $_SESSION['nivel'] == 3 ? "recepcao" : "admin" ?>" data-route="<?= $_SESSION['nivel'] == 3 ? "recepcao" : "admin" ?>" class="btn btn-light">&laquo; Voltar</a>
            </div>

            <div class="page">
                <div class="row">
                    <div class="col-sm-12">
                        <h3><?= $form['nome'] ?></h3>
                        <hr>
                    </div>
                </div>
                        
                <div class="row">
					<div class="col-sm-12">
						<h3 class="text-center">Dados Informados</h3>
						<div style="font-size: smaller;">
							<table class="dados-table -align-top">
								<tr>
									<th>Atendimento</th>
									<td><?= $form['atendimento'] ?></td>
								</tr>
								<tr>
									<th>Nome Completo</th>
									<td><?= $form['nome_social'] ? $form['nome_social'] : $form['nome'] ?></td>
								</tr>
								<tr>
									<th>Data de Nascimento</th>
									<td><?= date_format(date_create($form['data_nascimento']), 'd/m/Y') ?></td>
								</tr>
								<tr>
									<th>RG</th>
									<td><?= $form['rg'] ?></td>
								</tr>
								<tr>
									<th>CPF</th>
									<td><?= $form['cpf'] ?></td>
								</tr>
								<tr>
									<th>Cartão do SUS</th>
									<td><?= $form['cartao_sus'] ?></td>
								</tr>
								<tr>
									<th>Telefone</th>
									<td><?= $form['telefone'] ?></td>
								</tr>
								<tr>
									<th>Endereço</th>
									<td>
										<?= $form['logradouro'] . ", " . $form['numero'] . " - " . $form['bairro']
										. ", " . $form['municipio'] . "-AP", ", " . $form['cep'] ?>
									</td>
								</tr>
							</table>
							<hr>
						</div>
					</div>
				</div>
												
                <form action="" method="post" enctype="multipart/form-data">
				    <div class="row">
				        <div class="col-sm-12">
						<?php if($form['atendimento'] == "1º Atendimento" && $arqs[0] || $arqs[1] && $arqs[2] && $arqs[3] && $arqs[4]): ?>
				            <h3 class="text-center">Arquivos Enviados</h3>
				    	    <div style="font-size: smaller;">
				    	    	<table class="dados-table -align-top">
				    	    		<tr>
				    	    			<th class="align-middle">Documento Oficial com Foto</th>
				    	    			<td>
				    	    				<a href="arquivo/<?= $arqs[0] ?>" class="btn btn-primary" target="_blank">Abrir</a>
				    	    			</td>
				    	    			<?php if($form['status'] == 'Em Análise'): ?>
				    	    			<td class="align-middle">
				    	    				<input class="form-check-input arquivos" type="checkbox" name="dfp" id="dfp" value="1">
				    	    				<label class="form-check-label" for="dfp">Arquivo incorreto</label>
				    	    			</td>
				    	    			<?php endif ?>
				    	    		</tr>
                                        
                                <?php if($arqs[1]): ?>
				    	    		<tr>
				    	    			<th class="align-middle">Em caso de documento de frente e verso, anexe o verso aqui</th>
				    	    			<td>
				    	    				<a href="arquivo/<?= $arqs[1] ?>" class="btn btn-primary" target="_blank">Abrir</a>
				    	    			</td>
				    	    			<?php if($form['status'] == 'Em Análise'): ?>
				    	    			<td class="align-middle">
				    	    				<input class="form-check-input arquivos" type="checkbox" name="dfop" id="dfop" value="1">
				    	    				<label class="form-check-label" for="dfop">Arquivo incorreto</label>
				    	    			</td>
				    	    			<?php endif ?>
				    	    		</tr>
								<?php endif ?>
                                        
                                	<tr>
				    	    			<th class="align-middle">Cartão do SUS</th>
				    	    			<td>
				    	    				<a href="arquivo/<?= $arqs[2] ?>" class="btn btn-primary" target="_blank">Abrir</a>
				    	    			</td>
				    	    			<?php if($form['status'] == 'Em Análise'): ?>
				    	    			<td class="align-middle">
				    	    				<input class="form-check-input arquivos" type="checkbox" name="crp" id="crp" value="1">
				    	    				<label class="form-check-label" for="crp">Arquivo incorreto</label>
				    	    			</td>
				    	    			<?php endif ?>
				    	    		</tr>
									
				    	    		<tr>
				    	    			<th class="align-middle">Encaminhamento Médico</th>
				    	    			<td>
				    	    				<a href="arquivo/<?= $arqs[3] ?>" class="btn btn-primary" target="_blank">Abrir</a>
				    	    			</td>
				    	    			<?php if($form['status'] == 'Em Análise'): ?>
				    	    			<td class="align-middle">
				    	    				<input class="form-check-input arquivos" type="checkbox" name="emp" id="emp" value="1">
				    	    				<label class="form-check-label" for="emp">Arquivo incorreto</label>
				    	    			</td>
				    	    			<?php endif ?>
				    	    		</tr>
                                        
                                	<tr>
				    	    			<th class="align-middle">Documento Médico Comprobatório</th>
				    	    			<td>
				    	    				<a href="arquivo/<?= $arqs[4] ?>" class="btn btn-primary" target="_blank">Abrir</a>
				    	    			</td>
				    	    			<?php if($form['status'] == 'Em Análise'): ?>
				    	    			<td class="align-middle">
				    	    				<input class="form-check-input arquivos" type="checkbox" name="dmcp" id="dmcp" value="1">
				    	    				<label class="form-check-label" for="dmcp">Arquivo incorreto</label>
				    	    			</td>
				    	    			<?php endif ?>
				    	    		</tr>
				    	    	</table>
				    	    	<hr>
    			    	    </div>

						<?php elseif($form['atendimento'] == "Retorno" && $arqs[5] && $arqs[6]): ?>
				            <h3 class="text-center">Arquivos Enviados</h3>
				    	    <div style="font-size: smaller;">
				    	    	<table class="dados-table -align-top">
				    	    		<tr>
				    	    			<th class="align-middle">Frente do Cartão de Consulta</th>
				    	    			<td>
				    	    				<a href="arquivo/<?= $arqs[5] ?>" class="btn btn-primary" target="_blank">Abrir</a>
				    	    			</td>
				    	    			<?php if($form['status'] == 'Em Análise'): ?>
				    	    			<td class="align-middle">
				    	    				<input class="form-check-input arquivos" type="checkbox" name="fccp" id="fccp" value="1">
				    	    				<label class="form-check-label" for="fccp">Arquivo incorreto</label>
				    	    			</td>
				    	    			<?php endif ?>
				    	    		</tr>
									
				    	    		<tr>
				    	    			<th class="align-middle">Verso do Cartão de Consulta</th>
				    	    			<td>
				    	    				<a href="arquivo/<?= $arqs[6] ?>" class="btn btn-primary" target="_blank">Abrir</a>
				    	    			</td>
				    	    			<?php if($form['status'] == 'Em Análise'): ?>
				    	    			<td class="align-middle">
				    	    				<input class="form-check-input arquivos" type="checkbox" name="vccp" id="vccp" value="1">
				    	    				<label class="form-check-label" for="vccp">Arquivo incorreto</label>
				    	    			</td>
				    	    		</tr>
								<?php endif ?>
				    	    	</table>
				    	    	<hr class="agendamento">
    			    	    </div>
						<?php endif ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-center agendamento" style="display: block">Agendamento</h3>
                            <div style="font-size: smaller;">
                                <table class="dados-table agendamento" style="display: block">
                                    <tr>
                                        <th>Protocolo</th>
                                        <td>
                                            <?= $form['protocolo'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Recebido em</th>
                                        <td><?= date_format(date_create($form['data_abertura']), 'd/m/Y - H:i:s') ?></td>
                                    </tr>
                                    
									<?php 
                                        if($form['atendimento'] != "1º Atendimento"):
                                            $medicos = R::findAll("medicos", "id = $form[id_med_retorno]");
                                    ?>
										<tr>
											<th>Prontuário</th>
											<td><?= $form['prontuario'] ?></td>
										</tr>
										<tr>
											<th>Data da Última Consulta</th>
											<td>
												<?= date_format(date_create($form['data_retorno']), 'd/m/Y') ?>
											</td>
										</tr>

										<?php if($form['atendimento'] == "Pós Operatório"): ?>
											<tr>
												<th class="align-middle">Data da Cirurgia</th>
												<td><?= date_format(date_create($form['data_cirurgia']), 'd/m/Y') ?></td>
											</tr>
										<?php endif ?>

										<tr>
											<th>Tempo para Retorno</th>
											<td><?= $form['tempo_retorno'] ?></td>
										</tr>
										<tr>
											<?php if($form['status'] != "Consultado"): ?>
											<th>Médico da última consulta</th>
											<td><?= $medicos[$form['id_med_retorno']]['medico'] ?></td>
											<?php endif ?>
										</tr>

									<?php
										else: 
											$medicos = R::findAll("medicos", "especialidade = $form[especialidade]");
										endif;
									?>

									<?php if($form['status'] != 'Consultado' && $form['status'] != 'Ausente' && $_SESSION['nivel'] == 3): ?>
										<tr>
											<th>Especialidade</th>
											<td>
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group">
															<select class="form-select agendamento" name="especialidade" id="especialidade" required>
																<option value="">Selecione a especialidade</option>
																<?php
																	$especialidades = R::findAll("especialidades");
																	foreach ($especialidades as $esp):
																?>
																<option value="<?= $esp['id'] ?>" <?= $form['especialidade'] == $esp['id'] ? "selected" : "" ?>><?= $esp['especialidade'] ?></option>
																<?php endforeach ?>
															</select>
														</div>
													</div>
												</div>
											</td>
										</tr>

										<tr>
											<th>Agendar Para</th>
											<td>
												<div class="row">
													<div class="col-sm-7">
														<div class="form-group">
															<label for="data_marcada" class="form-label agendamento">Data</label>
															<input type="date" class="form-control agendamento" id="data_marcada" name="data_marcada" value="<?= $form['data_marcada'] ?>" required>
														</div>
													</div>
		
													<div class="col-sm-5">
														<div class="form-group">
															<label for="hora_marcada" class="form-label agendamento">Hora</label>
															<input type="time" class="form-control agendamento" id="hora_marcada" name="hora_marcada" min="07:00" max="18:00" value="<?= date_format(date_create($form['hora_marcada']), 'H:i') ?>" required>
														</div>
													</div>
												</div>
											</td>
										</tr>

										<tr>
											<th>Médico</th>
											<td>
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group">
															<select class="form-select agendamento" name="medico" id="medico" required>
																<option value="" selected>Selecione o médico</option>
																<?php foreach ($medicos as $med): ?>
																	<option value='<?=$med['id']?>' <?= $form["id_medico"] == $med['id'] ? "selected" : "" ?>><?= $med['medico'] ?></option>";
																<?php endforeach ?>
															</select>
														</div>
													</div>
												</div>
											</td>
										</tr>

									<?php else: ?>
										<tr>
											<th>Especialidade</th>
											<td><?= $esp['especialidade'] ?></td>
										</tr>
										<tr>
											<th>Agendado Para</th>
											<td><?= date_format(date_create($form['data_marcada']), 'd/m/Y - ') . date_format(date_create($form['hora_marcada']), 'H:i') ?></td>
										</tr>
										<tr>
											<th>Médico</th>
											<td><?php $med = R::findOne("medicos", "id = $form[id_medico]"); echo $med['medico'] ?></td>
										</tr>
									<?php endif ?>
                                </table>
                                
                                <?php if($form['status'] != "Consultado" && $_SESSION['nivel'] == 3): ?>
									<div class="row">
										<div class="col-sm-12">
											<hr>
											<button class="btn btn-enviar btn-light" id="prosseguir" name="prosseguir" type="submit" value="<?= $_POST['formulario'] ?>" style="display: block;"><?= $form['data_marcada'] != NULL ? 'Atualizar' : 'Prosseguir' ?></button>
											<button class="btn btn-enviar btn-light" id="prosseguirce" name="prosseguirce" type="submit" value="<?= $_POST['formulario'] ?>" style="display: none;"><?= $form['data_marcada'] != NULL ? 'Atualizar' : 'Prosseguir' ?></button>
										</div>
									</div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
				</form>
            </div>
        </div>
    </div>
</div>
<!-- FIM DO CONTEÚDO -->

<!-- INÍCIO DO RODAPÉ -->
<?php require_once "rodape.php" ?>
<!-- FIM DO RODAPÉ -->

<!-- INÍCIO DO SCRIPTS -->
<?php require_once "scripts.php" ?>
<!-- FIM DO SCRIPTS -->

</body>
</html>