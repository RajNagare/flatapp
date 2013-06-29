gus
===

The web app kickstarter

# Install Gus

`git clone git://github.com/maxatbrs/gus.git /path/to/your/project`

`cd /path/to/your/project`

`git submodule init`

`git submodule update`

Read more @ http://git-scm.com/book/en/Git-Tools-Submodules#Cloning-a-Project-with-Submodules

## Configuration

<<<<<<< HEAD
    DirectoryIndex index.php
        <Directory /path/to/my/project>
            Options +Indexes IncludesNOEXEC FollowSymLinks
            allow from all
            AllowOverride All
=======
- Update `config.ini` paths to match your project directory paths
- Make sure `views/cache/` is writable by apache
- Update your vhost block to have the following:
  
    DirectoryIndex index.php   
    <Directory /path/to/my/project>
        Options -Indexes IncludesNOEXEC FollowSymLinks
        allow from all
        AllowOverride All
>>>>>>> e1b2b185003c2d30637f8fcc0debb06dd22d0c96
    </Directory>
  
    
### Notes

- Make sure `logs/` is writable by apache
- Make sure `views/cache/` is writable by apache 
- Have a .gitignore inside `logs/` and `views/cache` (to not track any of it's child files)

# Requirements

- Git
- PHP 5.2.4 + (Twig)
