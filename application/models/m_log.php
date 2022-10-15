<?php

defined('BASEPATH') or exit ('No direct script acess allowed');

class m_log extends CI_Model {

    public function inserir_log($usuario, $comando){

        //instância do banco log
        $dblog = $this->load->database('log', true);

        //Chamada de função na helper para nos auxiliar
        $comando = troca_caractere($comando);

        //query de inserção de dados
        $dblog->query("insert into log(usuario, comando)
                        values ('$usuario', '$comando')");

        if($dblog-> affected_rows() > 0) {
                $dados = array('codigo' => 1,
                                'msg' => 'Log cadastrado corretamente');
        }else{
            $dados = array('codigo' => 6,
                            'msg' => 'Houve algum problema na inserção do log');
        }

        //fecho a conexão com o banco de log
        $dblog->close();

        //retorna o array de dados com as informações tratadas
        return $dados;
    }


}







?>
