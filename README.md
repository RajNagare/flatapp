gus
===

The web app kickstarter

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

    DirectoryIndex index.php
    <Directory /path/to/my/project>
        Options +Indexes IncludesNOEXEC FollowSymLinks
        allow from all
        AllowOverride All
    </Directory>
  
### Notes

- Make sure `logs/` is writable by apache
- Make sure `views/cache/` is writable by apache 
- Have a .gitignore inside `logs/` and `views/cache` (to not track any of it's child files)

# Requirements

- Git
- PHP 5.2.4 + (Twig)
