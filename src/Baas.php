<?php

namespace CodePhix\Baas;

class Baas {
    
    private $connection;
    
    public function __construct($token, $status = false) {
        $this->connection = new Connection($token, ((!empty($status)) ? $status : 'producao'));
    }

}
