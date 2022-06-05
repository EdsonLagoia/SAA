<nav class="navbar-unacon">
    <a class="-brand -title" href="./" data-route="index">UNACON - AGENDAMENTO AMBULATORIAL</a>

    <div class="-spacer"></div>
    
    <button type="button" class="-link" data-bs-toggle="modal" data-bs-target="#novo" style="border: none; color: white;">
        NOVO AGENDAMENTO
    </button>
    <a class="-link" href="consultar">CONSULTAR PROTOCOLO</a>
    <a class="-link" href="login">ADMINISTRAÇÃO</a>
</nav>

<div class="modal fade" id="novo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="novoLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novoLabel">Qual o Tipo de Agendamento?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="novo" method="post">
                            <button type="submit" class="btn btn-secondary container-fluid" id="pratendimento" name="pratendimento"><b>1º Atendimento</b></button>
                        </form>
                        <br>
                    </div>
                    <div class="col-sm-12">
                        <form action="novo" method="post">
                            <button type="submit" class="btn btn-secondary container-fluid" id="retorno" name="retorno"><b>Retorno</b></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>