#!/bin/bash

echo "Welcome to FlatApp! We're going to install some dependecies to setup the project";
echo "";

composer install twig

bower install jquery
bower install bootstrap
bower install fontawesome

unlink setup

echo "";
echo "Project setup complete!"
