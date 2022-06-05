<?php

    require_once 'Arquivo.class.php';

    class Formulario{
        public static function protocolo(){
            $result = false;
            while ($result == false){
                $protocolo = rand(100000, 999999);
                $verify = R::count("formularios", "protocolo = $protocolo");
                if($verify == 0){
                    $result = true;
                }
            }
            return $protocolo;
        }

        public static function abrir(){
            $status = R::count("formularios", "especialidade = $_POST[especialidade] AND cpf = '$_POST[cpf]' AND status IN ('Em Análise','Arquivos Incorretos')");
            if($status > 0){
                setcookie("erro", "Você tem um formulário em andamento para essa Especialidade.", time()+3);
                header("Location: novo");
            }elseif($_POST['autorizar'] == 1 && $status == 0){
                $atendimentos = R::findOne("formularios", "cpf = '$_POST[cpf]' ORDER BY id DESC LIMIT 1");
                $protocolo = $atendimentos ? $atendimentos['protocolo'] : Formulario::protocolo();

                $abrir = R::dispense("formularios");
                $abrir->data_abertura                      = date("Y-m-d H:i:s");
                $abrir->protocolo                          = $protocolo;
                $abrir->autorizacao                        = $_POST['autorizar'];
                $abrir->atendimento           	           = $_POST["prosseguir"];
                $abrir->status                             = "Em Análise";
                $abrir->especialidade		               = $_POST["especialidade"];
                $abrir->nome                               = $_POST["nome"];
                $abrir->nome_social                        = $_POST["nome_social"];
                $abrir->prontuario                         = $_POST["prontuario"];
                $abrir->data_nascimento                    = $_POST["data_nascimento"];
                $abrir->sexo                               = $_POST["sexo"];
                $abrir->cpf                                = $_POST["cpf"];
                $abrir->rg                                 = $_POST["rg"];
                $abrir->cartao_sus                         = $_POST["cartao_sus"];
                $abrir->telefone                           = $_POST["telefone"];
                $abrir->cep                                = $_POST["cep"];
                $abrir->logradouro                         = $_POST["logradouro"];
                $abrir->bairro                             = $_POST["bairro"];
                $abrir->numero                             = $_POST["numero"];
                $abrir->municipio                          = $_POST["municipio"];

                if($_POST['prosseguir'] != "1º Atendimento"){
                    if($_POST['prosseguir'] == "Pós Operatório"){     
                        $abrir->data_cirurgia              = $_POST["data_cirurgia"];
                    }
                    $abrir->data_retorno                   = $_POST["data_retorno"];
                    $abrir->tempo_retorno                  = $_POST["tempo"] . " " . $_POST["periodo"];
                    $abrir->prontuario                     = $_POST["prontuario"];
                    $abrir->id_med_retorno                 = $_POST["medico"];
                }
                
                if(!isset($_SESSION['id_user']) || $_POST['prosseguir'] != "Pós Operatório"){
                    if($_POST['prosseguir'] == "1º Atendimento") {
                        $abrir->arq_doc_foto               = Arquivo::adicionar("arq_doc_foto", $_POST["nome"]);
                        $abrir->arq_doc_foto_opc           = Arquivo::adicionar("arq_doc_foto_opc", $_POST["nome"]);
                        $abrir->arq_cartao_sus             = Arquivo::adicionar("arq_cartao_sus", $_POST["nome"]);
                        $abrir->arq_enc_medico             = Arquivo::adicionar("arq_enc_medico", $_POST["nome"]);
                        $abrir->arq_doc_med_comp           = Arquivo::adicionar("arq_doc_med_comp", $_POST["nome"]);
                    } else {
                        $abrir->arq_cartao_consulta_frente = Arquivo::adicionar("arq_cartao_consulta_frente", $_POST["nome"]);
                        $abrir->arq_cartao_consulta_verso  = Arquivo::adicionar("arq_cartao_consulta_verso", $_POST["nome"]);
                    }
                }

                R::store($abrir);
                setcookie("sucesso", $protocolo, time()+3);
                header("Location: resultado");
            }
        }

        public static function arq_upd(){
            $form = R::findOne("formularios", "id = $_POST[prosseguir]");
            $arq_upd = R::dispense("formularios");
            $arq_upd->id                                   = $form['id'];
            $arq_upd->status                               = "Em Análise";
            isset($_FILES['arq_doc_foto']) ? $arq_upd->arq_doc_foto = Arquivo::adicionar("arq_doc_foto", $form["nome"]) : "";
            isset($_FILES['arq_doc_foto_opc']) ? $arq_upd->arq_doc_foto_opc = Arquivo::adicionar("arq_doc_foto_opc", $form["nome"]) : "";
            isset($_FILES['arq_cartao_sus']) ? $arq_upd->arq_cartao_sus = Arquivo::adicionar("arq_cartao_sus", $form["nome"]) : "";
            isset($_FILES['arq_enc_medico']) ? $arq_upd->arq_enc_medico = Arquivo::adicionar("arq_enc_medico", $form["nome"]) : "";
            isset($_FILES['arq_doc_med_comp']) ? $arq_upd->arq_doc_med_comp = Arquivo::adicionar("arq_doc_med_comp", $form["nome"]) : "";
            isset($_FILES['arq_cartao_consulta_frente']) ? $arq_upd->arq_cartao_consulta_frente = Arquivo::adicionar("arq_cartao_consulta_frente", $form["nome"]) : "";
            isset($_FILES['arq_cartao_consulta_verso']) ? $arq_upd->arq_cartao_consulta_verso = Arquivo::adicionar("arq_cartao_consulta_verso", $form["nome"]) : "";
            R::store($arq_upd);
            setcookie("sucesso", "ok", time()+3);
            header("Location: recepcao");
        }

        public static function arq_err(){
            $form = R::findOne("formularios", "id = $_POST[prosseguirce]");
            $arq_err = R::dispense("formularios");
            $arq_err->id                                   = $form['id'];
            $arq_err->status                               = "Arquivos Incorretos";
            isset($_POST['dfp']) ? $arq_err->arq_doc_foto = Arquivo::deletar($form["arq_cartao_consulta_frente"]) : "";
            isset($_POST['dfop']) ? $arq_err->arq_doc_foto_opc = Arquivo::deletar($form["arq_cartao_consulta_frente"]) : "";
            isset($_POST['crp']) ? $arq_err->arq_cartao_sus = Arquivo::deletar($form["arq_cartao_consulta_frente"]) : "";
            isset($_POST['emp']) ? $arq_err->arq_enc_medico = Arquivo::deletar($form["arq_cartao_consulta_frente"]) : "";
            isset($_POST['dmcp']) ? $arq_err->arq_doc_med_comp = Arquivo::deletar($form["arq_cartao_consulta_frente"]) : "";
            isset($_POST['fccp']) ? $arq_err->arq_cartao_consulta_frente = Arquivo::deletar($form["arq_cartao_consulta_frente"]) : "";
            isset($_POST['vccp']) ? $arq_err->arq_cartao_consulta_verso = Arquivo::deletar($form["arq_cartao_consulta_verso"]) : "";
            R::store($arq_err);
            setcookie("sucesso", "ok", time()+3);
            header("Location: recepcao");
        }
        
        public static function reagendar(){
            $formularios = R::findAll("formularios", "id_medico = $_POST[reagendar] AND data_marcada = '$_POST[data_marcada]' AND status = 'Agendado'");
            foreach ($formularios as $form) {
                $reagendar = R::dispense("formularios");
                $reagendar->id                        = $form['id'];
                $reagendar->data_marcada              = $_POST["nova_data_marcada"];
                R::store($reagendar);
            }
            setcookie("sucesso", "ok", time()+3);
            header("Location: recepcao");
        }

        public static function agendar(){
            $form = R::findOne("formularios", "id = $_POST[prosseguir]");
            $agendar = R::dispense("formularios");
            $agendar->id                              = $form['id'];
            $agendar->data_agendamento                = date("Y-m-d H:i:s");
            $agendar->id_recepcao                     = $_SESSION["id_user"];
            $agendar->especialidade                   = $_POST['especialidade'];
            $agendar->id_medico                       = $_POST["medico"];
            $form['atendimento'] != '1º Atendimento' ? $agendar->id_med_retorno = $_POST["medico"] : "";
            $agendar->data_marcada                    = $_POST["data_marcada"];
            $agendar->hora_marcada                    = $_POST["hora_marcada"];
            $agendar->status                          = "Agendado";
            R::store($agendar);
            setcookie("sucesso", "ok", time()+3);
            header("Location: recepcao");
        }

        public static function presenca(){
            $presenca = R::dispense("formularios");
            $presenca->id                            = isset($_POST['presente']) ? $_POST['presente'] : $_POST['ausente'] ;
            $presenca->data_consultado                = date("Y-m-d H:i:s");
            $presenca->status                        = isset($_POST['presente']) ? "Consultado" : "Ausente";
            R::store($presenca);
            setcookie("sucesso", "ok", time()+3);
            header("Location: recepcao");
        }
        
        public static function cancelar(){
            $form = R::findOne("formularios", "id = $_POST[cancelar]");
            $cancelar = R::dispense("formularios");
            $cancelar->id                             = $_POST['cancelar'];
            $cancelar->data_consultado                = date("Y-m-d H:i:s");
            $cancelar->status                         = "Cancelado";
            R::store($cancelar);
            setcookie("sucesso", $form['protocolo'], time()+3);
            header("Location: consultar");
        }
    }

?>