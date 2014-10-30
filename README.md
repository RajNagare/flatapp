GUS
===

A prototyping and deployment harness for web applications. 

The goal of GUS is simple - make prototyping and deploying web applications easy. 

 - Develop the app using server side technologies so you don't have to re-invent the wheel. 
 - Generate an HTML "build" containing the basics of a web app - HTML, CSS, Javascript, and images.
 - Deploy to your local host, ZIP file or send it to another environment.
 - PROFIT

## How to Build and Deploy

Replace MY_BUILD with the name of your build

`./build MY_BUILD`

`ln -s MY_BUILD web`

# Install Gus With Github

You can clone gus into your project by doing the following:

`git clone git://github.com/maxatbrs/gus.git /path/to/your/project`

`cd /path/to/your/project`

# Install Gus With Zip

Downlaod and unzip gus into your project by doing the following:

`wget https://github.com/maxatbrs/gus/archive/master.zip`

`unzip master`

`rm master`

`mv gus-master/ /path/to/your/project`

`cd /path/to/your/project`

## Configuration
Make sure to add this to your apache VHOST block configuration and restart the server

<VirtualHost *:80>
	ServerAdmin your@email.com
    DocumentRoot /path/to/gus/web
    ServerName yourdomain.com
    ErrorLog /path/to/gus/app/logs/error.log
    CustomLog /path/to/gus/app/logs/access_log common
    DirectoryIndex index.php index.html
    <Directory /path/to/gus/web>
        Options +Indexes IncludesNOEXEC FollowSymLinks
        allow from all
        AllowOverride All
    </Directory>
</VirtualHost>


### Notes

- Make sure `app/logs/` is writable by apache
- Make sure `app/cache/` is writable by apache 
- Have a .gitignore inside `app/logs/` and `app//cache` (to not track any of it's child files)

# Requirements

- Git
- PHP 5.2.4 + (Twig)
