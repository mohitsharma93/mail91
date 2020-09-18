<?php
namespace Mail91;

use GuzzleHttp\Client;

trait GuzzleTrait {

    public function httpCall($authKey, $method, $url, $data) {
        $httpClient = new Client(array(
            'http_errors'=>false
        ));

        $response = $httpClient->$method($url, array(
            'json' => $data,
            'headers' => array(
                'Accept' => 'application/json',
                'Authorization' => $authKey,
            ),
        ));

        $res = array(
            'status' => $response->getStatusCode(),
            'data' => json_decode($response->getBody()->getContents()),
        );
        return $res;
    }

}
