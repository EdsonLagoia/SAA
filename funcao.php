<?php
require_once "connection/conectar.php";

if(isset($_GET['especialidade'])):
	$medicos = R::findAll("medicos", "especialidade = $_GET[especialidade]");
?>
		<option value="" selected>Selecione o médico</option>
		<?php if(count($medicos) > 0):
			foreach($medicos as $med):
		?>
		<option value="<?= $med['id'] ?>"><?= $med['medico'] ?></option>
		<?php endforeach ?>
</div>
<?php endif; endif; ?>