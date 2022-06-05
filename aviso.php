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
<?php //require_once "topo.php" ?>
<!-- Fim DO TOPO -->


<!-- INÍCIO DO CONTEÚDO -->
<div class="content">
    <div class="main" data-root>
        <div data-page>
            <div class="text-center shadow-box">
                <div class="main-title">Site em Manutenção</div>
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