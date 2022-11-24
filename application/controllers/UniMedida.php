<?php

defined('BASEPATH') or exit ('No direct script access allowed');

class UniMedida extends CI_Controller {

    public function inserir() {

        //sigla e descrição recebidas via JSON e colocadas em variáveis
        //Retornos possiveis:
        //1 - Unidade cadastrada corretamente (Banco)
        //2 - Faltou informar sigla (frontend)
        //3 - Quantidade de caracteres da sigla é superior a 3 (frontEnd)
        //4 - Descriçaõnão informada (FrontEnd)
        //5 - usuário não informado (FrontEnd) 
        //6 - Houve algum problema no insert da tabela (banco)
        //7 - Houve problema no salvamento do log, mas a unidade foi inclusa

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $sigla = $resultado->sigla;
        $descricao = $resultado->descricao;
        $usuario = $$resultado->usuario;

        //faremos uma validação para sabermos se todos os dados foram enviados corretamente

        if(trim($sigla) == ''){
            $retorno = array('codigo' => 2,
                                'msg' => 'Sigla não informada.');
            )
        }
        elseif (strlen(trim($sigla)) > 3) {
            $retorno = array('codigo' => 3,
                                'msg' => 'Sigla pode conter no máximo 3 caracteres.');
        }
        elseif (trim($descricao) == '') {
            $retorno = array('codigo' => 4,
                                'msg' => 'Descrição não informada');
        }
        elseif(trim($usuario == '')){

        }

    }



}