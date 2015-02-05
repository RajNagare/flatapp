FlatApp ReadMe
===

#Setup
This section guides you through setting up your FlatApp

### Development Environment
This environment is where developers will create and edit the applications *Themes*. The platform is written in PHP but most development will consist of writing Twig templates, CSS, and Javascript. 

A common development environment URL would look like `http://dev.myapp.com`

#### Requirements for Development Environment
- Apache 2.2.3 +
- PHP 5.2.4 + 
- Bower
- Composer
- AWS CLI

### Production Environment
This environment is an Amazon S3 bucket and serves static HTML files. A developer can `build` a FlatApp - a collection of HTML and web dependencies (JS,CSS,Images, etc) and sync these files a S3 bucket.

A common development environment URL would look like `http://www.myapp.com`

#### Requirements for Production Environment
- AWS Account
- AWS S3 Bucket


Download source code and place it in your application's root folder.



### Apache VHost Configuration 
Make sure to add this to your apache VHOST block configuration and restart the server. The `DirectoryIndex` requires that all three indexes are there. 

    <VirtualHost *:80>
        ServerAdmin your@email.com
        DocumentRoot /path/to/flat/web
        ServerName yourdomain.com
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

Reload apache and browse to your app. You should recieve a notice to run the setup command. Go to the path of your FlatApp and run the `setup` command like so:

    ./setup
    
This installs all the dependencies for the project. Return to your app in the browser and you should see the application running.
