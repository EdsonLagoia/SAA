<?php
require_once "connection/conectar.php";
require_once "class/Acesso.class.php";
require_once "class/Usuario.class.php";
require_once "class/Medico.class.php";
require_once "class/Especialidade.class.php";
//require_once "class/Formulario.class.php";

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

// Acesso
//Acesso::verificar();
if(isset($_POST['sair'])){Acesso::logout();}
!isset($_SESSION['nivel']) ? header("location: login") : "";
isset($_SESSION['nivel']) && $_SESSION['nivel'] == 3 ? header("location: recepcao") : "";

// Usuário
if(isset($_POST['adduser'])){Usuario::adicionar();}
if(isset($_POST['edituser'])){$upduser = R::findOne("usuarios", "id = $_POST[edituser]");}
if(isset($_POST['upduser'])){Usuario::atualizar();}
if(isset($_POST['pass'])){Usuario::pass();}
if(isset($_POST['deluser'])){Usuario::deletar();}

// Médico
if(isset($_POST['adddoctor'])){Medico::adicionar();}
if(isset($_POST['editdoctor'])){$upddoctor = R::findOne("medicos", "id = $_POST[editdoctor]");}
if(isset($_POST['upddoctor'])){Medico::atualizar();}
if(isset($_POST['deldoctor'])){Medico::deletar();}

// Especialidade
if(isset($_POST['addspecialty'])){Especialidade::adicionar();}
if(isset($_POST['editspecialty'])){$updspecialty = R::findOne("especialidades", "id = $_POST[editspecialty]");}
if(isset($_POST['updspecialty'])){Especialidade::atualizar();}
if(isset($_POST['delspecialty'])){Especialidade::deletar();}


if(isset($_POST['cancelar'])){Formulario::cancelar();}

$act = array(isset($_COOKIE['user']), isset($_COOKIE['user_fail']), isset($_POST['edituser']),
            isset($_COOKIE['doctor']), isset($_COOKIE['doctor_fail']), isset($_POST['editdoctor']),
            isset($_COOKIE['specialty']), isset($_COOKIE['specialty_fail']), isset($_POST['editspecialty']));
$ativo = !$act[0] && !$act[1] && !$act[2] && !$act[3] && !$act[4] &&
         !$act[5] && !$act[6] && !$act[7] && !$act[8] ? TRUE : FALSE;

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
                        <h3 style="margin-top:0; margin-bottom:20px;"><?= $_SESSION['nome'] ?></h3>
                    </div>

                    <div id="main">
                        <ul class="nav nav-tabs" id="menu" role="tablist">
                            <?php if($_SESSION['nivel'] == 1): ?>
                            <li class="nav-item">
                                <button class="nav-link <?= $act[0] || $act[1] || $act[2] || $ativo == TRUE ? "active" : "" ?>" id="funcionarios-tab" data-bs-toggle="tab" data-bs-target="#funcionarios" type="button" role="tab" aria-controls="funcionarios" aria-selected="true"><i class="fa-solid fa-user"></i> Funcionários</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link <?= $act[3] || $act[4] || $act[5] ? "active" : "" ?>" id="medicos-tab" data-bs-toggle="tab" data-bs-target="#medicos" type="button" role="tab" aria-controls="medicos" aria-selected="false"><i class="fa-solid fa-user-doctor"></i> Médicos</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link <?= $act[6] || $act[7] || $act[8] ? "active" : "" ?>" id="especialidades-tab" data-bs-toggle="tab" data-bs-target="#especialidades" type="button" role="tab" aria-controls="especialidades" aria-selected="false"><i class="fa-solid fa-microscope"></i> Especialidades</button>
                            </li>
                            <?php endif ?>
                            <li class="nav-item">
                                <button class="nav-link <?= $_SESSION['nivel'] == 2 ? "active" : ""?>" id="formularios-tab" data-bs-toggle="tab" data-bs-target="#formularios" type="button" role="tab" aria-controls="formularios" aria-selected="false"><i class="fa-solid fa-file-medical"></i> Formulários</button>
                            </li>
							<li class="nav-item">
                                <button class="nav-link" id="agenda-medico-tab" data-bs-toggle="tab" data-bs-target="#agenda-medico" type="button" role="tab" aria-controls="agenda-medico" aria-selected="false"><i class="fa-solid fa-book-medical"></i> Agenda do Médico</button>
                            </li>
                        </ul>

                        <div class="tab-content">
                        <?php if($_SESSION['nivel'] == 1): ?>
                            <div class="tab-pane fade show <?= $act[0] || $act[1] || $act[2] || $ativo == TRUE ? "active" : "" ?>" id="funcionarios" role="tabpanel" aria-labelledby="funcionarios-tab">
                                <br>
                                <?php if (isset($_COOKIE['user']) || isset($_COOKIE['user_fail'])): ?>
                                    <div class="alert alert-<?= isset($_COOKIE['user']) ? "success" : "danger'" ?> alert-dismissible fade show" role="alert" <?= isset($_COOKIE['useradd']) || isset($_COOKIE['userpass']) ? "" : "id='notifications'" ?>>
                                        <?= isset($_COOKIE['useradd']) ? "<strong>Usuário cadastrado com sucesso! Sua senha é: " . $_COOKIE['useradd'] . "</strong>" : "" ?>
                                        <?= isset($_COOKIE['useradd_fail']) ? "<strong>Usuário já cadastrado!</strong>" : "" ?>
                                        <?= isset($_COOKIE['userupd']) ? "<strong>Usuário atualizado com sucesso!</strong>" : "" ?>
                                        <?= isset($_COOKIE['userupd_fail']) ? "<strong>Email já cadastrado!</strong>" : "" ?>
                                        <?= isset($_COOKIE['userdel']) ? "<strong>Usuário deletado com sucesso!</strong>" : "" ?>
                                        <?= isset($_COOKIE['userpass']) ? "<strong>Senha alterada com sucesso! Sua nova senha é: " . $_COOKIE['userpass'] . "</strong>" : "" ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif ?>
                                
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4><?= isset($_POST['edituser']) ? "Atualizar" : "Cadastrar" ?> Funcionários</h4>
                                            <hr>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="nome" class="form-label">Nome</label>
                                                <input type="text" class="form-control" id="nome" name="nome" maxlength="255" value="<?= isset($_POST['edituser']) ? $upduser['nome'] : "" ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" maxlength="150" value="<?= isset($_POST['edituser']) ? $upduser['email'] : "" ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="funcao" class="form-label">Função</label>
                                                <select class="form-select" name="funcao" id="funcao" required>
                                                    <option value="">Selecione a função</option>
                                                    <option value="1" <?= isset($_POST['edituser']) && $upduser['funcao'] == "Administração - SESA" ? "selected" : "" ?>>Administração - SESA</option>
                                                    <option value="2" <?= isset($_POST['edituser']) && $upduser['funcao'] == "Administração - UNACON" ? "selected" : "" ?>>Administração - UNACON</option>
                                                    <option value="3" <?= isset($_POST['edituser']) && $upduser['funcao'] == "Recepção" ? "selected" : "" ?>>Recepção</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="<?= isset($_POST['edituser']) ? "upduser" : "adduser" ?>"></label>
                                            <button class="btn btn-enviar btn-light" id="<?= isset($_POST['edituser']) ? "upduser" : "adduser" ?>" name="<?= isset($_POST['edituser']) ? "upduser" : "adduser" ?>" type="submit" value="<?= isset($_POST['edituser']) ? $_POST['edituser'] : "" ?>"><?= isset($_POST['edituser']) ? "Atualizar" : "Cadastrar" ?></button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <table class="main-table">
                                    <thead>
                                        <th width=5%>ID</th>
                                        <th width=30%>Nome</th>
                                        <th width=20%>Função</th>
                                        <th width=25%>Email</th>
                                        <th width=20%>Ações</th>
                                    </thead>

                                    <tbody>
                                        <?php
                                            $usuarios = R::findAll("usuarios", "ativo = 1");
                                            foreach($usuarios as $user):
                                        ?>
                                        <tr>
                                            <td width=5%><?= $user['id'] ?></td>
                                            <td width=30%><?= $user['nome'] ?></td>
                                            <td width=20%><?= $user['funcao'] ?></td>
                                            <td width=25%><?= $user['email'] ?></td>
                                            <td width=20%>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <form method="post">
                                                            <button type="submit" class="btn btn-info col-sm-10" id="edituser" name="edituser" title="Editar Usuário" value="<?= $user['id'] ?>"><i class="fa-solid fa-user-pen"></i></button>
                                                        </form>
                                                    </div>
                                                    
                                                    <div class="col-sm-4">
                                                        <form method="post">
                                                            <button type="submit" class="btn btn-danger col-sm-10" id="deluser" name="deluser" title="Desativar Usuário" value="<?= $user['id'] ?>"><i class="fa-solid fa-user-xmark"></i></button>
                                                        </form>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <form method="post">
                                                            <button type="submit" class="btn btn-warning col-sm-10" id="pass" name="pass" title="Redefinir Senha" value="<?= $user['id'] ?>"><i class="fa-solid fa-user-shield"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade show <?= $act[3] || $act[4] || $act[5] ? "active" : "" ?>" id="medicos" role="tabpanel" aria-labelledby="medicos-tab">
                                <br>
                                <?php if (isset($_COOKIE['doctor']) || isset($_COOKIE['doctor_fail'])): ?>
                                    <div class="alert alert-<?= isset($_COOKIE['doctor']) ? "success" : "danger" ?> alert-dismissible fade show" role="alert" id="notifications">
                                        <?= isset($_COOKIE['doctoradd']) ? "<strong>Médico cadastrado com sucesso!</strong>" : "" ?>
                                        <?= isset($_COOKIE['doctoradd_fail']) || isset($_COOKIE['doctorupd_fail']) ? "<strong>Médico já cadastrado!</strong>" : "" ?>
                                        <?= isset($_COOKIE['doctorupd']) ? "<strong>Médico atualizado com sucesso!</strong>" : "" ?>
                                        <?= isset($_COOKIE['doctordel']) ? "<strong>Médico deletado com sucesso!</strong>" : "" ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif ?>
                                
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4><?= isset($_POST['editar']) ? "Atualizar" : "Cadastrar" ?> Médicos</h4>
                                            <hr>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="medico" class="form-label">Médico</label>
                                                <input type="text" class="form-control" id="medico" name="medico" maxlength="255" value="<?= isset($_POST['editdoctor']) ? $upddoctor['medico'] : "" ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="especialidade" class="form-label">Especialidade</label>
                                                <select class="form-select" name="especialidade" id="especialidade" required>
                                                    <option value="">Selecione a especialidade</option>
                                                    <?php
                                                        $especialidades = R::findAll("especialidades");
                                                        foreach ($especialidades as $esp):
                                                    ?>
                                                    <option value="<?= $esp['id'] ?>" <?= isset($_POST['editdoctor']) && $upddoctor['especialidade'] == $esp['id'] ? "selected" : "" ?>><?= $esp['especialidade'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">   
                                            <label for="<?= isset($_POST['editar']) ? "upddoctor" : "adddoctor" ?>"></label>
                                            <button class="btn btn-enviar btn-light" id="<?= isset($_POST['editdoctor']) ? "upddoctor" : "adddoctor" ?>" name="<?= isset($_POST['editdoctor']) ? "upddoctor" : "adddoctor" ?>" type="submit" value="<?= isset($_POST['editdoctor']) ? $_POST['editdoctor'] : "" ?>"><?= isset($_POST['editdoctor']) ? "Atualizar" : "Cadastrar" ?></button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <table class="main-table">
                                    <thead>
                                        <th width=5%>ID</th>
                                        <th width=40%>Médico</th>
                                        <th width=40%>Especialidade</th>
                                        <th width=20%>Ações</th>
                                    </thead>

                                    <tbody>
                                        <?php
                                            $medicos = R::getAll("SELECT medicos.id, medicos.medico, especialidades.especialidade FROM medicos INNER JOIN especialidades ON medicos.especialidade = especialidades.id");
                                            foreach($medicos as $med):
                                        ?>
                                        <tr>
                                            <td width=5%><?= $med['id'] ?></td>
                                            <td width=40%><?= $med['medico'] ?></td>
                                            <td width=40%><?= $med['especialidade'] ?></td>
                                            <td width=20%>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <form method="post">
                                                            <button type="submit" class="btn btn-info col-sm-10" id="editdoctor" name="editdoctor" title="Editar Médico" value="<?= $med['id'] ?>"><i class="fa-solid fa-user-edit"></i></button>
                                                        </form>
                                                    </div>
                                                    
                                                    <div class="col-sm-6">
                                                        <form method="post">
                                                            <button type="submit" class="btn btn-danger col-sm-10" id="deldoctor" name="deldoctor" title="Deletar Médico" value="<?= $med['id'] ?>"><i class="fa-solid fa-user-times"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade show <?= $act[6] || $act[7] || $act[8] ? "active" : "" ?>" id="especialidades" role="tabpanel" aria-labelledby="especialidades-tab">
                                <br>
                                <?php if (isset($_COOKIE['specialty']) || isset($_COOKIE['specialty_fail'])): ?>
                                    <div class="alert alert-<?= isset($_COOKIE['specialty']) ? "success" : "danger" ?> alert-dismissible fade show" role="alert" id="notifications">
                                        <?= isset($_COOKIE['specialtyadd']) ? "<strong>Especialidade cadastrada com sucesso!</strong>" : "" ?>
                                        <?= isset($_COOKIE['specialtyadd_fail']) || isset($_COOKIE['specialtyupd_fail']) ? "<strong>Especialidade já cadastrada!</strong>" : "" ?>
                                        <?= isset($_COOKIE['specialtyupd']) ? "<strong>Especialidade atualizada com sucesso!</strong>" : "" ?>
                                        <?= isset($_COOKIE['specialtydel']) ? "<strong>Especialidade deletada com sucesso!</strong>" : "" ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif ?>
                                
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4><?= isset($_POST['editar']) ? "Atualizar" : "Cadastrar" ?> Especialidades</h4>
                                            <hr>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="especialidade" class="form-label">Especialidade</label>
                                                <input type="text" class="form-control" id="especialidade" name="especialidade" maxlength="255" value="<?= isset($_POST['editspecialty']) ? $updspecialty['especialidade'] : "" ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">   
                                            <label for="<?= isset($_POST['editspecialty']) ? "updspecialty" : "addspecialty" ?>"></label>
                                            <button class="btn btn-enviar btn-light" id="<?= isset($_POST['editspecialty']) ? "updspecialty" : "addspecialty" ?>" name="<?= isset($_POST['editspecialty']) ? "updspecialty" : "addspecialty" ?>" type="submit" value="<?= isset($_POST['editspecialty']) ? $_POST['editspecialty'] : "" ?>"><?= isset($_POST['editspecialty']) ? "Atualizar" : "Cadastrar" ?></button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <table class="main-table">
                                    <thead>
                                        <th width=5%>ID</th>
                                        <th width=80%>Especialidade</th>
                                        <th width=20%>Ações</th>
                                    </thead>

                                    <tbody>
                                        <?php
                                            $especialidades = R::findAll("especialidades");
                                            foreach($especialidades as $esp):
                                        ?>
                                        <tr>
                                            <td width=5%><?= $esp['id'] ?></td>
                                            <td width=80%><?= $esp['especialidade'] ?></td>
                                            <td width=15%>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <form method="post">
                                                            <button type="submit" class="btn btn-info col-sm-10" id="editspecialty" name="editspecialty" title="Editar Especialidade" value="<?= $esp['id'] ?>"><i class="fa-solid fa-user-edit"></i></button>
                                                        </form>
                                                    </div>
                                                    
                                                    <div class="col-sm-6">
                                                        <form method="post">
                                                            <button type="submit" class="btn btn-danger col-sm-10" id="delspecialty" name="delspecialty" title="Deletar Especialidade" value="<?= $esp['id'] ?>"><i class="fa-solid fa-user-times"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif ?>

                            <div class="tab-pane fade show <?= $_SESSION['nivel'] == 2 ? "active" : ""?>" id="formularios" role="tabpanel" aria-labelledby="formularios-tab">
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
                                            $formularios = R::getAll("SELECT formularios.id, formularios.protocolo, formularios.nome, formularios.telefone, especialidades.especialidade FROM formularios INNER JOIN especialidades ON formularios.especialidade = especialidades.id");
                                            foreach($formularios as $form):
                                        ?>
                                        <tr>
                                            <td width=7%><?= $form['id'] ?></td>
                                            <td width=12%><?= $form['protocolo'] ?></td>
                                            <td width=20%><?= $form['especialidade'] ?></td>
                                            <td width=35%><?= $form['nome'] ?></td>
                                            <td width=15%><?= $form['telefone'] ?></td>
                                            <td width=6%>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <form action="paciente" method="post">
                                                            <button type="submit" class="btn bg-success col-sm-10" id="formulario" name="formulario" title="Visualizar" value="<?= $form['id'] ?>"><i class="fa-solid fa-eye"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
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
                                        <th width=93%>Médico</th>
                                        <th width=7%>Ações</th>
                                    </thead>

                                    <tbody>
                                        <?php
                                            $medicos = R::findAll("medicos");
                                            foreach($medicos as $med):
                                        ?>
                                        <tr>
                                            <td width=93%><?= $med['medico'] ?></td>
                                            <td width=7%>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <form action="agenda-medico" method="post">
                                                            <button type="submit" class="btn btn-warning col-sm-10" id="agenda" name="agenda" title="Visualizar Agenda" value="<?= $med['id'] ?>"><i class="fa-solid fa-calendar-check"></i></button>
                                                        </form>
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
                        <b>Email:</b> <?= $_SESSION['email'] ?>
                    </div>
                    <form action="" method="post" style="display: inline">
                        <button type="submit" class="btn btn-xs btn-logout" id="sair" name="sair">Sair</button>
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