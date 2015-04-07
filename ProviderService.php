<?php namespace Scribble;

use Scribble\Exceptions\ScribbleException;

class ProviderService
{
    /**
    * Check the config array contains the required config settings to
    * use this provider
    */
    protected function checkConfig($config)
    {
        //Check either credentials have been provided or an api key
        if (empty($config["api_key"]) && empty($config["username"]) && empty($config["password"]))
        {
            return false;
        }
        
        return true;
    }
}