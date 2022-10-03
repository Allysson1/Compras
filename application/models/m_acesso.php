<?php

defined('BASEPATH') or exit ('No direct script acess allowed');

class m_acesso extends CI_Model {
    public function validalogin($usuario, $senha){

        $retorno = $this->db->query("select * from usuarios
                                        where usuario = '$usuario'
                                        and senha = md5('$senha')
                                        and estatus = ''");

        if ($retorno-> num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Usuário correto');
        }
        else{
            $dados = array('codigo' => 4,
                            'msg' => 'Usuário ou senha inválidos.');
        }

        return $dados;


    }
}

?>