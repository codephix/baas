<?php

namespace CodePhix\Baas;


class Baas {
    
    private $connection;    
    public function __construct($client_key, $client_secret, $client_name, $status = false) {
        $this->connection = new Connection($client_key, $client_secret, $client_name, ((!empty($status)) ? $status : 'producao'));
    }

    public function Cliente(){
        return (new Cliente($this->connection));
    }

    public function Login(){
        return (new Login($this->connection));
    }

    public function Transacao(){
        return (new Transacao($this->connection));
    }


}
