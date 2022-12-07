<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UniMedida extends CI_Controller
{

    public function inserir()
    {

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

        if (trim($sigla) == '') {
            $retorno = array(
                'codigo' => 2,
                'msg' => 'Sigla não informada.'
            );
        } elseif (strlen(trim($sigla)) > 3) {
            $retorno = array(
                'codigo' => 3,
                'msg' => 'Sigla pode conter no máximo 3 caracteres.'
            );
        } elseif (trim($descricao) == '') {
            $retorno = array(
                'codigo' => 4,
                'msg' => 'Descrição não informada'
            );
        } elseif (trim($usuario == '')) {
            $retorno = array(
                'codigo' => 5,
                'msg' => 'Usuário não informado'
            );
        } else {
            $this->load->model('m_unidmedida');
            $retorno = $this->m_unidmedida->inserir($sigla, $descricao, $usuario);
        }

        echo json_encode($retorno);
    }



    public function consultar()
    {
        //código, sigla e descrição
        //codigo via SJON e colocados em variaveis
        //Retornos possiveis:
        //1 - Dados consultados corretamente (banco)
        //2 - Quantidade de caracteres da sigla é superior a 3 (frontend)
        //6 - Dados não encontrados (banco)

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $codigo = $resultado->codigo;
        $sigla = $resultado->sigla;
        $descricao = $resultado->descricao;

        //verifico somente a quantidade de caracteres da sigla, pode ter até 3 
        //caracters ou nenhum para trazer todas as siglas
        if (strlen(trim($sigla)) > 3) {
            $retorno = array(
                'codigo' => 2,
                'msg' => 'Sigla pode conter no máximo 3 caracteres ou nenhum para todas'
            );
        } else {
            //realizo a instância da Model
            $this->load->model('m_unidmedida');

            $retorno = $this->m_unidmedida->consultar($codigo, $sigla, $descricao);
        }

        echo json_encode($retorno);
    }





    //criando o metodo alterar
    public function alterar(){
        //usuario nome, senha e tipo (administrador comum) recebidos via JSON e colocado em variaveis
        //retornos possiveis:
        //1 - dado(s) alterados(s) com sucesso (banco)
        //2 - 
        //3 - 
        //4 - 
        //5 - usuário não informado(frontend)
        //6 - Dados não encontrados (banco)
        //7 - Houve problema no salvamento do LOG, mas o usuário foi alterado (LOG)
        

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $codigo = $resultado->codigo;
        $sigla = $resultado->sigla;
        $descricao = $resultado->descricao;
        $usuario = $resultado->tipo_usuario;

    

         //Faremos uma validação para sabermos se todos os dados foram enviados.
 
        if (trim($codigo) == '') {
             $retorno = array ('codigo' => 2,
                                 'msg' => 'codigo não informado');
         }
        
        
        elseif (strlen(trim($sigla)) > 3){
                $retorno = array('codigo' => 3,
                'msg' => 'Sigla pode conter no máximo 3 caracteres');
        } 
            
        elseif (trim($descricao) == '' && trim($sigla) == ''){
           $retorno = array('codigo' => 4,
            'msg' => 'sigla e descrição não foram informadas');
        } 
        
        elseif(trim($usuario) == ''){
            $retorno = array('codigo' => 5,
            'msg' => 'Usuario não infomado');
         } 

        else{
                   //realizo a instância da Model
            $this->load->model('m_unidmedida');

            //atribuindo ao $retorno o array com informações da validação do acesso
            $retorno = $this->m_unidmedida->alterar($codigo, $sigla, $descricao, $usuario);
        }
        //Retorno no formato JSON
        echo json_encode($retorno);

    }



    //função desativar
    public function desativar(){
     
        //Retornos possiveis:
        // 1 - 
        // 2 - 
        // 6 - dados não encontrados (banco)

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $usuario = $resultado->usuario;
        $codigo = $resultado->codigo;

         
         if (trim($codigo) == '') {
            $retorno = array ('codigo' => 2,
                                'msg' => 'codigo da unidade não informado');
        }
    
        elseif (trim($usuario) == ''){
            $retorno = array('codigo' => 5,
                            'msg' => 'Usuairio não informado');
        }
        else{
        //realizo a instância da Model
        $this->load->model('m_unidmedida');

        //atribuindo ao $retorno o array com informações da validação do acesso
        $retorno = $this->m_unidmedida->desativar($usuario, $codigo);
    }
    //Retorno no formato JSON
    echo json_encode($retorno);
    }


}