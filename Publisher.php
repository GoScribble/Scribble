<?php namespace Scribble;

use Scribble\Exceptions\ScribbleException;
use \ReflectionClass;
use \ReflectionException;

class Publisher
{
    /**
     * The static entry point will create an object of this class
     * to be used for method chaining
     */
    public static function __callStatic($method, $args)
    {
        try {
            $scribbleObject = new ReflectionClass("Scribble\PublisherService");
            $scribbleInstance = $scribbleObject->newInstance();
            
            //Run bootstrap
            call_user_func_array(array($scribbleInstance, "bootstrap"), []);
            //Call object with the original request
            call_user_func_array(array($scribbleInstance, $method), $args);
        
            return $scribbleInstance;
        } catch (ReflectionException $e) {
            self::thisIsNotAGreatStartExceptionHandle($e);
        } catch (ScribbleException $e) {
            echo "Scribble Exception: " . $e->getMessage();
        }
    }
    
    private static function thisIsNotAGreatStartExceptionHandle($exception)
    {
        echo "Scribble Exception: Well this isn't a great start! Here's the Reflection error \"" . $exception->getMessage() . "\" Is the PublisherService.php file still there? Or maybe you aren't using class autoloading in Composer?";
    }
}