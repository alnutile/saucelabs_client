<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/10/14
 * Time: 1:56 PM
 */

namespace SauceLabs\Tests;

use \Mockery as m;
use Dotenv;

\Dotenv::load(__DIR__.'/../../../');

use SauceLabs\Client;
use SauceLabs\Tests\BaseTest as Base;
use VCR\VCR;

class ClientTest extends Base {

    protected function tearDown()
    {
        m::close();
    }

    /**
     * @test
     * @@vcr current_user
     */
    public function should_authenticate()
    {
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('current_user');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($_ENV['USERNAME_KEY'], $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $who = $sauce_api->api('current_user')->show($_ENV['USERNAME_KEY']);
        //Assert

        $this->assertArrayHasKey('access_key', $who);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }


    /**
     * @test
     * @@vcr show_activity
     */
    public function should_get_activity()
    {
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('show_activity');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($_ENV['USERNAME_KEY'], $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $what = $sauce_api->api('current_user')->getUserActivity($_ENV['USERNAME_KEY']);
        //Assert

        $this->assertArrayHasKey('subaccounts', $what);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }
}
