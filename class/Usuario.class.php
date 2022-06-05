<?php

class Usuario{
    public static function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){
        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
        $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
        $nu = "0123456789"; // $nu contem os números
        $si = "!@#$%&*()_-+="; // $si contem os símbolos
        $senha = "";
      
        if ($maiusculas){
              $senha .= str_shuffle($ma);
        }
      
        if ($minusculas){
            $senha .= str_shuffle($mi);
        }
    
        if ($numeros){
            $senha .= str_shuffle($nu);
        }
    
        if ($simbolos){
            $senha .= str_shuffle($si);
        }
        return substr(str_shuffle($senha),0,$tamanho);
    }

    public static function adicionar() {
        $verificar = R::findAll("usuarios", "email = '$_POST[email]'");
        if ($verificar) {
            setcookie('user_fail', 'ok', (time() + 3));
            setcookie('useradd_fail', 'ok', (time() + 3));
            header("Location: admin");

        } else {
            $senha = Usuario::gerar_senha(10, true, true, true, true);
            switch($_POST['funcao']){
                case 1:
                    $funcao = 'Administração - SESA';
                    break;
                case 2:
                    $funcao = 'Administração - UNACON';
                    break;
                case 3:
                    $funcao = 'Recepção';
                    break;
            }
            $add = R::dispense('usuarios');
            $add->nome          = $_POST['nome'];
            $add->funcao        = $funcao;
            $add->email         = $_POST['email'];
            $add->nivel         = $_POST['funcao'];
            $add->senha         = trim(password_hash($senha, PASSWORD_DEFAULT));
			$add->ativo		  	= 1;
            R::store($add);

            setcookie('user', "ok", (time() + 3));
            setcookie('useradd', "$senha", (time() + 3));
            header("Location:admin");
        }
    }

    public static function atualizar() {
        $verificar = R::findAll("usuarios", "email = '$_POST[email]' AND id <> $_POST[upduser]");
        if ($verificar) {
            setcookie('user_fail', 'ok', (time() + 3));
            setcookie('userupd_fail', 'ok', (time() + 3));
            header("Location: admin");

        } else {
            switch($_POST['funcao']){
                case 1:
                    $funcao = 'Administração - SESA';
                    break;
                case 2:
                    $funcao = 'Administração - UNACON';
                    break;
                case 3:
                    $funcao = 'Recepção';
                    break;
            }
            $upd = R::dispense('usuarios');
            $upd->id            = $_POST['upduser'];
            $upd->nome          = $_POST['nome'];
            $upd->funcao        = $funcao;
            $upd->email         = $_POST['email'];
            $upd->nivel         = $_POST['funcao'];
			$upd->ativo		  	= 1;
            R::store($upd);

            setcookie('user', "ok", (time() + 3));
            setcookie('userupd', "ok", (time() + 3));
            header("Location:admin");
        }
    }

    public static function pass() {
        $senha = Usuario::gerar_senha(10, true, true, true, true);
        $pass = R::dispense('usuarios');
        $pass->id         = $_POST['pass'];
        $pass->senha      = trim(password_hash($senha, PASSWORD_DEFAULT));
        R::store($pass);
        
        setcookie('user', "ok", (time() + 3));
        setcookie('userpass', "$senha", (time() + 3));
        header("Location:admin");
    }

    
    public static function deletar(){
        $del = R::findOne('usuarios', "id = $_POST[deluser]");
		R::trash($del);
        
        setcookie('user', "ok", (time() + 3));
        setcookie('userdel', 'ok', (time() + 3));
        header("Location:admin");
    }

}