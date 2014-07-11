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

class ProviderInformation extends Base {

    protected function tearDown()
    {
        m::close();
    }

    /**
     * @test
     * @@vcr info_status
     */
    public function get_status()
    {
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('info_status');
        //Arrange
        $sauce_api = new Client();

        //Act
        $who = $sauce_api->api('provider_information')->status();
        //Assert

        $this->assertArrayHasKey('service_operational', $who);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }

}
