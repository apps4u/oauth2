<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 4/09/13
 * Time: 10:48 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\OAuth2\Storage\Laravel;


use League\OAuth2\Server\Storage\ScopeInterface;
use DB;

class Scope implements ScopeInterface
{

    /**
     * {@inherited}
     *
     * @api
     * @param  string $scope     The scope
     * @param  string $clientId  The client ID (default = "null")
     * @param  string $grantType The grant type used in the request (default = "null")
     * @return bool|array If the scope doesn't exist return false
     */
    public function getScope($scope, $clientId = null, $grantType = null)
    {
        // TODO: Implement getScope() method.
        return DB::table('oauth_scopes')->where('scope', $scope)->get();
    }
}