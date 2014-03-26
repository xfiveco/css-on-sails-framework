CSS on Sails Framework
======================

CSS on Sails Framework is a simple and flexible framework used as the foundation for XHTMLized projects in 2010 - 2014. It's soon to be replaced with more flexible solution.

In the meanwhile, this is a new, open source version of the framework with some additional improvements.

## Editorconfig

.editorconfig file helps to define consistent coding style. More at [editorconfig.org](http://editorconfig.org/)

## Grunt tasks

The framework is not dependent on Grunt but the following Grunt tasks are available to improve quality of your work and make it easier:

* `jsbeautifier` - HTML / JS beautification of HTML files and main.js
* `cssbeautifier` - beautification of main.css
* `validation` - HTML validation
* `jshint` - Checking main.js code with JSHint

## Usage

CSS on Sails Framework and X-Setup works like before and as described at docs.cssonsails.org. To take advantage of the available Grunt tasks do the following:


1. Install [node.js](http://nodejs.org) (skip if you have it invstalled already)

2. Install Grunt from the command line (skip if you have it installed already)

        npm install -g grunt-cli

3. Install node packages (while in root project folder):

        npm install

4. Run all grunt tasks at once

        grunt
        
5. You can also run individual grunt tasks, for example

        grunt jshint









