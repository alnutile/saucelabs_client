<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/10/14
 * Time: 1:43 PM
 */

namespace SauceLabs\Api;


class Assets  extends AbstractApi {

    const ASSET_URL = 'https://assets.saucelabs.com/jobs/';
    public function assets($username, $jobId)
    {
        return $this->get($username . '/jobs/' . $jobId . '/assets');
    }

    public function assetDownload($username, $jobId, $filename)
    {
        return $this->get($username . '/jobs/' . $jobId . '/assets/' . $filename);
    }

    public function downloadVideo($username, $jobId)
    {
        return $this->get($username . '/jobs/' . $jobId . '/assets/video.flv');
    }

    public static function videoUrl($jobId)
    {
        return self::ASSET_URL . $jobId . '/video.flv';
    }

    public static function imageUrl($jobId, $image)
    {
        return self::ASSET_URL . $jobId . '/' . $image;
    }
} 