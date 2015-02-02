#!/bin/bash

echo "Welcome to FlatApp! We're going to install some dependecies to setup the project";
echo "";

echo "Installing Composer dependecies...";
echo "";
composer install

echo "Installing Bower dependecies...";
echo "";

bower install

echo "";
echo "Project setup complete!"
