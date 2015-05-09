<?php namespace Scribble;

use Scribble\Exceptions\ScribbleProviderException;

class ProviderService
{
    /**
     * Check the config array contains the required config settings to
     * use this provider
     */
    protected function checkConfig($config)
    {
        //Check either credentials have been provided or an api key
        if (empty($config["api_key"]) && empty($config["username"]) && empty($config["password"])) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Handle the response from the bridge, check for success or failure and
     * output an exception if required
     */
    protected function handleResponse($response)
    {
        $responseDecoded = json_decode($response);
        
        //Check the provider returned with the status
        if (empty($responseDecoded->status)) {
            throw new ScribbleProviderException("The provider did not respond in an acceptable way, it's likely that the post was not saved.");
        }
        
        if ($responseDecoded->status == "ok") {
            return true;
        } elseif ($responseDecoded->status == "fail") {
            throw new ScribbleProviderException($responseDecoded->message);
        }
        
        return false;
    }
}
