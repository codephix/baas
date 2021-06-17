<?php

namespace CodePhix\Baas;

use CodePhix\Baas\Connection;
use Exception;

/**
 * Class Cliente
 * @package app\Baas
 *
 *
    \"name\": \"".((!empty($data['name'])) ? $data['name'] : '')."\",
    \"email\": \"".((!empty($data['email'])) ? $data['email'] : '')."\",
    \"company\": \"".((!empty($data['company'])) ? $data['company'] : '')."\",
    \"phone\": \"".((!empty($data['phone'])) ? $data['phone'] : '')."\",
    \"mobilePhone\": \"".((!empty($data['mobilePhone'])) ? $data['mobilePhone'] : '')."\",
    \"postalCode\": \"".((!empty($data['postalCode'])) ? $data['postalCode'] : '')."\",
    \"address\": \"".((!empty($data['address'])) ? $data['address'] : '')."\",
    \"addressNumber\": \"".((!empty($data['addressNumber'])) ? $data['addressNumber'] : '')."\",
    \"complement\": \"".((!empty($data['complement'])) ? $data['complement'] : '')."\",
    \"province\": \"".((!empty($data['province'] )) ? $data['province'] : '')."\",
    \"city\": \"".((!empty($data['city'])) ? $data['city'] : '')."\",
    \"state\": \"".((!empty($data['state'])) ? $data['state'] : '')."\",
    \"cpfCnpj\": \"".((!empty($data['cpfCnpj'])) ? $data['cpfCnpj'] : '')."\",
    \"additionalEmails\": \"".((!empty($data['additionalEmails'])) ? $data['additionalEmails'] : '')."\",
    \"notificationDisabled\": ".((!empty($data['notificationDisabled']) && $data['notificationDisabled'] == 1) ? 'true' : 'false').",
    \"externalReference\": \"".((!empty($data['externalReference'])) ? $data['externalReference'] : '')."\"
 */

class Token
{
    
    public $http;
    protected $cliente;

    public $cli;

    public $token;
    
    public function __construct(Connection $connection)
    {
        $this->http = $connection;

        if(empty($_SESSION['tokenApp']) || $_SESSION['tokenApp']['time'] <= time()){
            $_SESSION['tokenApp'] = array(
                'token' => $this->set()->token,
                'time' => time()+3600
            );
        }
        $this->token = $_SESSION['tokenApp'];

    }
   
    public function get(){
        return $this->token;
    }

    /**
     * Retorna array de clientes.
     * @return array
     */
    public function set()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://bank.qesh.ai/client/session',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "client_key": "3c411766-456d-48ef-a707-774b98c68450",
            "client_secret": "Z1oNBMkQ&"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);

    }






}
