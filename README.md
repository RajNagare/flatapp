gus
===

The web app kickstarter

# Install Gus
- git clone git://github.com/maxatbrs/gus.git /path/to/your/project
- CD /path/to/your/project and install submodules by running the following: 

    git submodule init;
    git submodule update;

Read more @ http://git-scm.com/book/en/Git-Tools-Submodules#Cloning-a-Project-with-Submodules

## Configuration
- Update config.ini paths to match your project directory paths
- Make sure views/cache/ is writable by apache
- Update your vhost block to have the following:

    DirectoryIndex index.php
        <Directory /path/to/my/project>
            Options -Indexes IncludesNOEXEC FollowSymLinks
            allow from all
            AllowOverride All
    </Directory>

# Requirements

- Git
- PHP 5.2.4 + (Twig)