<?php
require_once "connection/conectar.php";
require_once "class/Formulario.class.php";

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

if(isset($_POST['cancelar'])){Formulario::cancelar();}
if(isset($_POST['prosseguir'])){Formulario::arq_upd();}
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
    <div class="main col-sm-6" data-root>

        <div class="container" data-page>
            <div class="voltar">
                <a href="./" data-route="index" class="btn btn-light">&laquo; voltar</a>
            </div>

            <div class="page">

                <div class="row">
                    <div class="col-sm-12">
                    <?php
                        if(isset($_POST['consulta']) || isset($_COOKIE['sucesso'])):
							if(isset($_POST['consulta'])){
								if(strlen($_POST['consulta']) == 14){
									$formularios = R::findAll("formularios", "cpf = '$_POST[consulta]'");
									$consulta = "CPF";
								}elseif(strlen($_POST['consulta']) == 6){
									$formularios = R::findAll("formularios", "protocolo = $_POST[consulta]");
									$consulta = "Protocolo";
								} else {
									$formularios = "";
									$consulta = "Código Indefinido";
								}
							} else {
								$formularios = R::findAll("formularios", "protocolo = $_COOKIE[sucesso]");
								$consulta = "Protocolo";
							}
							if (!$formularios):
					?>
						<?= $consulta ?> informado não foi encontrado, por favor verifique o <?= $consulta ?> informado e <a href="consultar">tente novamente</a>.
					<?php else: ?>
						<div class="row">
							<div class="col-sm-12">
								<h3>Consultar Agendamento</h3>
								<hr>
							</div>
						</div>
						<?php
							foreach($formularios as $form):
								$esp = R::findOne("especialidades", "id = $form[especialidade]");
								$med = R::findOne("medicos", "id = $form[id_medico]");
						?>				
							<table class="dados-table -align-top" width=100%>
								<tr>
									<th class="td-compact align-middle">Atendimento</th>
									<td class="align-middle"><?= $form['atendimento'] ?></td>
								</tr>
								<tr>
									<th class="align-middle">Especialidade</th>
									<td class="align-middle"><?= $esp['especialidade'] ?></td>
								</tr>
								<tr>
									<?php
										switch ($form['status']) {
											case 'Em Análise':
												$st = 0;
												break;
											case 'Agendado':
												$st = 1;
												break;
											case 'Consultado':
												$st = 1;
												break;
											case 'Arquivos Incorretos':
												$st = 2;
												break;
											case 'Ausente':
												$st = 2;
												break;
											case 'Cancelado':
												$st = 2;
												break;
										}
									?>
									<th>Andamento</th>
									<td class="align-middle status-andamento status-<?= $st ?>"><?= $form['status'] ?></td>
								</tr>
								<tr>
									<th class="align-middle">Ação</th>
									<td class="align-middle">
										<div class="row">
											<div class="col-sm-6">
												<a title="Visualizar" class="btn bg-success" data-bs-toggle="modal" data-bs-target="#form<?= $form['id'] ?>" style="color: white"><i class="fas fa-eye"></i>&nbsp;Visualizar</a>
											</div>
											<?php if($form['status'] == "Em Análise" || $form['status'] == "Agendado" || $form['status'] == "Arquivos Incorretos"): ?>
											<div class="col-sm-6">
												<a title="Cancelar Consulta" class="btn bg-danger" data-bs-toggle="modal" data-bs-target="#formcanc<?= $form['id'] ?>" style="color: white"><i class="fas fa-calendar-times"></i>&nbsp;Cancelar Consulta</a>
											</div>
											<?php endif ?>
											<div class="modal fade" id="formcanc<?= $form['id'] ?>" tabindex="-1" aria-labelledby="labelformcanc<?= $form['id'] ?>" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered modal-sm">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="labelformcanc<?= $form['id'] ?>"><b>Deseja cancelar sua consulta?</b></h5>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-sm-3"></div>
																<div class="col-sm-3">
																	<form method="post">
																		<button type="submit" class="btn bg-success col-sm-12" id="cancelar" name="cancelar" title="Cancelar" value="<?= $form['id'] ?>"><b style="color: white">Sim</b></button>
																	</form>
																</div>
																<div class="col-sm-3">
																	<a class="btn bg-danger" data-bs-dismiss="modal"><b style="color: white">Não</b></a>
																</div>
																<div class="col-sm-3"></div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="modal fade" id="form<?= $form['id'] ?>" tabindex="-1" aria-labelledby="form<?= $form['id'] ?>-Label" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h3 class="modal-title" id="form<?= $form['id'] ?>-Label"><?= $form['nome'] ?></h3>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-sm-12">
																	<div class="consulta-resultado">
																		<h3 class="text-center">Status do Protocolo</h3>
																		<table class="dados-table">
																			<tr>
																				<th class="align-middle">Protocolo</th>
																				<td class="align-middle"><?= $form['protocolo'] ?></td>
																			</tr>
																			<tr>
																				<th class="align-middle">Recebido em</th>
																				<td class="align-middle"><?= date_format(date_create($form['data_abertura']), 'd/m/Y - H:i') ?></td>
																			</tr>
																			<tr>
																				<th class="align-middle">Andamento</th>
																				<td class="align-middle status-andamento status-<?= $st ?>"><?= $form['status'] ?></td>
																			</tr>
																			<?php if ($form['status'] == "Agendado" || $form['status'] == "Consultado"): ?>
																				<?php if ($form['status'] == "Agendado"): ?>
																					<tr>
																						<th class="align-middle">Marcado para</th>
																						<td class="align-middle"><?= date_format(date_create($form['data_marcada']), 'd/m/Y - ') . date_format(date_create($form['hora_marcada']), 'H:i') ?></td>
																					</tr>
																				<?php elseif ($form['status'] == "Consultado"): ?>
																					<tr>
																						<th class="align-middle">Consultado Em</th>
																						<td class="align-middle"><?= date_format(date_create($form['data_consultado']), 'd/m/Y - H:i') ?></td>
																					</tr>
																				<?php endif; ?>
																				<tr>
																					<th class="align-middle">Médico</th>
																					<td class="align-middle"><?= $med['medico'] ?></td>
																				</tr>
																			<?php endif; ?>
																		</table>
					
																		<hr>
																		<h3 class="text-center">Dados Informados</h3>
					
																		<div style="font-size: smaller;">
																			<table class="dados-table -align-top">
																				<tr>
																					<th class="align-middle">Nome Completo</th>
																					<td class="align-middle"><?= $form['nome_social'] ? $form['nome_social'] : $form['nome'] ?></td>
																				</tr>
																				<tr>
																					<th class="align-middle">Atendimento</th>
																					<td class="align-middle"><?= $form['atendimento'] ?></td>
																				</tr>
																				<tr>
																					<th class="align-middle">Especialidade</th>
																					<td class="align-middle"><?= $esp['especialidade'] ?></td>
																				</tr>
																				<tr>
																					<th class="align-middle">RG</th>
																					<td class="align-middle"><?= $form['rg'] ?></td>
																				</tr>
																				<tr>
																					<th class="align-middle">CPF</th>
																					<td class="align-middle"><?= $form['cpf'] ?></td>
																				</tr>
																				<tr>
																					<th class="align-middle">Cartão do SUS</th>
																					<td class="align-middle"><?= $form['cartao_sus'] ?></td>
																				</tr>
																				<tr>
																					<th class="align-middle">Telefone</th>
																					<td class="align-middle"><?= $form['telefone'] ?></td>
																				</tr>
																				<tr>
																					<th class="align-middle">Endereço</th>
																					<td class="align-middle">
																						<?= $form['logradouro'] . ", " . $form['numero'] . " - " . $form['bairro']
																						. ", " . $form['municipio'] . "-AP", ", " . $form['cep'] ?>
																					</td>
																				</tr>
																			</table>
																			<?php if($form['status'] == "Arquivos Incorretos"): ?>
																			<hr>
																			<form action="" method="post" enctype="multipart/form-data">
																				<div class="row">
																					<div class="col-sm-12">
																						<h3 class="text-center">Envio de Arquivos</h3>
																					</div>
																				</div>
																			<?php if($form['atendimento'] == "1º Atendimento"): ?>
																				<?php if($form['arq_doc_foto'] == ""): ?>
																				<div class="row">
																					<div class="col-sm-12">
																						<div class="form-group">
																							<label for="arq_doc_foto" class="form-label">Documento Oficial com Foto</label>
																							<input type="file" class="form-control" accept=".pdf" id="arq_doc_foto" name="arq_doc_foto" required>
																						</div>
																					</div>
																				</div>
																				<?php endif ?>
																				
																				<?php if($form['arq_cartao_sus'] == ""): ?>
																				<div class="row">
																					<div class="col-sm-12">
																						<div class="form-group">
																							<label for="arq_cartao_sus" class="form-label">Cartão do SUS</label>
																							<input type="file" class="form-control" accept=".pdf" id="arq_cartao_sus" name="arq_cartao_sus" required>
																						</div>
																					</div>
																				</div>
																				<?php endif ?>
					
																				<?php if($form['arq_enc_medico'] == ""): ?>
																				<div class="row">
																					<div class="col-sm-12">
																						<div class="form-group">
																							<label for="arq_enc_medico" class="form-label">Encaminhamento Médico</label>
																							<input type="file" class="form-control" accept=".pdf" id="arq_enc_medico" name="arq_enc_medico" required>
																						</div>
																					</div>
																				</div>
																				<?php endif ?>
																				
																				<?php if($form['arq_doc_med_comp'] == ""): ?>
																				<div class="row">
																					<div class="col-sm-12">
																						<div class="form-group">
																							<label for="arq_doc_med_comp" class="form-label">Documento Médico Comprobatório</label>
																							<input type="file" class="form-control" accept=".pdf" id="arq_doc_med_comp" name="arq_doc_med_comp" required>
																						</div>
																					</div>
																				</div>
																				<?php endif ?>
					
																				<div class="row">
																					<div class="col-sm-12">
																						<hr>
																						<button class="btn btn-enviar btn-light" id="prosseguir" name="prosseguir" type="submit" value="<?= $form['id'] ?>">Prosseguir</button>
																					</div>
																				</div>
																			</form>
																			
																		<?php elseif($form['atendimento'] == "Retorno"): ?>
																				<?php if($form['arq_cartao_consulta_frente'] == ""): ?>
																				<div class="row">
																					<div class="col-sm-12">
																						<div class="form-group">
																							<label for="arq_cartao_consulta_frente" class="form-label">Frente do Cartão de Consulta</label>
																							<input type="file" class="form-control" accept=".pdf" id="arq_cartao_consulta_frente" name="arq_cartao_consulta_frente" required>
																						</div>
																					</div>
																				</div>
																				<?php endif ?>
					
																				<?php if($form['arq_cartao_consulta_verso'] == ""): ?>
																				<div class="row">
																					<div class="col-sm-12">
																						<div class="form-group">
																							<label for="arq_cartao_consulta_verso" class="form-label">Verso do Cartão de Consulta</label>
																							<input type="file" class="form-control" accept=".pdf" id="arq_cartao_consulta_verso" name="arq_cartao_consulta_verso" required>
																						</div>
																					</div>
																				</div>
																				<?php endif ?>
																				
																				<div class="row">
																					<div class="col-sm-12">
																						<hr>
																						<button class="btn btn-enviar btn-light" id="prosseguir" name="prosseguir" type="submit" value="<?= $form['id'] ?>">Prosseguir</button>
																					</div>
																				</div>
																			</form>
					
																		<?php elseif($form['atendimento'] == "Pós Operatório"): ?>
																				<?php if($form['arq_doc_pos_operatorio'] == ""): ?>
																				<div class="row">
																					<div class="col-sm-12">
																						<div class="form-group">
																							<label for="arq_doc_pos_operatorio" class="form-label">Documento Pós Operatório</label>
																							<input type="file" class="form-control" accept=".pdf" id="arq_doc_pos_operatorio" name="arq_doc_pos_operatorio" required>
																						</div>
																					</div>
																				</div>
																				<?php endif ?>
																				
																				<div class="row">
																					<div class="col-sm-12">
																						<hr>
																						<button class="btn btn-enviar btn-light" id="prosseguir" name="prosseguir" type="submit" value="<?= $form['id'] ?>">Prosseguir</button>
																					</div>
																				</div>
																			</form>
																		<?php endif; endif; ?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
							</table>
							<br>
						<?php endforeach; endif; else: ?>
							<form action="consultar" method="post">
								<div class="row">
									<div class="col-sm-12">
										<h3>Consultar Agendamento</h3>
										<hr>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label for="consulta" class="form-label"><b>Informe o número do seu protocolo ou o seu CPF</b></label>
											<input type="text" class="form-control consulta" id="consulta" name="consulta" maxlength=14 required>
										</div>
									</div>
								</div>

								<button class="btn btn-enviar btn-light" type="submit" id="consultar" name="consultar">Consultar</button>
							</form>
                    	<?php endif ?>
                    </div>
                </div>

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