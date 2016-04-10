## Synopsis

Little Demonstration of a PHP url dispatcher.

The problem to solve:

create a url dispatcher that maps methods inside
controller files to urls without the need of specific routing files
using a single url variable (here uri), so  that can later easily be
hidden using a htaccess file, thus this would allow even
the most basic server setup a nice url setup

## Example

this example has two controllers, root and manage,
assuming you local install will be available on localhost, the urls would be

localhost/dispatcherdemo/index.php
<< Root controller, index method

localhost/dispatcherdemo/index.php?uri=test/sometext
<< Root controller, test method

localhost/dispatcherdemo/index.php?uri=manage
<< Manage Controller, index method

localhost/dispatcherdemo/index.php?uri=manage/test/sometext
<< Manage Controller, test method


The controllers inherit from a common base_controller_class, and have a common init method
in order to initialize common elements, data logic, etc.

Basically there are two parts to this, the first is the "detachment_builder",
found in functions.php. It builds a internal hash of the controllers, methods and arguments.
The second is the "url-dispatcher", found in the base_class, which maps the current url to that
and calls the correct controller/method with the corresponding arguments

## Motivation

this is a simple demonstration, the code was supposed to be used
for like a framework and was used in a similar form.
The project is basically uncommented/undocumented

## Installation

assuming you have at least PHP 5.4 installed you simply clone the
project into a accessible folder 
