Setup
===
This will guide you through setting up your FlatApp. This documentation assumes you have sysadmin knowledge and will be able to configure environments.

## Development Environment
This environment is where developers will create and edit the applications *Themes*. The platform is written in PHP but most development will consist of writing Twig templates, CSS, and Javascript. 

A common development environment URL would look like `http://dev.myapp.com`

### Requirements for Development Environment
- Apache 2.2.3 +
- PHP 5.2.4 + 
- Bower
- Composer
- AWS CLI

### Download the source and create directory for FlatApp

    wget https://github.com/maxatbrs/flatapp/archive/master.zip
    
    unzip master
    
    mv flatapp-master /path/to/myapp
    
    rm master

### Apache VHost Configuration 
Make sure to add this to your apache VHOST block configuration and restart the server. The `DirectoryIndex` requires that all three indexes are there. 

    <VirtualHost *:80>
        ServerAdmin your@email.com
        DocumentRoot /path/to/flat/web
        ServerName dev.myapp.com
        ErrorLog /path/to/flat/app/logs/error.log
        CustomLog /path/to/flat/app/logs/access_log common
        DirectoryIndex index index.php index.html
        <Directory /path/to/flat/web>
            Options +Indexes IncludesNOEXEC FollowSymLinks
            allow from all
            AllowOverride All
        </Directory>
    </VirtualHost>

### Permissions

- Make sure `app/logs/` is writable by apache
- Make sure `app/cache/` is writable by apache 

### Reload Apache and Test

Reload apache and browse to your development URL like `http://dev.myapp.com`. You should recieve a notice to run the setup command. Go to the root path of your FlatApp and run the `setup` command like so:

    ./setup
    
This installs all the dependencies for the project. Return to your app in the browser and you should see the default home page.

## Production Environment
This environment is an Amazon S3 bucket and serves static HTML files. A developer can `build` a FlatApp - a collection of HTML and web dependencies (JS,CSS,Images, etc) and sync these files a S3 bucket.

A common development environment URL would look like `http://www.myapp.com`

#### Requirements for Production Environment
- AWS Account
- AWS S3 Bucket




