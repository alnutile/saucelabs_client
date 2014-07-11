<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/10/14
 * Time: 1:42 PM
 */

namespace SauceLabs\Api;



class CurrentUser extends AbstractApi {

    protected $username;


    public function show($username)
    {
        //@TODO define the user from ?
        return $this->get('users/' . $username);
    }

    public function getUserActivity($username)
    {
        return $this->get($username . '/activity');
    }


} 