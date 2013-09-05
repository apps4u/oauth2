<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 4/09/13
 * Time: 10:45 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\Oauth2;


use League\OAuth2\Server\Storage\ClientInterface;
use DB;

class Client implements ClientInterface
{
    /**
     * Validate a client
     *
     * Example SQL query:
     *
     * <code>
     * # Client ID + redirect URI
     * SELECT oauth_clients.id, oauth_clients.secret, oauth_client_endpoints.redirect_uri, oauth_clients.name
     *  FROM oauth_clients LEFT JOIN oauth_client_endpoints ON oauth_client_endpoints.client_id = oauth_clients.id
     *  WHERE oauth_clients.id = :clientId AND oauth_client_endpoints.redirect_uri = :redirectUri
     *
     * # Client ID + client secret
     * SELECT oauth_clients.id, oauth_clients.secret, oauth_clients.name FROM oauth_clients WHERE
     *  oauth_clients.id = :clientId AND oauth_clients.secret = :clientSecret
     *
     * # Client ID + client secret + redirect URI
     * SELECT oauth_clients.id, oauth_clients.secret, oauth_client_endpoints.redirect_uri, oauth_clients.name FROM
     *  oauth_clients LEFT JOIN oauth_client_endpoints ON oauth_client_endpoints.client_id = oauth_clients.id
     *  WHERE oauth_clients.id = :clientId AND oauth_clients.secret = :clientSecret AND
     *  oauth_client_endpoints.redirect_uri = :redirectUri
     * </code>
     *
     * Response:
     *
     * <code>
     * Array
     * (
     *     [client_id] => (string) The client ID
     *     [client secret] => (string) The client secret
     *     [redirect_uri] => (string) The redirect URI used in this request
     *     [name] => (string) The name of the client
     * )
     * </code>
     *
     * @paramh  string $clientId     The client's ID
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