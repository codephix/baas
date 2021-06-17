<?php

namespace CodePhix\Baas;

use CodePhix\Baas\Token;

class Connection {
    public $http;
    
    public $client_name;
    public $client_key;
    public $client_secret;

    public $api_status;
    public $base_url;
    public $headers;

    public $token;

    public function __construct($client_key, $client_secret, $client_name, $status) {

        if($status == 'producao'){
            $this->api_status = false;
        }elseif($status == 'homologacao'){
            $this->api_status = 1;
        }else{
            die('Tipo de homologação invalida');
        }

        $this->client_name = $client_name;
        $this->client_key = $client_key;
        $this->client_secret = $client_secret;
        $this->base_url = "https://" . (($this->api_status) ? 'hmg' : 'bank');

        $this->token = (new Token($this))->get();

        return $this;
    }


    public function get($url, $option = false, $header = false)
    {

        $header[] = "Content-Type: application/json";
        $header[] = "api-token: ".$this->token['token'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $this->base_url .'.qesh.ai'. $url.$option,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);

    }

    public function post($url, $params, $header = false)
    {

        $header[] = "Content-Type: application/json";
        $header[] = "api-token: ".$this->token['token'];
        
        $params = json_encode($params);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $this->base_url .'.qesh.ai'. $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $params,
          CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);


        return $response;

    }
    
}
