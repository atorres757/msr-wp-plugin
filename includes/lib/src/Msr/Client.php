<?php

namespace Msr;

class Client
{
    private $baseUrl = 'https://api.motorsportreg.com/rest';
    private $options = [];
    private $client;
    
    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->initClient();
    }
    
    private function initClient()
    {
        $this->client = curl_init();
    }
    
    public function get($uri, $params = [])
    {
        if (!empty($params)) {
            $uri .= '?' . http_build_query($params);
        }
        $opts = [
          CURLOPT_URL => $this->baseUrl . $uri,
          CURLOPT_HTTPGET => true,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_FOLLOWLOCATION => true
        ];
        curl_setopt_array($this->client, $opts);
        
        return curl_exec($this->client);
    }
    
    public function post($uri, $params = [])
    {
        $opts = [
            CURLOPT_URL => $this->baseUrl . $uri,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_RETURNTRANSFER => true
            ];
        curl_setopt_array($this->client, $opts);
        
        return curl_exec($this->client);
    }
}