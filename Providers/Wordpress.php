<?php namespace Scribble\Providers;

use Scribble\Exceptions\ScribbleProviderException;
use \Curl\Curl;

class Wordpress
{
    private $config;
    
    public function __construct($config)
    {
        $this->config = $config;
    }
    
    /**
    * cUrl into the Wordpress Scribble Bridge plugin and create a post
    */
    public function create($data)
    {
        $curl = new Curl();
        $curl->setopt(CURLOPT_USERPWD, $this->config["username"] . ":" . $this->config["password"]);
        $curl->post($this->config["url"] . "/scribbleapi", $data);
        $this->handleResponse($curl->response);
    }
    
    /**
    * Handle the response from the bridge, check for success or failure and
    * output an exception if required
    */
    private function handleResponse($response)
    {
        $responseDecoded = json_decode($response);
        
        if ($responseDecoded->status == "ok") {
            return true;
        } elseif ($responseDecoded->status == "fail") {
            throw new ScribbleProviderException($responseDecoded->message);
        }
        
        return false;
    }
}