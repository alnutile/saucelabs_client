<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/10/14
 * Time: 1:43 PM
 */

namespace SauceLabs\Api;


class Jobs extends AbstractApi {

    public function getJobs($username, array $params = array())
    {
        $params = $this->buildParams($params);
        return $this->get($username . '/jobs' . $params);
    }

    public function getJobsBy($username, $field, $searchText, array $params = array())
    {
        $found = [];
        $params = array_merge($params, ['full' => 'true']);
        $results = $this->getJobs($username, $params);
        foreach($results as $key => $value) {
            if($value[$field] == $searchText) {
                $found[] = $value;
            }
        }
        return $found;
    }

    public function getJob($username, $jobId)
    {
        return $this->get($username . '/jobs/' . $jobId);
    }

    public function updateJob($username, $jobId, $update)
    {
        return $this->put($username . '/jobs/' . $jobId, $update);
    }

    public function stopJob($username, $jobId)
    {
        return $this->put($username . '/jobs/' . $jobId . '/stop');
    }
} 