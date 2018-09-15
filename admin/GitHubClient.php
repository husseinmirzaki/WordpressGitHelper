<?php
/**
 * Created by PhpStorm.
 * User: Hussein Mirzaki
 * Date: 9/14/2018
 * Time: 6:04 PM
 */

trait GitHubClient
{
    public $base_url = "https://api.github.com";
    public $client;

    public function setClient(ClientInterface $client) {
        $this->client = $client;
    }


    public function get($uri , $headers = []) {
        return $this->getHttpClient()->get($uri , $headers)->getBody()->getContents();
    }

    public function post($uri , $headers = []) {
        return $this->getHttpClient()->post($uri , $headers)->getBody()->getContents();
    }

    /**
     * @return \Http\Client\Common\HttpMethodsClient
     */
    public function getHttpClient()
    {
        return $this->client->getHttpClient();
    }

}