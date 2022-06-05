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
<!-- FIM DO TOPO -->

<!-- INÍCIO DO CONTEÚDO -->
<div class="content">
    <div class="main" data-root>
        <div class="container" data-page>
            <div class="voltar">
                <a href="./" data-route="./" class="btn btn-light">&laquo; Voltar</a>
            </div>

            <div class="page">
                <div class="row">
                    <div class="col-sm-12">
                        <?php if (isset($_COOKIE['sucesso']) || isset($_POST['protocolo'])): ?>
                        <div class="cadastro-resultado">
                            <div class="-title">Seu envio foi realizado com sucesso.</div>
                            <div class="-subtitle">Agora é só aguardar por sua resposta.</div>
                            <hr>
                            <div class="-desc">
                                <div class="-items">
                                    A resposta estará disponível consultando a página "<a href="consultar" target="_blank">Consultar Protocolo</a>" disponível no nosso site.
                                    <br>
                                    <div class="-protocolo">
                                        Código do protocolo:
                                        <span class="-value"><b><?= $_COOKIE['sucesso'] ?></b></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                            Página inválida. Clique <a href="./">aqui</a> para retornar ao início.
                        <?php endif; ?>
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