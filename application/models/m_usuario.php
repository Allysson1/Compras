<?php
defined('BASEPATH') or exit ('No direct script acess allowed');

class m_usuario extends CI_Model {
    public function inserir($usuario, $senha, $nome, $tipo_usuario, $usu_sistema){

        // query de inserir os dados no BD

        $sql = "insert into usuarios (usuario, senha, nome, tipo)
            values ('$usuario', md5('$senha'), '$nome', '$tipo_usuario')";

        $this->db->query($sql);

            //verifica se a inserção ocorreu com sucesso
        if($this->db->affected_rows() > 0){
            //fazemos a inserção do log na nuvem;
            //Fazemos a instência da model m_log
            $this->load->model('m_log');
        

            //fazemos a chamada do método de inserção do log
            $retorno_log = $this->m_log->inserir_log($usu_sistema, $sql);

            //verifica a inserção dos dados
            if ($retorno_log['codigo'] == 1){ //de onde vem esse código?(perguntar ao professor)
                $dados = array('codigo' => 1,
                                'msg' => 'Usuário cadastrado corretamente');
            }
        }else{
            $dados = array('codigo' => 8,
                            'msg' => 'Houve algum problema no salvamento do log, porém, 
                            o usuário foi cadastrado corretamente na tabela de usuários');
        }

        //envia o array com as informações tratadas acima pela estrutura de decisão if
        return $dados;


    }



    //função consultar
    public function consultar( $usuario, $nome, $tipo_usuario){

        //função que servirár para quatro tipos de consulta:
        // * para todos os usuarios;
        // * para um determinado usuario;
        // * para um tipo de usuario;
        // * para nomes de usuarios;
    
    
        //query para consultar de acordo com parâmetros passados 
        $sql = "select * from usuarios where estatus = '' ";

        if ($usuario != '') {
            $sql = $sql . "and usuario = '$usuario' "; // o ponto(.) concatena uma 'continuação' para a query principal
        }
        if ($tipo_usuario != '') {
            $sql = $sql . "and tipo = '$tipo_usuario' ";
        }
        if ($nome != '') {
            $sql = $sql . "and nome like '%$nome%' "; // o like com porcentagem na variavel "%$variavel%" trás todos os usuarios com o nome informado
    
        }


        $retorno = $this->db->query($sql);

        //verificar se a consulta ocorreu com sucesso
        if ($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'consulta efetuada com sucesso',
                            'dados' => $retorno->result());
        }
        else{
            $dados = array('codigo' => 6,
            'msg' => 'Dados não encontrados');
        }

        return $dados;

    }




    //função alterar
    public function alterar($usuario, $senha, $nome, $tipo_usuario, $usu_sistema){

    $sql = "update usuarios set usuario = '$usuario' ";

    // $sql = "update usuarios set usuario = '$usuario', senha =md5('$senha'),  nome = '$nome', tipo = '$tipo_usuario'
    // where usuario = '$usuario'";


    if ($senha != '') {
        $sql = $sql . "and senha =md5('$senha') ";
    }
    if ($nome != ''){
        $sql = $sql . "and nome = '$nome' ";
    }
    if ($tipo_usuario != ''){
        $sql = $sql . "and tipo = '$tipo_usuario' ";
    }
    if ($usuario != ''){
        $sql = $sql . "where usuario = '$usuario' ";
    }

//todos os dados no banco estão sendo substituidos pelos usuarios setados na alteração
        
        // query de inserir os dados no BD
    $this->db->query($sql);

         //verifica se a inserção ocorreu com sucesso
    if($this->db->affected_rows() >= 0){
        //fazemos a inserção do log na nuvem;
        //Fazemos a instência da model m_log
        $this->load->model('m_log');
    

     //fazemos a chamada do método de inserção do log
    $retorno_log = $this->m_log->inserir_log($usu_sistema, $sql);

        //verifica a atualização dos dados
    if ($retorno_log['codigo'] == 1){ //de onde vem esse código?(perguntar ao professor)
            $dados = array('codigo' => 1,
                            'msg' => 'Usuário alterado corretamente');
        }
    
    }else{
        $dados = array('codigo' => 8,
                        'msg' => 'Houve algum problema no salvamento do log, porém, 
                        o usuário foi alterado corretamente na tabela de usuários');
    }

    //envia o array com as informações tratadas acima pela estrutura de decisão if
    return $dados;


    }





    //função desativar
    public function desativar($usuario, $usu_sistema){ //a função desativa e não apaga o usuario, pois o usuario sempre dever permanecer no BD da empresa, mesmo que não esteja mais nela

        // query de inserir os dados no BD

        $sql = "update usuarios set estatus = 'D' where usuario = '$usuario'";

        $this->db->query($sql);

        if($this->db->affected_rows() >= 0){   //apenas jogou dados no db cloud quando adicionou o '>=', por que? (perguntar ao professor)
            //fazemos a inserção do log na nuvem;
            //Fazemos a instência da model m_log
            $this->load->model('m_log');
        
    
            //fazemos a chamada do método de inserção do log
            $retorno_log = $this->m_log->inserir_log($usu_sistema, $sql);
        
            //verifica a atualização dos dados
            if ($retorno_log['codigo'] == 1){ //de onde vem esse código?(perguntar ao professor)
                $dados = array('codigo' => 1,
                                'msg' => 'Usuário desativado corretamente');
            }
        }
        else{
            $dados = array('codigo' => 8,
                            'msg' => 'Houve algum problema no salvamento do log, porém, o usuário foi desativado corretamente na tabela de usuários');
        }

    
        //envia o array com as informações tratadas acima pela estrutura de decisão if
        return $dados;


    }



}





?>