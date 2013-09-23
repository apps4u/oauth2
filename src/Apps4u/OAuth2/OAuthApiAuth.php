<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 7/09/13
 * Time: 9:56 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\OAuth2;


use Cartalyst\Api\Auth\AuthInterface;
use Cartalyst\Api\Auth\Illuminate;
use Illuminate\Http\Request;
use League\OAuth2\Server\Resource;
use Apps4u\OAuth2\Storage\Laravel\Session;
use League\OAuth2\Server\Exception\InvalidAccessTokenException;
use Response;
use Log;

class OAuthApiAuth implements AuthInterface
{
    function __construct()
    {
        $this->request = new \League\OAuth2\Server\Util\Request();
        $this->server = new Resource(new Session());
    }

    /**
     * Authenticate a user for the current request.
     *
     * @api
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    public function authenticate(Request $request)
    {
        try {
            $this->server->isValid();
        }
            // The access token is missing or invalid...
        catch (InvalidAccessTokenException $e)
        {
            Log::alert('api Oauth2 failed');
            return  Response::api(array('error' => $e->getMessage(),401));
        }

    }
}