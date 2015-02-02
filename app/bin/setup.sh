#!/bin/bash


echo "";
echo "------------------------------------------------------";
echo "Welcome to FlatApp! We're going to install some";
echo "dependecies to setup the project.";
echo "------------------------------------------------------";
echo "";

echo "Installing Composer dependencies...";
echo "";
composer install

echo ""
echo "Installing Bower dependencies...";
echo "";

bower install

unlink setup 

echo "";
echo "Project setup complete!"
echo "";
