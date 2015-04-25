# Scribble [![Build Status](https://travis-ci.org/GoScribble/Scribble.svg)](https://travis-ci.org/GoScribble/Scribble)

Scribble is a library that will connect you and all your blogs in a simple, clean and universal way. With Scribble you can publish your blog posts across multiple blogging platforms, forums and sites.

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

Once installed you will need to get the bridge for the blogging platforms that you want to use, Wordpress and phpBB are supported.

####Wordpress Bridge
Download the <a href="https://github.com/GoScribble/Wordpress-Bridge">Scribble Bridge plugin</a> for Wordpress and copy it to your Wordpress plugin directory, activate it and you are good to go! Scribble will now be able to interface with your Wordpress site.

###phpBB Bridge
Download the <a href="https://github.com/GoScribble/phpBB-Bridge">Scribble Bridge plugin</a> for phpBB and drop it into your forum's root directory, and that's it. 

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
        
            "name"              => "phpBB",
            "active"            => true,
            "nickname"          => "myforum",
            "url"               => "http://myforum.net/phpBB",
            "username"          => "user",
            "password"          => "pass",
            "default_forum_id"  => 2,
            "provider_class"    => "PhpBB"
        
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
Publisher::only(["myphpblog", "myforum"])->create(
    [
        "post_title"    => "Hi Mum",
        "post_content"  => "I'm posting all over the place now!
    ]);
```

The "only" method accepts an array of the nicknames of the blogs you want to  use, nicknames are set in the Config/config.php file
