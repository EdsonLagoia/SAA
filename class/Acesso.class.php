<?php

class Acesso{
    public static function logar(){

        $login = R::findOne('usuarios', "email = '$_POST[email]'");
        $senha = password_verify($_POST['senha'], $login['senha']);
        setcookie('login', "ok", (time() + 3));
        
        if(!$login){
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            setcookie('email', 'ok', (time() + 3));
            header("Location:login");
        } else if(!$senha){
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            setcookie('senha', "$_POST[email]", (time() + 3));
            header("Location:login");
        } else {
            $_SESSION["sessiontime"]   = time() + 300;
            $_SESSION['id_user']       = $login['id'];
            $_SESSION['nome']          = $login['nome'];
            $_SESSION['fucao']         = $login['funcao'];
            $_SESSION['email']         = $login['email'];
            $_SESSION['senha']         = $login['senha'];
            $_SESSION['nivel']         = $login['nivel'];
            header($login['nivel'] == 1 ? "Location:admin" : "Location:recepcao");
        }
    }

    public static function verificar(){
        if (!isset($_SESSION['email']) && !isset($_SESSION['senha'])) {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            session_destroy();
            header("Location:login");
            exit;
        }

        if (isset( $_SESSION["sessiontime"])) { 
            if ($_SESSION["sessiontime"] < time() && isset($_POST) != true) { 
                session_unset();
                header("Location:login");
            } else {
                $_SESSION["sessiontime"] = time() + 300;
            }
        } else { 
            session_unset();
            header("Location:login");
        }

    }

    public static function logout(){
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        session_destroy();
        header("Location:login");
        exit;
    }

}