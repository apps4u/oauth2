<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 28/03/2014
 * Time: 3:15 AM
 *  © 2014 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\OAuth2\Facades;


use Illuminate\Support\Facades\Facade;

class ResourceServerFacade extends Facade {

    /**
     * Get the registered name of the component
     *
     * @return string
     * @codeCoverageIgnore
     */
    protected static function getFacadeAccessor()
    {
        return 'resource-server';
    }

} 