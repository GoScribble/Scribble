# Scribble [![Build Status](https://travis-ci.org/GoScribble/Scribble.svg)](https://travis-ci.org/GoScribble/Scribble) [![StyleCI](https://styleci.io/repos/33480669/shield)](https://styleci.io/repos/33480669) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/a4744725-1ee6-4787-a1bd-4be1ef5e05d8/mini.png)](https://insight.sensiolabs.com/projects/a4744725-1ee6-4787-a1bd-4be1ef5e05d8)

Scribble is a library that will connect you and all your blogs in a simple, clean and universal way. With Scribble you can publish your blog posts across multiple blogging platforms, forums and sites.

```
Please keep in mind when using Scribble that it is still in development
```

#When does Scribble come in handy?
Let's say you're an author and you maintain several blogs (a personal blog, one for the book series you author and the publishers blog) if you planned on a book signing tour and you wanted to update all your readers across all three blogs to your progress without having to post three times across the blogs then Scribble could be your savior, doing all the work and publishing your posts automatically across all your sites.

###Get Scribble
Install with composer,
```
composer require scribble/scribble
```

Once installed you will need to get the bridge for the blogging platforms that you want to use, Wordpress, phpBB and Anchor are supported.

####Wordpress Bridge
Download the <a href="https://github.com/GoScribble/Wordpress-Bridge">Scribble Bridge plugin</a> for Wordpress and copy it to your Wordpress plugin directory, activate it and you are good to go! Scribble will now be able to interface with your Wordpress site.

####phpBB Bridge
Download the <a href="https://github.com/GoScribble/phpBB-Bridge">Scribble Bridge plugin</a> for phpBB and drop it into your forum's root directory, and that's it. 

####Anchor Bridge
Download the <a href="https://github.com/GoScribble/Anchor-Bridge">Anchor Bridge plugin</a> for Anchor and follow the instructions in the README.

###Setting up Scribble
Rename your Scribble/Config/config.example.php file to config.php, here's an example of the config file set up to work with a Wordpress blog and a phpBB forum.
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
        
        ],
        
        [
            
            "name"              => "Anchor",
            "active"            => true,
            "nickname"          => "myanchorblog",
            "url"               => "http://myanchorblog.org",
            "username"          => "user",
            "password"          => "pass",
            "default_cat_id"    => "1",
            "provider_class"    => "Anchor"
        
        ]
    
    ],
    
    "Groups" => [
    
        "ExampleGroup" => [
        
            "myphpblog",
            "myforum"
            
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
        "post_title"    => "Hello World",
        "post_content"  => "I'm posting all over the place now!
    ]);
```

The "only" method accepts an array of the nicknames of the blogs you want to  use, nicknames are set in the Config/config.php file

#####Publish to a group of providers
```php
use Scribble\Publisher;
Publisher::group(["ExampleGroup"])->create(
    [
        "post_title"    => "Hello World",
        "post_content"  => "I'm posting all over the place now!
    ]);
```

The "group" method accepts a group name set in the Config.php file, this will load up a playlist of providers conventiently grouped together under one name.

#####Change config settings at runtime
```php
use Scribble\Publisher;
Publisher::config("myforum", ["default_forum_id" => 4])->only(["myforum"])->create(
    [
        "post_title"    => "Hello World",
        "post_content"  => "I'm posting all over the place now!
    ]);
```

The "config" method allows for changes in the settings during runtime for example when publishing to a phpBB forum you may wish to change the destination forum id from the default setting, above is an example of this. "config" accepts two parameters first, the nickname of the provider found in the Scribble Config/config.php file and second, an array of config settings to be used, the existing ones in the config.php file will be overwritten with these new values.
