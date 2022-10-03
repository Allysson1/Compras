<?php
defined('BASEPATH') or exit ('No direct script acess allowed');

class m_usuario extends CI_Model {
    public function inserir($usuario, $senha, $nome, $tipo_usuario){

            // query de inserir os dados no BD
        $this->db->query("insert into usuarios (usuario, senha, nome, tipo)
                                    values ('$usuario', md5('$senha'), '$nome', '$tipo_usuario')");

        //verifica a inserção dos dados
        if ($this->db->affected_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Usuário cadastrado corretamente');
        }
        else{
            $dados = array('codigo' => 6,
                            'msg' => 'Houve um problema na inserção na tabela de usuários');
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
            $sql = $sql . "and nome like '%$nome%' "; // p like com porcentagem na variavel "%$variavel%" trás todos os usuarios com o nome informado
    
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
    public function alterar($usuario, $senha, $nome, $tipo_usuario){

        // query de inserir os dados no BD
    $this->db->query("update usuarios set usuario = '$usuario', senha =md5('$senha'),  nome = '$nome', tipo = '$tipo_usuario'
                      where usuario = '$usuario'");

    //verifica a atualização dos dados
    if ($this->db->affected_rows() > 0){
        $dados = array('codigo' => 1,
                        'msg' => 'Usuário atualizado corretamente');
    }
    else{
        $dados = array('codigo' => 6,
                        'msg' => 'Houve um problema na atualização na tabela de usuários');
    }

    //envia o array com as informações tratadas acima pela estrutura de decisão if
    return $dados;


    }





    //função desativar
    public function desativar($usuario){ //a função desativa e não apaga o usuario, pois o usuario sempre dever permanecer no BD da empresa, mesmo que não esteja mais nela

        // query de inserir os dados no BD
    $this->db->query("update usuarios set estatus = 'D' 
                     where usuario = '$usuario'");

    //verifica a atualização dos dados
    if ($this->db->affected_rows() > 0){
        $dados = array('codigo' => 1,
                        'msg' => 'Usuário DESATIVADO corretamente');
    }
    else{
        $dados = array('codigo' => 6,
                        'msg' => 'Houve um problema na desativação do usuário');
    }

    //envia o array com as informações tratadas acima pela estrutura de decisão if
    return $dados;


    }



}





?>