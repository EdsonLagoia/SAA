<?php
require_once "connection/conectar.php";
require_once "class/Acesso.class.php";

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

isset($_SESSION['nivel']) && $_SESSION['nivel'] != 3 ? header("location: admin"): "";
isset($_SESSION['nivel']) && $_SESSION['nivel'] == 3 ? header("location: recepcao"): "";

if(isset($_POST['entrar'])){Acesso::logar();}

?>

<!DOCTYPE html>
<html>
<head><?php require_once "head.php" ?></head>
<body>

<!-- INÍCION DO TOPO -->
<?php require_once "topo.php" ?>
<!-- FIM DO TOPO -->



<!-- INÍCIO DO CONTEÚDO -->

<form action="" method="post">
    <div class="content">
        <div class="main col-sm-12" data-root>
            <div class="container">
                <div class="page">
                    <?php if (isset($_COOKIE['email']) || isset($_COOKIE['senha'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="notifications">
                            <?= isset($_COOKIE['email']) ? "<strong></strong> Email não encontrado!" : "" ?>
                            <?= isset($_COOKIE['senha']) ? "<strong>Falha na Autenticação!</strong> Senha incorreta!" : "" ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-sm-4">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" id="email"
                            value="<?= isset($_COOKIE['senha']) ? $_COOKIE['senha'] : "" ?>" required>
                        </div>

                        <div class="col-sm-4">
                            <label for="senha">Senha:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="senha" id="senha" aria-describedby="showPassword" required>
                                <input type="button" class="input-group-text" id="showPassword" value="Show" style="border: none" /></span>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label for=""></label>
                            <button class="btn btn-enviar btn-light" type="submit" name="entrar" id="entrar">Entrar</button>
                        </div>
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

<!-- INÍCIO DOS SCRIPTS -->
<?php require_once "scripts.php" ?>
<!-- INÍCIO DOS SCRIPTS -->

</body>
</html>