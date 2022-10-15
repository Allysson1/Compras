<?php 

defined('BASEPATH') or exit ('No direct script access allowed');


class usuario extends CI_Controller {

    //criando o metodo de inserir
    public function inserir(){
        //Usuario, senha, noime, tipo (administrador ou comum) recebidos via JSON e colocados em variaveis
        //Retornos possiveis:
        // 1 - Usuário cadastrado corretamente (banco)
        // 2 - Faltou informar o Usuario (frontend)
        // 3 - Faltou informar a senha (frontend)
        // 4 - Faltou informar o nome (frontend)
        // 5 - Faltou informar o tipo de Usuario (frontend)
        // 6 - Houve algum problema no insert da tabela (banco)
        // 7 - Usuário do sistema não infromado (frontEnd)
        // 8 - Houve problema mp salvamento do LOG, mas o usuário foi incluso (LOG)

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $usuario = $resultado->usuario;
        $senha = $resultado->senha;
        $nome = $resultado->nome;
        $tipo_usuario = strtoupper($resultado->tipo_usuario); //strtoupper põe todos os valores string em caixa alta(letras maiúsculas).


        //abaixo colocaremos o ususário do sistema
        $usu_sistema = strtoupper($resultado->usu_sistema);

        //Faremos uma validação para sabermos se todos os dados foram enviados.

        if (trim($usu_sistema) == '') {
            $retorno = array ('codigo' => 7,
                                'msg' => 'Usuário do sistema não informado');
        }
        elseif (trim($usuario) == ''){
            $retorno = array('codigo' => 2,
                             'msg' => 'Usuario não informado');
        }
        elseif (trim($senha) == ''){
            $retorno = array('codigo' => 3,
                             'msg' => 'senha não informada');
        }
        elseif (trim($nome) == ''){
            $retorno = array('codigo' => 4,
                             'msg' => 'Nome não informado');
        }
        elseif ((trim($tipo_usuario) != 'ADMINISTRADOR' &&
                trim($tipo_usuario) != 'COMUM') ||
                trim($tipo_usuario) == '') {
            $retorno = array('codigo' => 5,
                             'msg' => 'Tipo de usuário inválido');
        }
        else {
            //realizo a instância da Model
            $this->load->model('m_usuario');

            //atribuindo ao $retorno o array com informações da validação do acesso
            $retorno = $this->m_usuario->inserir($usuario, $senha, $nome, $tipo_usuario, $usu_sistema);
        }
        //Retorno no formato JSON
        echo json_encode($retorno);

    }





    //criando o metodo consultar
    public function consultar(){
        //usuário, nome e tipo (administrador ou comum) recebidos via JSON e cplocados em variaveis
        //retornos possiveis:
        // 1 - Dados consultados corretamente (banco)
        // 2 - Tipo de usuario invalido (front end)
        // 6 - Dados não encontrados (banco)


        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $usuario = $resultado->usuario;
        $nome = $resultado->nome;
        $tipo_usuario = strtoupper($resultado->tipo_usuario);

        //validação para o tipo de usuario que poderá ser ADMINISTRADOR, COMUM ou VAZIO
        if (trim($tipo_usuario) != 'ADMINISTRADOR' &&
            trim($tipo_usuario) != 'COMUM' &&
            trim($tipo_usuario) != '') {

                $retorno = array('codigo' => 5,
                'msg' => 'Tipo de usuário inválido');

            }
            else {
                //realizo a indtancia da model
                $this->load->model('m_usuario');

                //atribuindo ao $retorno o array com informações da validação do acesso
                $retorno = $this->m_usuario->consultar($usuario, $nome, $tipo_usuario);
            }

 //Retorno no formato JSON
 echo json_encode($retorno);

    }

    





    //criando o metodo alterar
    public function alterar(){
        //usuario nome, senha e tipo (administrador comum) recebidos via JSON e colocado em variaveis
        //retornos possiveis:
        //1 - dado(s) alterados(s) com sucesso (banco)
        //2 - usuario em branco ou zerado
        //3 - nome não informado
        //4 - Senha em branco
        //5 - tipo de usuário inválido (frontend)
        //6 - Dados não encontrados (banco)
        //7 - Usuário do sistema não infromado (frontEnd)
        //8 - Houve problema no salvamento do LOG, mas o usuário foi alterado (LOG)

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $usuario = $resultado->usuario;
        $senha = $resultado->senha;
        $nome = $resultado->nome;
        $tipo_usuario = strtoupper($resultado->tipo_usuario);

         //abaixo colocaremos o ususário do sistema
         $usu_sistema = strtoupper($resultado->usu_sistema);

         //Faremos uma validação para sabermos se todos os dados foram enviados.
 
        if (trim($usu_sistema) == '') {
             $retorno = array ('codigo' => 7,
                                 'msg' => 'Usuário do sistema não informado');
         }
        // elseif (trim($tipo_usuario) != 'ADMINISTRADOR' &&
        //     trim($tipo_usuario) != 'COMUM' &&
        //     trim($tipo_usuario) != '') {

        //         $retorno = array('codigo' => 5,
        //         'msg' => 'Tipo de usuário inválido');
        //     }
        //     //nome precisa ser informado
        //     elseif (trim($nome) == ''){
        //         $retorno = array('codigo' => 3,
        //         'msg' => 'Nome não informado');
        //     } 
        //     //validação para usuario
        //     elseif (trim($usuario) == ''){
        //         $retorno = array('codigo' => 2,
        //         'msg' => 'usuario não informado');
        //     } 
        //     //validação para senha que devera ser informada
        //     elseif(trim($senha) == ''){
        //         $retorno = array('codigo' => 4,
        //         'msg' => 'Senha não pode estar vazia');
        //     } 

            else{
                   //realizo a instância da Model
            $this->load->model('m_usuario');

            //atribuindo ao $retorno o array com informações da validação do acesso
            $retorno = $this->m_usuario->alterar($usuario, $senha, $nome, $tipo_usuario, $usu_sistema);
        }
        //Retorno no formato JSON
        echo json_encode($retorno);

    }




    //função desativar
    public function desativar(){
        //Usuario, senha, noime, tipo (administrador ou comum) recebidos via JSON e colocados em variaveis
        //Retornos possiveis:
        // 1 - Usuário desativado corretamente (banco)
        // 2 - usuario em banco
        // 6 - dados não encontrados (banco)

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $usuario = $resultado->usuario;

         //abaixo colocaremos o ususário do sistema
         $usu_sistema = strtoupper($resultado->usu_sistema);

         //Faremos uma validação para sabermos se todos os dados foram enviados.
         if (trim($usu_sistema) == '') {
            $retorno = array ('codigo' => 7,
                                'msg' => 'Usuário do sistema não informado');
        }
    
        elseif (trim($usuario) == ''){
            $retorno = array('codigo' => 2,
                            'msg' => 'Usuairio não informado');
        }
        else{
        //realizo a instância da Model
        $this->load->model('m_usuario');

        //atribuindo ao $retorno o array com informações da validação do acesso
        $retorno = $this->m_usuario->desativar($usuario, $usu_sistema);
    }
    //Retorno no formato JSON
    echo json_encode($retorno);
    }
}

?>
