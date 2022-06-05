<?php

class Arquivo{
    public static function adicionar($arq, $nome){
        $dir = "arquivo/";
        $file = $_FILES[$arq];
        $name = explode(" ", mb_strtolower($nome));
        $pac_aten = "";
        for ($i=0; $i < count($name); $i++) { 
            $pac_aten .= $name[$i][0];
        }

        $new_name = $pac_aten . "_" . md5($_FILES[$arq]["name"]) . ".pdf";
        while(file_exists("$dir/$new_name")){
            $new_name = $pac_aten . md5($new_name) . ".pdf";
        }

        if (move_uploaded_file($file["tmp_name"], "$dir/".$new_name)) { 
            return $new_name;
        }
    }

    public static function deletar($nome){
        if(file_exists("arquivo/$nome")){
            unlink("arquivo/$nome");
        }
        return NULL;
    }
    
}

?>