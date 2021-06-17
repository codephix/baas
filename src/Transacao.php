<?php

namespace CodePhix\Baas;

use CodePhix\Baas\Connection;
use Exception;

class Transacao
{
    
    public $http;
    protected $cliente;

    public $cli;
    
    public function __construct(Connection $connection)
    {
        $this->http = $connection;
    }

    // Retorna os dados do cliente de acordo com o Id
    public function getById($id){

        $header[] = "user: ".$id;

        return $this->http->get('/users','',$header);
    }

    public function send($user, $account, $dados){
        $header[] = "user: ".$user;
        $header[] = "account: ".$account;

        return $this->http->post('/transactions', $dados, $header);
    }


}