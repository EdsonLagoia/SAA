<?php
require_once "connection/conectar.php";
require_once "class/Formulario.class.php";

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

if(isset($_POST['prosseguir'])){Formulario::abrir();}
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
                <a href="./" data-route="index" class="btn btn-light">&laquo; Voltar</a>
            </div>

            <div class="page">
                <?php if (isset($_COOKIE['erro'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="notifications">
                        <strong>Falha no envio do formulário!</strong> <?= $_COOKIE['erro'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>
                
                <?php if(isset($_POST['pratendimento']) || isset($_POST['retorno']) || isset($_POST['posoperatorio']) || isset($_COOKIE['erro'])): ?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3>Por favor preencha os campos abaixo.</h3>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="especialidade" class="form-label">Especialidade</label>
                                    <select class="form-select" name="especialidade" id="especialidade" required>
                                        <option value="">Selecione a especialidade</option>
                                        <?php
                                            $especialidades = R::findAll("especialidades");
                                            foreach ($especialidades as $esp):
                                        ?>
                                        <option value="<?= $esp['id'] ?>"><?= $esp['especialidade'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php if(isset($_POST['retorno']) || isset($_POST['posoperatorio'])): ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="data_retorno" class="form-label">Data da Última Consulta</label>
                                        <input type="date" class="form-control" id="data_retorno" name="data_retorno" min="<?= date('Y-m-d', strtotime('-1 years', strtotime(date('Y-m-d')))) ?>" max="<?= date('Y-m-d') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-sm-5">
                                    <label for="tempo_retorno" class="form-label">Tempo para Retorno</label>
                                    <div class="row" id="tempo_retorno">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <input type="number" class="form-control" id="tempo" name="tempo" min='1' required>
                                            </div>
                                        </div>

                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <select class="form-select" name="periodo" id="periodo" required>
                                                    <option value="Dia(as)">Dia(as)</option>
                                                    <option value="Semana(as)">Semana(as)</option>
                                                    <option value="Mês(es)">Mês(es)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prontuario" class="form-label">Prontuário</label>
                                        <input type="text" class="form-control" id="prontuario" name="prontuario" required>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="<?= isset($_POST['retorno']) ? "col-sm-12" : "col-sm-8" ?>">
                                    <div class="form-group">
                                        <label for="medico" class="form-label">Médico da Consulta Anterior</label>
                                        <select class="form-select" name="medico" id="medico" required>
                                            <option value="" selected>Selecione o médico</option>
                                        </select>
                                    </div>
                                </div>

                                <?php if(isset($_POST['posoperatorio'])): ?>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="data_cirurgia" class="form-label">Data da Cirurgia</label>
                                        <input type="date" class="form-control" id="data_cirurgia" name="data_cirurgia" min="<?= date('Y-m-d', strtotime('-1 years', strtotime(date('Y-m-d')))) ?>" max="<?= date('Y-m-d') ?>" required>
                                    </div>
                                </div>
                                <?php endif ?>
                            </div>
                        <?php endif ?>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nome_social" class="form-label">Nome Social</label>
                                    <input type="text" class="form-control" id="nome_social" name="nome_social" maxlength="255">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="<?= isset($_POST['pratendimento']) ? "col-sm-3" : "col-sm-4" ?>">
                                <div class="form-group">
                                    <label for="cpf" class="form-label">CPF <span id="validador"></span></label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" minlength="14" maxlength="14" onkeyup="cpfCheck(this)" onkeydown="javascript: fMasc( this, mCPF );" required>
                                </div>
                            </div>

                            <div class="<?= isset($_POST['pratendimento']) ? "col-sm-3" : "col-sm-4" ?>">
                                <div class="form-group">
                                    <label for="data_nascimento" class="form-label">Data Nascimento</label>
                                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" max="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>

                            <div class="<?= isset($_POST['pratendimento']) ? "col-sm-3" : "col-sm-4" ?>">
                                <label class="form-label" for="sexo">Sexo</label>
                                <div class="form-group" id="sexo">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sexo" id="masc" value="1" required>
                                        <label class="form-check-label" for="masc"><?= isset($_POST['pratendimento']) ? "Masc " : "Masculino " ?></label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sexo" id="fem" value="0" required>
                                        <label class="form-check-label" for="fem"><?= isset($_POST['pratendimento']) ? "Fem" : "Feminino" ?></label>
                                    </div>
                                </div>
                            </div>

                            <?php if(isset($_POST['pratendimento'])): ?>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prontuario" class="form-label">Prontuário</label>
                                        <input type="text" class="form-control" id="prontuario" name="prontuario">
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="cartao_sus" class="form-label">Número do Cartão do SUS</label>
                                    <input type="text" class="form-control" id="cartao_sus" name="cartao_sus" minlength="18" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="rg" class="form-label">RG</label>
                                    <input type="text" class="form-control" id="rg" name="rg" minlength="6" maxlength="15" required>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="telefone" class="form-label">Telefone <i class="fab fa-whatsapp"></i></label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" minlength="16" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" maxlength="10" required>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="logradouro" class="form-label">Logradouro</label>
                                    <input type="text" class="form-control" id="logradouro" name="logradouro" maxlength="255" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero" maxlength="10" required>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="bairro" class="form-label">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" maxlength="50" required>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="municipio" class="form-label">Município</label>
                                    <select class="form-select" name="municipio" id="municipio" required>
                                        <option value="" selected>Selecione o seu município</option>
                                        <option value="Amapá">Amapá</option>
                                        <option value="Calçoene">Calçoene</option>
                                        <option value="Cutias">Cutias</option>
                                        <option value="Ferreira Gomes">Ferreira Gomes</option>
                                        <option value="Itaubal">Itaubal</option>
                                        <option value="Laranjal do Jari">Laranjal do Jari</option>
                                        <option value="Macapá">Macapá</option>
                                        <option value="Mazagão">Mazagão</option>
                                        <option value="Oiapoque">Oiapoque</option>
                                        <option value="Pedra Branca do Amapari">Pedra Branca do Amapari</option>
                                        <option value="Porto Grande">Porto Grande</option>
                                        <option value="Pracuuba">Pracuuba</option>
                                        <option value="Serra do Navio">Serra do Navio</option>
                                        <option value="Santana">Santana</option>
                                        <option value="Tartarugalzinho">Tartarugalzinho</option>
                                        <option value="Vitória do Jari">Vitória do Jari</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <?php if(!isset($_SESSION['id_user'])): ?>
                            <?php if(isset($_POST['pratendimento'])): ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="arq_doc_foto" class="form-label">Documento Oficial com Foto</label>
                                            <input type="file" class="form-control" accept=".pdf" id="arq_doc_foto" name="arq_doc_foto" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="arq_doc_foto_opc" class="form-label">Em caso de documento de frente e verso, anexe o verso aqui</label>
                                            <input type="file" class="form-control" accept=".pdf" id="arq_doc_foto_opc" name="arq_doc_foto_opc">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="arq_cartao_sus" class="form-label">Cartão do SUS</label>
                                            <input type="file" class="form-control" accept=".pdf" id="arq_cartao_sus" name="arq_cartao_sus" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="arq_enc_medico" class="form-label">Encaminhamento Médico</label>
                                            <input type="file" class="form-control" accept=".pdf" id="arq_enc_medico" name="arq_enc_medico" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="arq_doc_med_comp" class="form-label">Documento Médico Comprobatório</label>
                                            <input type="file" class="form-control" accept=".pdf" id="arq_doc_med_comp" name="arq_doc_med_comp" required>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif(isset($_POST['retorno'])): ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="arq_cartao_consulta_frente" class="form-label">Frente do Cartão de Consulta</label>
                                            <input type="file" class="form-control" accept=".pdf" id="arq_cartao_consulta_frente" name="arq_cartao_consulta_frente" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="arq_cartao_consulta_verso" class="form-label">Verso do Cartão de Consulta</label>
                                            <input type="file" class="form-control" accept=".pdf" id="arq_cartao_consulta_verso" name="arq_cartao_consulta_verso" required>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endif ?>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="autorizar" id="autorizar" onchange="habProc()" value="1" required>
                                        <label class="form-check-label" for="autorizar">Eu autorizo o uso dos meus dados conforme a <a href="http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm" target="_blank">Lei 13.709/2018</a> para fins de agendamento ambulatorial</label>
                                    </div>
                                </div>
                                <?php if(isset($_POST['pratendimento'])): ?>
                                    <button type="submit" class="btn btn-enviar btn-light" id="prosseguir" name="prosseguir" value="1º Atendimento" disabled>Prosseguir</button>
                                <?php elseif(isset($_POST['retorno'])): ?>
                                    <button type="submit" class="btn btn-enviar btn-light" id="prosseguir" name="prosseguir" value="Retorno" disabled>Prosseguir</button>
                                <?php elseif(isset($_POST['posoperatorio'])): ?>
                                    <button type="submit" class="btn btn-enviar btn-light" id="prosseguir" name="prosseguir" value="Pós Operatório" disabled>Prosseguir</button>
                                <?php endif ?>
                            </div>
                        </div>
                    </form>
                <?php 
                    else:
                        echo "<br><p class='text-center' style='font-size: 15pt'>Selecione o tipo de agendamento.</p>";
                    endif;
                ?>
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