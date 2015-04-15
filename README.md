# Scribble [![Build Status](https://travis-ci.org/GoScribble/Scribble.svg)](https://travis-ci.org/GoScribble/Scribble)

Scribble is a library that will connect you and all your blogs in a simple, clean and universal way. With Scribble you can publish your blog posts across multiple blogging platforms and sites.

```
Please keep in mind when using Scribble that it is still in development
```

#When does Scribble come in handy?
Let's say you're an author and you maintain several blogs (a personal blog, one for the book series you author and the publishers blog) if you planned on a book signing tour and you wanted to update all your readers across all three blogs to your progress without having to post three times across the blogs then Scribble could be your savior, doing all the work and publishing your posts automatically across all your sites.

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
Publisher::all()->create(
    [
        "post_title"    => "Hi Mum",
        "post_content"  => "I'm posting all over the place now!
    ]);
```

###Other examples of what Scribble can do
#####Publish only to certain providers
```php
use Scribble\Publisher;
Publisher::only(["myBlog", "myPhpBlog"])->create(
    [
        "post_title"    => "Hi Mum",
        "post_content"  => "I'm posting all over the place now!
    ]);
```

The "only" method accepts an array of the nicknames of the blogs you want to  use, nicknames are set in the Config/config.php file
