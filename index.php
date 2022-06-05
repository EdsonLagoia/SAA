<?php

require_once "connection/conectar.php";

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

?>

<!DOCTYPE html>
<html>
<head><?php require_once "head.php" ?></head>
<body>

<!-- INÍCIO DO TOPO -->
<?php require_once "topo.php" ?>
<!-- Fim DO TOPO -->


<!-- INÍCIO DO CONTEÚDO -->
<div class="content">
    <div class="main" data-root>
        <div data-page>
            <div class="text-center shadow-box"><img src="img/logo.png" class="img-responsive" width="50%" alt="">
                <div class="main-title">Deseja realizar um agendamento? Clique abaixo e marque um horário.</div>
            </div>

            <div class="main-button">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-primary main-button container-fluid" data-bs-toggle="modal" data-bs-target="#novo">
                            <span class="-icon"><i class="fa fa-address-book"></i></span>
                            <span-label>Realizar Agendamento</span-label>
                        </button>
                    </div>

                    <div class="col-sm-6">
                        <a href="consultar" data-route="consultar" class="btn btn-success main-button container-fluid">
                            <span class="-icon"><i class="fa fa-search"></i></span>
                            <span-label>Consultar Protocolo</span-label>
                        </a>
                    </div>

                    <div class="col-sm-12" id="login">
                        <a href="login" data-route="login" class="btn btn-login main-button container-fluid">
                            <span class="-icon"><i class="fas fa-user"></i></span>
                            <span-label>Administração</span-label>
                        </a>
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