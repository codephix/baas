<?php

namespace CodePhix\Baas;

use CodePhix\Baas\Connection;
use Exception;

class Cliente
{
    
    public $http;
    protected $cliente;

    public $cli;
    
    public function __construct(Connection $connection)
    {
        $this->http = $connection;
    }
    
    /**
     * Retorna array de clientes.
     * @return array
     */
    public function index()
    {
        return $this->http->get('/customers');
    }

    // Retorna a listagem de clientes
    public function getAll($filtros = false){
        $filtro = '';
        if(is_array($filtros)){
            if($filtros){
                foreach($filtros as $key => $f){
                    if(!empty($f)){
                        if($filtro){
                            $filtro .= '&';
                        }
                        $filtro .= $key.'='.$f;
                    }
                }
                $filtro = '?'.$filtro;
            }
        }
        return $this->http->get('/clients/users'.$filtro);
    }

    // Retorna os dados do cliente de acordo com o Id
    public function getById($id){

        $header[] = "user: ".$id;

        $return = $this->http->get('/users','',$header);
        if(!empty($return->user)){
            return $return->user;
        }else{
            $return;
        }
    }

    // Retorna os dados do cliente de acordo com o Id
    public function getByDocument($document){
        $return = $this->http->get('/clients/users?filter=document&value='.$document.'&page=0','');
        if(!empty($return->items[0])){
            return $return->items[0];
        }else{
            $return;
        }
    }

    // Retorna os dados do cliente de acordo com o Id
    public function getByEmail($email){

        $return = $this->http->get('/clients/users?filter=email&value='.$email.'&page=0','');
        if(!empty($return->user)){
            return $return->user;
        }else{
            $return;
        }
    }


}