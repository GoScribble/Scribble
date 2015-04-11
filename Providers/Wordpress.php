<?php namespace Scribble\Providers;

use Scribble\Exceptions\ScribbleProviderException;
use Scribble\Contracts\ProviderContract;
use Scribble\ProviderService;
use \Curl\Curl;

class Wordpress extends ProviderService implements ProviderContract
{
    private $config;
    
    public function __construct($config)
    {
        //Check config settings are valid
        if ($this->checkConfig($config)) {
            $this->config = $config;
        } else {
            throw new ScribbleProviderException("The config data sent to the provider class is incomplete or not provided correctly.");
        }
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