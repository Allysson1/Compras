<?php

defined('BASEPATH') or exit ('No direct script acess allowed');

//função para trocar caracteres ' (aspas simples) por ` (acento agudo) para podermos montar uma string

function troca_caractere($value){

    $retorno = str_replace("'" , "`", $value);
    return $retorno;
    
}

?>