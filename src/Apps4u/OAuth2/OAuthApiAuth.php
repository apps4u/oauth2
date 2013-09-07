<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 7/09/13
 * Time: 9:56 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\Oauth2;


use Cartalyst\Api\Auth\AuthInterface;
use Cartalyst\Api\Auth\Illuminate;
use Illuminate\Http\Request;

class OAuthApiAuth implements AuthInterface
{

    /**
     * Authenticate a user for the current request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    public function authenticate(Request $request)
    {
        // TODO: Implement authenticate() method.
    }
}