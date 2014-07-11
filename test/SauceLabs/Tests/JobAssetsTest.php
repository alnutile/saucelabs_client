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

use SauceLabs\Api\Assets;
use SauceLabs\Client;
use VCR\VCR;
use SauceLabs\Tests\BaseTest as Base;

class JobAssetsTest extends Base {

    protected function tearDown()
    {
        m::close();
    }

    /**
     * @test
     * @vcr job_assets
     */
    public function jobAssets()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('job_assets');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $jobId = '1cde7b77e8744ff5b6198489ceffce81';

        $response = $sauce_api->api('assets')->assets($username, $jobId);

        //Assert
        $this->assertNotEmpty($response['screenshots']);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr job_asset_download
     */
    public function jobAssetDownload()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('job_asset_download');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $jobId = '1cde7b77e8744ff5b6198489ceffce81';
        $filename = '0000screenshot.png';
        $response = $sauce_api->api('assets')->assetDownload($username, $jobId, $filename);

        //Assert
        $this->assertNotEmpty($response);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr job_asset_download_video
     */
    public function jobDownLoadVideo()
    {
        $username = $_ENV['USERNAME_KEY'];
        VCR::turnOn();
        //VCR::insertCassette('authenticate');
        VCR::insertCassette('job_asset_download_video');
        //Arrange
        $sauce_api = new Client();
        $sauce_api->authenticate($username, $_ENV['TOKEN_PASSWORD'], Client::AUTH_HTTP_PASSWORD);

        //Act
        $jobId = '1cde7b77e8744ff5b6198489ceffce81';

        $response = $sauce_api->api('assets')->downloadVideo($username, $jobId);

        //Assert
        $this->assertNotEmpty($response);

        // To stop recording requests, eject the cassette
        VCR::eject();
        // Turn off VCR to stop intercepting requests
        VCR::turnOff();
    }

    /**
     * @test
     */
    public function jobAssetVideoURL()
    {
        //Arrange
        $sauce_api = new Client();
        $jobId = '1cde7b77e8744ff5b6198489ceffce81';

        //Act
        $response = Assets::videoUrl($jobId);
        $this->assertEquals('https://assets.saucelabs.com/jobs/' . $jobId . '/video.flv', $response);
    }

    /**
     * @test
     */
    public function jobAssetImageURL()
    {
        //Arrange
        $sauce_api = new Client();
        $jobId = '1cde7b77e8744ff5b6198489ceffce81';
        $image = 'screenShot0.png';
        //Act
        $response = Assets::imageUrl($jobId, $image);
        $this->assertEquals('https://assets.saucelabs.com/jobs/' . $jobId . '/' . $image, $response);
    }


}
