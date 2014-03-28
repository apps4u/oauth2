<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 28/03/2014
 * Time: 3:13 AM
 *  © 2014 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\OAuth2\Facades;

use Illuminate\Support\Facades\Facade;

class AuthorisationServerFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'authorization-server';
    }
} 