# Scribble
Publish your blog posts across multiple blogging platforms and sites

###Get Scribble
Install with composer,
```
composer require scribble/scribble dev-master
```

Once installed you will need to get the bridge for the blogging platforms that you want to use, at the moment only Wordpress is supported.

####Wordpress Bridge
Download the <a href="https://github.com/GoScribble/WordpressBridge">Scribble Bridge plugin</a> for Wordpress and copy it to your Wordpress plugin directory, activate it and you are good to go! Scribble will now be able to interface with your Wordpress site.

###Setting up Scribble
Rename your Scribble/Config/config.example.php file to config.php, here's an example of the config file set up to work with two of my Wordpress blogs
```php
return [

    "Providers" => [
        
        [
        
            "name"              => "Wordpress",
            "active"            => true,
            "nickname"          => "myphpblog",
            "url"               => "http://myphpblog.com/blog",
            "username"          => "user",
            "password"          => "pass",
            "provider_class"    => "Wordpress"
        
        ],
        
        [
        
            "name"              => "Wordpress",
            "active"            => true,
            "nickname"          => "mypersonalblog",
            "url"               => "http://mypersonalblog.com",
            "username"          => "user",
            "password"          => "pass",
            "provider_class"    => "Wordpress"
        
        ]
    
    ]

]
```
Make sure the nickname is unique to each entry.

###Making your first post
```php
use Scribble\Publisher;
Publisher::any()->create(
    [
        "post_title"    => "Hi Mum",
        "post_content"  => "I'm posting all over the place now!
    ]);
```
