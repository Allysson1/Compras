<?php

defined('BASEPATH') or exit ('No direct script acess allowed');

class m_unidmedida extends CI_model {

    public function inserir($sigla, $descricao, $usuario){
        //query de inserção dos dados
        $sql = "insert into unid_medida (sigla, descricao, usucria)
                values ('$sigla', '$descricao', '$usuario')";

        $this->db->query($sql);

        //verificar a insersão dos dados ocorreu com sucesso
        if ($this->db->affected_rows() > 0){
            //fazemos a inserção no Log na nuvem
            //fazemos a instancia da model M_log
            $this->load->model('m_log');

            //fazemos a chamada do método de inserção do log
            $retorno_log = $this->m_log->inseir_log($usuario, $sql);

            if ($retorno_log['codigo'] == 1){
                $dados = array(
                    'codigo' => 1,
                    'msg' => 'Unidade de media cadastrada corretamente');
            }
            else{
                $dados = array(
                    'codigo' => 7,
                    'msg' => 'Houve algum problema no salvamento do log, porém, 
                    a Unidade de medida foi cadastrada corretamente');
            }
        }
        else{
            $dados = array(
                'codigo' => 5,
                'msg' => 'Houve algum problema na inserção da Unidade de medida');
        }
        return $dados;
    }




    public function consultar($codigo, $sigla, $descricao){

        //função que servirá para quatro tipos de consulta:
        //para todas as unidades de medida;
        //Para uma determinada sigla de unidade;
        //Para um código de unidade de medida;
        //para um código de unidade de medida;
        //Para descrição da unidade de medida;

        $sql = "select * from unid_medida where status = '' ";

        if ($codigo != '' && $codigo != 0) {
            $sql = $sql . "and cod_unidade = '$codigo' ";
        }

        if ($sigla != ''){
            $sql = $sql . "and sigla = '$sigla' ";
        }

        if($descricao != ''){
            $sql = $sql . "and descricao like '%$descricao%' ";
        }

        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Consulta efetuada com sucesso',
                            'dados' => $retorno->result());
        }
        else {
            $dados = array('codigo' => 6,
            'msg' => 'Dados não encontrados');
        }

        return $dados;
    }





     //função alterar
     public function alterar($codigo, $sigla, $descricao, $usuario){

        if (trim($sigla) != '' && trim($descricao) != ''){
            $sql = "update unid_medida set sigla = '$sigla', descricao = '$descricao'
            where cod_unidade = '$codigo'";
        }
        elseif (trim($sigla) != ''){
            $sql = "update unid_medida set sigla = '$sigla' where cod_unidade = '$codigo'";
        }
        else{
            $sql = "update unid_medida set descricao = '$descricao' where cod_unidade = '$codigo'";
        }
    
            // query de inserir os dados no BD
        $this->db->query($sql);
    
             //verifica se a inserção ocorreu com sucesso
        if($this->db->affected_rows() >= 0){
            //fazemos a inserção do log na nuvem;
            //Fazemos a instência da model m_log
            $this->load->model('m_log');
        
    
         //fazemos a chamada do método de inserção do log
        $retorno_log = $this->m_log->inserir_log($usuario, $sql);
    
            //verifica a atualização dos dados
        if ($retorno_log['codigo'] == 1){ //de onde vem esse código?(perguntar ao professor)
                $dados = array('codigo' => 1,
                                'msg' => 'Unidade de medida atualizada corretamente');
            }
        
        }else{
            $dados = array('codigo' => 7,
                            'msg' => 'Houve algum problema no salvamento do log, porém, 
                            a Unidade de medida foi cadastrada');
        }
    
        //envia o array com as informações tratadas acima pela estrutura de decisão if
        return $dados;
    
    
        }
    
    
    
    
    
        //função desativar
        public function desativar($codigo, $usuario){ //a função desativa e não apaga o usuario, pois o usuario sempre dever permanecer no BD da empresa, mesmo que não esteja mais nela
    
            // query de inserir os dados no BD
    
            $sql = "select * from peodutos where unid_medida = '$codigo' and status = '' ";
    
            $retorno = $this->db->query($sql);
    
           
            
                //verifica a atualização dos dados
            if ($retorno->num_rows() > 0){ 
                    $dados = array('codigo' => 3,
                                    'msg' => 'Não podemos desativar, existe produtos com essa unidade de medida cadastrado(s).');
            }
            
            else{
                $sql2 = "update unid_medida set status = 'D' where cod_unidade = '$codigo'";

                $this->db->query($sql2);
            
                if ($this->db->affected_rows() > 0){
                    $this->load->model('m_log');

                    $retorno_log = $this->m_log->inserir_log($usuario, $sql2);
        
                        //verifica a atualização dos dados
                    if ($retorno_log['codigo'] == 1){ //de onde vem esse código?(perguntar ao professor)
                            $dados = array('codigo' => 1,
                                            'msg' => 'Unidade de medida DESATIVADA corretamente');
                        }
                    
                    else{
                        $dados = array('codigo' => 8,
                                        'msg' => 'Houve algum problema no salvamento do log, porém, 
                                        a Unidade de medida foi desativada corretamente');
                    }
                }
                else{
                    $dados = array('codigo' => 7,
                                    'msg' => 'Houve um problema na DESATIVAÇÃO da Unidade de Medida');
                }
            }

            //envia o array com as informações tratadas acima pela estrutura de decisão if
            return $dados;
    
    
        }
    


    

}








?>