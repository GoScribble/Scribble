<?php namespace Scribble\Providers;

use Scribble\Exceptions\ScribbleProviderException;
use Scribble\Contracts\ProviderContract;
use Scribble\ProviderService;
use \Curl\Curl;

class Anchor extends ProviderService implements ProviderContract
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
        $data["cat_id"] = $this->config["default_cat_id"];
        $curl = new Curl();
        $curl->setopt(CURLOPT_USERPWD, $this->config["username"] . ":" . $this->config["password"]);
        $curl->setopt(CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        $curl->post($this->config["url"] . "/scribbleapi", $data);
        $this->handleResponse($curl->response);
    }
}
