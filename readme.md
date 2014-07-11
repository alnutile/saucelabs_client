## SauceLabs Client

This is a generic client modeled after the GitHub API https://github.com/KnpLabs/php-github-api by KnpLabs.

They did a great job of making a client that includes Events, Guzzle, Cache and making it super testable.

This client can easily be ported to any providers since I kept the Classes and Methods pretty generic.

## API

Check out the test/SauceLabs folder for a list of examples usages. Also note the PHP/VCR library to speed up all
of these calls.

## Setup

Just copy the env_example file to .env and put in your username and token. Then run composer install
and the library should allow you to make these requests to SauceLabs using your username and token.

## RoadMap

Break out anything into interfaces that will help to make this easier to be a foundation to other
automated testing services. As well as move those into their own composer libraries.

## Travis 
[![Build Status](https://travis-ci.org/alnutile/saucelabs_client.svg?branch=master)](https://travis-ci.org/alnutile/saucelabs_client)
