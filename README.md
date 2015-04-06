# Scribble
Publish your blog posts across multiple blogging platforms and sites

###Get Scribble
Install with composer,
```
composer require scribble/scribble @dev
```

Once installed you will need to get the bridge for the blogging platforms that you want to post to, at the moment only Wordpress is supported.

####Wordpress Bridge
Download the <a href="https://github.com/GoScribble/WordpressBridge">Scribble Bridge plugin</a> for Wordpress and copy it to your Wordpress plugin directory, activate it and you are good to go! Scribble will now be able to interface with your Wordpress site.

###Setting up Scribble
Open your Scribble/Config/config.php file

###Making your first post
```php
use Scribble\Publisher;
Publisher::any()->create(
    [
        "post_title"    => "Hi Mum",
        "post_content"  => "I'm posting all over the place now!
    ]);
```
