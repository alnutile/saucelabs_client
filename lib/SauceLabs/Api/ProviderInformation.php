<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/10/14
 * Time: 1:44 PM
 */

namespace SauceLabs\Api;


class ProviderInformation  extends AbstractApi {

    public function status()
    {
        //@TODO define the user from ?
        return $this->get('info/status');
    }

} 