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

\Dotenv::load(__DIR__.'/../../');

use SauceLabs\Client;
use VCR\VCR;
use SauceLabs\Tests\BaseTest as Base;

class JobsTest extends Base {

    protected function tearDown()
    {
        m::close();
    }

    /**
     * @test
     * @@vcr get_jobs
     */
    public function get_jobs()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('get_jobs');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $response = $sauce_api->api('jobs')->getJobs($username);
        //Assert

        $this->assertGreaterThan(5, count($response));

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }

    /**
     * @test
     * @@vcr get_jobs_limited
     */
    public function get_jobs_limited()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('get_jobs_limited');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $response = $sauce_api->api('jobs')->getJobs($username, $params = ['limit' => 3]);

        //Assert
        $this->assertCount(3, $response);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }
    /**
     * @test
     * @@vcr get_jobs_full_info
     */
    public function get_jobs_full_info()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('get_jobs_full_info');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $response = $sauce_api->api('jobs')->getJobs($username, $params = ['limit' => 3, 'full' => 'true']);

        //Assert
        $this->assertArrayHasKey('browser_short_version', $response[0]);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }

    /**
     * @test
     * @@vcr get_jobs_date_range
     */
    public function get_jobs_date_range()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('get_jobs_date_range');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $from = 1400240385;
        $to = 1405078785;
        $response = $sauce_api->api('jobs')->getJobs($username, $params = ['from' => $from, 'to' => $to]);

        //Assert
        $this->assertCount(16, $response);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }

    /**
     * @test
     * @@vcr export_jobs
     */
    public function export_jobs()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('export_jobs');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $response = $sauce_api->api('jobs')->getJobs($username,
            $params = []);

        //Assert
        $this->assertNotEmpty($response);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr find_by
     */
    public function find_by_value()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('find_by');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $field = 'browser_short_version';
        $searchText = '26';
        $response = $sauce_api->api('jobs')->getJobsBy($username, $field, $searchText,
            $params = []);

        //Assert
        $this->assertNotEmpty($response);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr find_by
     */
    public function getJob()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('find_by');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $field = 'browser_short_version';
        $searchText = '26';
        $response = $sauce_api->api('jobs')->getJobsBy($username, $field, $searchText);

        $response = $sauce_api->api('jobs')->getJob($username, $response[0]['id']);

        //Assert
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('browser_short_version', $response);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr update_jobs
     */
    public function updateJob()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('update_jobs');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $field = 'browser_short_version';
        $searchText = '26';
        $response = $sauce_api->api('jobs')->getJobsBy($username, $field, $searchText);

        $jobId = $response[0]['id'];

        $update = array(
            'name' => 'Test Update',
            'tags' => array('@tag1'),
            'public' => 'public',
            'passed' => '0',
            'custom-data' => array('foo' => 'bar')
        );

        $response = $sauce_api->api('jobs')->updateJob($username, $response[0]['id'], $update);

        //Assert
        $this->assertNotEmpty($response);

        $this->assertEquals($response['name'],'Test Update');

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr stop_job
     */
    public function stopJob()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('stop_job');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act

        $jobId = '1cde7b77e8744ff5b6198489ceffce81';

        $response = $sauce_api->api('jobs')->stopJob($username, $jobId);

        //Assert
        $this->assertNotEmpty($response);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }
}
