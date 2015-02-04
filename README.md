FLAT APP
===

### Requirements for Development Environment**:
- Apache 2.2.3 +
- PHP 5.2.4 + 
- Bower
- Composer
- AWS CLI

# Installation
This section guides you through installing. 

Download source code and place it in your application's root folder.

## Configuration 
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
