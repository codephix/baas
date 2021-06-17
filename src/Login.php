<?php

namespace CodePhix\Baas;

use CodePhix\Baas\Connection;
use CodePhix\Baas\Session;
use Exception;

class Login extends Session
{
    
    public $http;
    protected $cliente;

    public $cli;
    
    private $Login;

    public function __construct(Connection $connection)
    {
        parent::__construct();
        $this->http = $connection;

        $this->Login = $this->__get('BrzUser');
        if(empty($this->Login->time) || $this->Login->time <= time()){
            $this->unset('BrzUser');
        }
    }

    // Insere um novo cliente
    public function execute($document, $password){


        $dadosLogin = array(
            "client_name" => $this->http->client_name,
            "origin" => "api",
            "document" => $document,
            "password" => $password
        );

        if(!empty($this->__get('BrzUser'))){
            return $this->__get('BrzUser');
        }else{
            $this->Login = $this->http->post('/login', $dadosLogin);
            if(!empty($this->Login->token)){
                $this->Login->time = time()+3600;
                $this->set('BrzUser',$this->Login);
            }
            return $this->Login;
        }
    }



}