<?php

defined('BASEPATH') or exit ('No direct script acess allowed');

class m_acesso extends CI_Model {

    public function validalogin($usuario, $senha){

        $retorno = $this->db->query("select * from usuarios where usuario = '$usuario'");

        if ($retorno-> num_rows() > 0) {

            if ($retorno->row()->estatus == 'D'){
                $dados = array ('Codigo' => 6,
                                'msg' => 'usuario desativado, não pode ser logado.');
            }
    
            elseif ($retorno->row()->senha != $senha){//não consegui fazer a validação da senha encriptada com md5
                $dados = array('codigo' => 4,
                                'msg' => 'Senha Incorreta');
            }
            
            else{
                $dados = array('codigo' => 8,
                                'msg' => 'Usuário e senha estão corretos.');
            }
            
        }
        else{
            $dados = array('codigo' => 5,
                            'msg' => 'usuario incorreto');
        }






        
        // if ($retorno-> num_rows() > 0 && $retorno = $usuario && $retorno = $senha){
            
        //     $sql = $this->db->query("select estatus from usuarios
        //     where usuario ='$usuario'
        //       and estatus != 'D'");

        //     if($sql != ''){
        //         $dados = array('codigo' => 6,
        //                     'msg' => 'Usuario Correto');
        //     }

        //     else{
        //         $dados = array('codigo' => 7,
        //         'msg' => 'Usuario desabilitado para acesso');
        //     }
        // }



        
        return $dados;

    }
    
}

?>