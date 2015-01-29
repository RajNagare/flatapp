FLAT APP
===

FlatApp is a platform for developers to build and deploy websites. 

# Development 
This section describes the development cycle of Flat App. 

## Routes and Views
A user browses to a *Route* and the app serves a *View*. The platform looks for that *View* file 
as *Route*.html

For example: A user browses to `/about` and FlatApp looks for `about.html`

*Views* are found in `src/views/`

By default, the application has `index.html` and `404.html` *Views* included. Look at these for examples.

### To create a new route
To add a new *View*, create a new HTML file such as `contact.html` or `portfolio.html` inside `src\views\`

Now use your browser to visit `myapp.com/contact` or `myapp.com/portfolio`

### Views are Built with Twig
For more documentation, see the Twig Documentation 

### Global Template
All *Views* extend the Global Template which is located in `src/views/global.html` . You will see an
example of this template extension on the index *View*:

    {% extends "global.html" %}

The Global Template includes all of the global HTML components and dependencies inclusion such as Javascript and CSS Stylesheets.

# Buidling and Deployment
This section describes the buidling / deployment cycle of Flat APp

## Build Your Flat App
This will generate a *FlatApp Build* containing all the web dependecies your app needs. It will mimic the same *Routes*
but will be served as static HTML files.

Replace MY_BUILD with the name of your build

`./build MY_BUILD`

## Deploy Your Flat App
Buidling does not deploy your app, it just generates the *FlatApp Build* . Currently, the `/web` directory is a symlink and is point to the Flat App engine. 

When you deploy, the plaform moves the `/web` pointer to your new *FlatApp Build* and serves the static app.

Add the deploy flag to serve your Flat App locally

`./build MY_BUILD deploy`

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

### Notes

- Make sure `app/logs/` is writable by apache
- Make sure `app/cache/` is writable by apache 
- Have a .gitignore inside `app/logs/` and `app/cache` (to not track any of it's child files)

# Requirements

- Apache 2.2.3 +
- PHP 5.2.4 + (Twig)
