<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 4/09/13
 * Time: 10:45 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\OAuth2\Storage\Laravel;


use League\OAuth2\Server\Storage\ClientInterface;
use DB;

class Client implements ClientInterface
{
    /**
     * {@inherited}
     *
     * @api
     * @param  string $clientId     The client's ID
     * @param  string $clientSecret The client's secret (default = "null")
     * @param  string $redirectUri  The client's redirect URI (default = "null")
     * @param  string $grantType    The grant type used in the request (default = "null")
     * @return bool|array               Returns false if the validation fails, array on success
     */
    public function getClient($clientId, $clientSecret = null, $redirectUri = null, $grantType = null)
    {
        // TODO: Implement getClient() method.
        if (!is_null($redirectUri) && is_null($clientSecret)) {
            $result = DB::table('oauth_clients')
                ->join('oauth_client_endpoints','oauth_client_endpoints.client_id', '=', 'oauth_clients.id')
                ->where('oauth_clients.id',$clientId)
                ->where('oauth_client_endpoints.redirect_uri',$redirectUri)
                ->select('oauth_clients.id','oauth_clients.secret', 'oauth_client_endpoints.redirect_uri', 'oauth_clients.name');
        }
        elseif (!is_null($clientSecret) && is_null($redirectUri))
        {
            $result = DB::table('oauth_clients')
                ->where('id',$clientId)
                ->where('secret',$clientSecret)
                ->select('id','secret', 'name');
        }
        elseif (!is_null($clientSecret) && !is_null($redirectUri))
        {
            $result = DB::table('oauth_clients')
                ->join('oauth_client_endpoints', 'oauth_client_endpoints.client_id', '=', 'oauth_clients.id' )
                ->where('oauth_clients.id', $clientId)
                ->where('oauth_clients.secret', $clientSecret)
                ->where('oauth_client_endpoints.redirect_uri', $redirectUri)
                ->select('oauth_clients.id', 'oauth_clients.secret', 'oauth_client_endpoints.redirect_uri', 'oauth_clients.name');
        }

        return array(
            'client_id' =>  $result->id,
            'client_secret' =>  $result->secret,
            'redirect_uri'  =>  (isset($result->redirect_uri)) ? $result->redirect_uri : null,
            'name'  =>  $result->name
        );
    }


}