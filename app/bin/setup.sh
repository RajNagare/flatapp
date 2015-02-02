#!/bin/bash


echo "";
echo "------------------------------------------------------";
echo "Welcome to FlatApp! We're going to install some dependecies to setup the project";
echo "------------------------------------------------------";

echo "Installing Composer dependecies...";
echo "";
composer install

echo ""
echo "Installing Bower dependecies...";
echo "";

bower install

unlink setup 

echo "";
echo "Project setup complete!"
echo "";
