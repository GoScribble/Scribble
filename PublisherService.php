<?php namespace Scribble;

use Scribble\Exceptions\ScribbleException;
use Scribble\Exceptions\ScribbleProviderException;
use \ReflectionClass;
use \ReflectionException;

class PublisherService
{
    
    private $publishOver;
    private $providerDefinition;
    
    /**
     * Set Scribble to publish over all available providers
     */
    public function all()
    {
        try {
            $this->checkAndSetProviderDefinition("all");
            
            $populateProviders = $this->populateProviders("all", $this->loadConfig());
            if (!$populateProviders) {
                throw new ScribbleException("Internal class issue with populateProviders when the 'all' method was triggered.");
            }
            $this->publishOver = $populateProviders;
        } catch (ScribbleException $e) {
            $this->scribbleExceptionHandle($e);
            return false;
        }
        
        return $this;
    }
    
    /**
     * Set which providers Scribble should publish over
     */
    public function only($providers)
    {
        try {
            $this->checkAndSetProviderDefinition("only");
            
            //Verify the providers provided are all available for use
            if (!$this->verifyProvidersAgainstConfig($providers, $this->loadConfig())) {
                throw new ScribbleException("Either one of the providers supplied are not available for use, check the Scribble 'Config/config.php' file OR you have attempted to use a provider by nickname more than once which is not allowed.");
            }
            
            $populateProviders = $this->populateProviders($providers, $this->loadConfig());
            if (!$populateProviders) {
                throw new ScribbleException("Internal class issue with populateProviders when the 'only' method was triggered.");
            }
            $this->publishOver = $populateProviders;
        } catch (ScribbleException $e) {
            $this->scribbleExceptionHandle($e);
            return false;
        }
        
        return $this;
    }
    
    /**
     * Selects the group(s) of providers from the config file to publish over
     */
    public function group($group)
    {
        try {
            $this->checkAndSetProviderDefinition("group");
            
            //Get the providers into an array from their resolved groups
            $providers = $this->getProvidersFromGroup($group, $this->loadConfig());
            if (!$providers) {
                throw new ScribbleException("One or more of the groups provided could not be resolved with their providers, check the Scribble 'Config/config.php' file"); 
            }
            
            //Verify the providers provided are all available for use
            if (!$this->verifyProvidersAgainstConfig($providers, $this->loadConfig())) {
                throw new ScribbleException("Either one of the providers supplied are not available for use, check the Scribble 'Config/config.php' file OR you have attempted to use a provider by nickname more than once which is not allowed.");
            }
            
            $populateProviders = $this->populateProviders($providers, $this->loadConfig());
            if (!$populateProviders) {
                throw new ScribbleException("Internal class issue with populateProviders when the 'group' method was triggered.");
            }
            $this->publishOver = $populateProviders;
        } catch (ScribbleException $e) {
            $this->scribbleExceptionHandle($e);
            return false;
        }
        
        return $this;
    }
    
    public function create($data)
    {
        try {
            //Validate the data provided
            if (!$this->validateNewPostData($data)) {
                throw new ScribbleException("The data provided to create a new post is incomplete or not formated correctly.");
            }
        } catch (ScribbleException $e) {
            $this->scribbleExceptionHandle($e);
        }
        $this->createNewPost($data);
    }
    
    /**
     * Load the config file
     */
    private function loadConfig()
    {
        //Check if the config file exists
        try {
            if (!file_exists(__DIR__ . "/Config/config.php")) {
                throw new ScribbleException("The Scribble config file 'Config/config.php' could not be loaded, has is gone somewhere?");
            }
            return include __DIR__ . "/Config/config.php";
        } catch (ScribbleException $e) {
            $this->scribbleExceptionHandle($e);
        }
    }
    
    /**
     * Verify that the given array of providers has valid configeration settings
     */
    private function verifyProvidersAgainstConfig($providers, $configProviders)
    {
        $providersOk = true;
        $providersVerified = [];
        
        foreach ($providers as $providerKey => $providerValue) {
            
            $providerFoundInConfig = false;
            
            foreach ($configProviders["Providers"] as $configKey => $configValue) {
                
                //Check if this is the provider we are looking for
                if ($providerValue == $configValue["nickname"]) {
                    
                    //Check if this provider has already been selected for use
                    foreach ($providersVerified as $providersVerifiedValue) {
                        if ($providersVerifiedValue == $providerValue) {
                            $providersOk = false;
                            //BREAK OUT
                        }
                    }
                       
                    //Check for any issues with the config settings
                    if ($configValue["active"] === false) {
                        $providersOk = false;
                    }
                    
                    array_push($providersVerified, $providerValue);
                    $providerFoundInConfig = true;
                    
                }
            }
            
            //Check if given provider does not exist in the config file
            if (!$providerFoundInConfig) {
                $providersOk = false;
            }
            
        }
        
        return $providersOk;
    }
    
    /**
     * Takes an array of provider nicknames (or the string "all") and prepares their config settings
     * for use
     */
    private function populateProviders($providers, $configProviders)
    {
        $providerSettings = array();
        
        if (is_array($providers)) {
            
            foreach ($providers as $providerValue) {
                foreach ($configProviders["Providers"] as $configKey => $configValue) {
                    
                    //Check if this is the provider we are looking for
                    if ($providerValue == $configValue["nickname"]) {
                        
                        //Store these config settings for later use connecting 
                        //to the provider
                        array_push($providerSettings, $configValue);
                        
                    }
                    
                }
            }
            
        } elseif ($providers == "all") {
            
            foreach ($configProviders["Providers"] as $configKey => $configValue) {
                
                //Check if this provider is active and is ready to be used
                if ($configValue["active"] === true) {
                    
                    //Store these config settings for later use connecting 
                    //to the provider
                    array_push($providerSettings, $configValue);
                    
                }
                
            }
            
        } else {
            
            return false;
            
        }
        
        //Check if there are no available providers
        if (empty($providerSettings)) {
            throw new ScribbleException("There are no providers available for use, check your Scribble 'Config/config.php' file");
            return false;
        }
        
        return $providerSettings;
    }
    
    /**
     * Publish to the selected providers
     */
    private function createNewPost($data)
    {
        //Loop through the publishing vectors, creating an instance of the provider class
        foreach ($this->publishOver as $publishValue) {
            
            try {
                //Create an instance of the class
                $providerClass = new ReflectionClass("\\Scribble\\Providers\\" . $publishValue["provider_class"]);
                $providerObj = $providerClass->newInstanceArgs([$publishValue]);
            
                call_user_func_array(array($providerObj, "create"), [$data]);
            } catch (ScribbleProviderException $e) {
                $this->scribbleProviderExceptionHandle($e, $publishValue["provider_class"]);
            } catch (ReflectionException $e) {
                $this->scribbleExceptionHandle($e);
            }
        }
    }
    
    /**
     * Validate that the data provided to create a new post is an array and
     * has everything that is required
     */
    private function validateNewPostData($data)
    {
        if (!is_array($data)) {
            return false;
        }
        
        if (empty($data["post_title"]) || empty($data["post_content"])) {
            return false;
        }
        
        return true;
    }
    
    /**
    * Checks if a method like all, only or group which (in different ways) collect
    * providers for use. If no definition is currently set we record it here
    * @param string $definition
    */
    private function checkAndSetProviderDefinition($definition)
    {
        if (!empty($this->providerDefinition)) {
            throw new ScribbleException("You have already set the publisher to use the method '" . $this->providerDefinition . "' to collect the providers. We have detected that you have then tried to use another method to perform the same task. This is not allowed.");
        }
        
        $this->providerDefinition = $definition;
    }
    
    /**
     * This method is called from Publisher just after the Publisher object has
     * been created
     */
    public function bootstrap()
    {
        return $this->verifyConfig($this->loadConfig());
    }
    
    /**
     * Check the config file is formed correctly
     */
    private function verifyConfig($config)
    {
        if (empty($config["Providers"]) || empty($config["Groups"])) {
            throw new ScribbleException("Your Scibble 'Config/config.php' file is not formatted correctly, check your 'config.example.php' file for help.");
        }
        
        return true;
    }
    
    /**
     * Return an array of providers from the provided group(s)
     */
    private function getProvidersFromGroup($group, $config)
    {
        $returnProviders = array();
        foreach ($group as $groupValue) {
            //Check if this group doesn't exist in the config file
            if (!array_key_exists($groupValue, $config["Groups"])) {
                return false;
            }
            
            //Add these providers to the return array
            $returnProviders = array_merge($returnProviders, $config["Groups"][$groupValue]);
        }
        
        return $returnProviders;
    }
    
    private function scribbleExceptionHandle($exception)
    {
        echo "Scribble Exception: " . $exception->getMessage();
    }
    
    /**
     * @param ScribbleProviderException $exception
     */
    private function scribbleProviderExceptionHandle($exception, $provider)
    {
        echo "Scribble Provider Exception [" . $provider . "]: " . $exception->getMessage();
    }
}