<?php

class Medico{
    public static function adicionar() {
        $medico = trim($_POST['medico']);
        $verificar = R::findAll("medicos", "medico = '$medico'");
        if ($verificar) {
            setcookie('doctor_fail', 'ok', (time() + 3));
            setcookie('doctoradd_fail', 'ok', (time() + 3));
            header("Location: admin");

        } else {
            $add = R::dispense('medicos');
            $add->medico        = $medico;
            $add->especialidade = $_POST['especialidade'];
            R::store($add);

            setcookie('doctor', "ok", (time() + 3));
            setcookie('doctoradd', "ok", (time() + 3));
            header("Location:admin");
        }
    }

    public static function atualizar() {
        $medico = trim($_POST['medico']);
        $verificar = R::findAll("medicos", "medico = '$medico' AND id <> $_POST[upddoctor]");
        if ($verificar) {
            setcookie('doctor_fail', 'ok', (time() + 3));
            setcookie('doctorupd_fail', 'ok', (time() + 3));
            header("Location: admin");

        } else {
            $upd = R::dispense('medicos');
            $upd->id            = $_POST['upddoctor'];
            $upd->medico        = $medico;
            $upd->especialidade = $_POST['especialidade'];
            R::store($upd);

            setcookie('doctor', "ok", (time() + 3));
            setcookie('doctorupd', "ok", (time() + 3));
            header("Location:admin");
        }
    }

    public static function deletar(){
        $del = R::findOne('medicos', "id = $_POST[deldoctor]");
		R::trash($del);
        
        setcookie('doctor', "ok", (time() + 3));
        setcookie('doctordel', 'ok', (time() + 3));
        header("Location:admin");
    }

}