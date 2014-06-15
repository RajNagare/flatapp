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
