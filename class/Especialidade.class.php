<?php

class Especialidade{
    public static function adicionar() {
        $especialidade = trim($_POST['especialidade']);
        $verificar = R::findAll("especialidades", "especialidade = '$especialidade'");
        if ($verificar) {
            setcookie('specialty_fail', 'ok', (time() + 3));
            setcookie('specialtyadd_fail', 'ok', (time() + 3));
            header("Location: admin");

        } else {
            $add = R::dispense('especialidades');
            $add->especialidade = $especialidade;
            R::store($add);

            setcookie('specialty', "ok", (time() + 3));
            setcookie('specialtyadd', "ok", (time() + 3));
            header("Location:admin");
        }
    }

    public static function atualizar() {
        $especialidade = trim($_POST['especialidade']);
        $verificar = R::findAll("especialidades", "especialidade = '$especialidade' AND id <> $_POST[updspecialty]");
        if ($verificar) {
            setcookie('specialty_fail', 'ok', (time() + 3));
            setcookie('specialtyupd_fail', 'ok', (time() + 3));
            header("Location: admin");

        } else {
            $upd = R::dispense('especialidades');
            $upd->id            = $_POST['updspecialty'];
            $upd->especialidade = $especialidade;
            R::store($upd);

            setcookie('specialty', "ok", (time() + 3));
            setcookie('specialtyupd', "ok", (time() + 3));
            header("Location:admin");
        }
    }

    public static function deletar(){
        $del = R::findOne('especialidades', "id = $_POST[delspecialty]");
		R::trash($del);
        
        setcookie('specialty', "ok", (time() + 3));
        setcookie('specialtydel', 'ok', (time() + 3));
        header("Location:admin");
    }

}