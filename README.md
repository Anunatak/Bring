# Bring

This library implements the Bring API for Laravel.

Installation
------------

Install using composer:

    composer require anunatak/bring

This package is compatible with Laravel 5.

Add the service provider in `app/config/app.php`:

    'Anunatak\Bring\BringServiceProvider',

And add an alias:

    'Bring'            => 'Anunatak\Bring\Bring',
    
Usage
-----

All methods return an array of information directly from the Bring API. 

For information about the data returned, please refer to the [Bring API Documentation](http://developer.bring.com/index.html).

Get information about a postal code (such as postal area). By default this searches for postal codes in Norway, but the API also support a number of other countries

    $postalCode = Bring::postalCode(1337);

Get an array of nearby pickup points to a postal code. This is, for now, only an implementation of the postal code method. More to come later.

    $pickupPoints = Bring::pickupPoints(1337);

You can also get tracking information about a package. Will require a valid tracking number, but for testing purposes you can use `TESTPACKAGE-AT-PICKUPPOINT`

    $tracking = Bring::trackPackage('TESTPACKAGE-AT-PICKUPPOINT');

