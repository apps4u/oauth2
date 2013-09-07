<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 4/09/13
 * Time: 10:47 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\OAuth2\Storage\Laravel;


use League\OAuth2\Server\Storage\SessionInterface;
use DB;

class Session implements SessionInterface {

    /**
     * Create a new session
     *
     * Example SQL query:
     *
     * <code>
     * INSERT INTO oauth_sessions (client_id, owner_type,  owner_id)
     *  VALUE (:clientId, :ownerType, :ownerId)
     * </code>
     *
     * @param  string $clientId  The client ID
     * @param  string $ownerType The type of the session owner (e.g. "user")
     * @param  string $ownerId   The ID of the session owner (e.g. "123")
     * @return int               The session ID
     */
    public function createSession($clientId, $ownerType, $ownerId)
    {
        $id = DB::table('oauth_sessions')->insertGetId(array(
                'client_id' => $clientId,
                'owner_type' => $ownerType,
                'owner_id' => $ownerId
            ));
        return $id;
    }

    /**
     * Delete a session
     *
     * Example SQL query:
     *
     * <code>
     * DELETE FROM oauth_sessions WHERE client_id = :clientId AND owner_type = :type AND owner_id = :typeId
     * </code>
     *
     * @param  string $clientId  The client ID
     * @param  string $ownerType The type of the session owner (e.g. "user")
     * @param  string $ownerId   The ID of the session owner (e.g. "123")
     * @return void
     */
    public function deleteSession($clientId, $ownerType, $ownerId)
    {
        DB::table('oauth_sessions')
            ->where('client_id', '=' , $clientId)
            ->where('owner_type', '=' , $ownerType)
            ->where('owner_id', '=' , $ownerType)
            ->delete();
    }

    /**
     * Associate a redirect URI with a session
     *
     * Example SQL query:
     *
     * <code>
     * INSERT INTO oauth_session_redirects (session_id, redirect_uri) VALUE (:sessionId, :redirectUri)
     * </code>
     *
     * @param  int $sessionId   The session ID
     * @param  string $redirectUri The redirect URI
     * @return void
     */
    public function associateRedirectUri($sessionId, $redirectUri)
    {
        DB::table('oauth_session_redirects')->insert(array(
                'session_id' => $sessionId,
                'redirect_uri' => $redirectUri
            ));
    }

    /**
     * Associate an access token with a session
     *
     * Example SQL query:
     *
     * <code>
     * INSERT INTO oauth_session_access_tokens (session_id, access_token, access_token_expires)
     *  VALUE (:sessionId, :accessToken, :accessTokenExpire)
     * </code>
     *
     * @param  int $sessionId   The session ID
     * @param  string $accessToken The access token
     * @param  int $expireTime  Unix timestamp of the access token expiry time
     * @return void
     */
    public function associateAccessToken($sessionId, $accessToken, $expireTime)
    {
        DB::table('oauth_session_access_tokens')->insert(array(
                'session_id' => $sessionId,
                'access_token' => $accessToken,
                'access_token_expires' => $expireTime
            ));
    }

    /**
     * Associate a refresh token with a session
     *
     * Example SQL query:
     *
     * <code>
     * INSERT INTO oauth_session_refresh_tokens (session_access_token_id, refresh_token, refresh_token_expires,
     *  client_id) VALUE (:accessTokenId, :refreshToken, :expireTime, :clientId)
     * </code>
     *
     * @param  int $accessTokenId The access token ID
     * @param  string $refreshToken  The refresh token
     * @param  int $expireTime    Unix timestamp of the refresh token expiry time
     * @param  string $clientId      The client ID
     * @return void
     */
    public function associateRefreshToken($accessTokenId, $refreshToken, $expireTime, $clientId)
    {
        DB::table('oauth_session_refresh_tokens')->insert(array(
                'session_access_token_id' => $accessTokenId,
                'refresh_token' => $refreshToken,
                'refresh_token_expires' => $expireTime,
                'client_id' => $clientId
            ));
    }

    /**
     * Assocate an authorization code with a session
     *
     * Example SQL query:
     *
     * <code>
     * INSERT INTO oauth_session_authcodes (session_id, auth_code, auth_code_expires)
     *  VALUE (:sessionId, :authCode, :authCodeExpires)
     * </code>
     *
     * @param  int $sessionId  The session ID
     * @param  string $authCode   The authorization code
     * @param  int $expireTime Unix timestamp of the access token expiry time
     * @return int                The auth code ID
     */
    public function associateAuthCode($sessionId, $authCode, $expireTime)
    {
        $id = DB::table('oauth_session_authcodes')->insertGetId(array(
                'session_id' => $sessionId,
                'auth_code' => $authCode,
                'auth_code_expires' => $expireTime
            ));
        return $id;
    }

    /**
     * Remove an associated authorization token from a session
     *
     * Example SQL query:
     *
     * <code>
     * DELETE FROM oauth_session_authcodes WHERE session_id = :sessionId
     * </code>
     *
     * @param  int $sessionId   The session ID
     * @return void
     */
    public function removeAuthCode($sessionId)
    {
        DB::table('oauth_session_authcodes')->where('session_id', '=', $sessionId)
            ->delete();
    }

    /**
     * Validate an authorization code
     *
     * Example SQL query:
     *
     * <code>
     * SELECT oauth_sessions.id AS session_id, oauth_session_authcodes.id AS authcode_id FROM oauth_sessions
     *  JOIN oauth_session_authcodes ON oauth_session_authcodes.`session_id` = oauth_sessions.id
     *  JOIN oauth_session_redirects ON oauth_session_redirects.`session_id` = oauth_sessions.id WHERE
     * oauth_sessions.client_id = :clientId AND oauth_session_authcodes.`auth_code` = :authCode
     *  AND `oauth_session_authcodes`.`auth_code_expires` >= :time AND
     *  `oauth_session_redirects`.`redirect_uri` = :redirectUri
     * </code>
     *
     * Expected response:
     *
     * <code>
     * array(
     *     'session_id' =>  (int)
     *     'authcode_id'  =>  (int)
     * )
     * </code>
     *
     * @param  string $clientId    The client ID
     * @param  string $redirectUri The redirect URI
     * @param  string $authCode    The authorization code
     * @return array|bool              False if invalid or array as above
     */
    public function validateAuthCode($clientId, $redirectUri, $authCode)
    {
        $result =
            DB::table('oauth_sessions')
                ->join('oauth_session_authcodes',  ' oauth_sessions.id' , '=', 'oauth_session_authcodes.session_id')
                ->join('oauth_session_redirects', 'oauth_sessions.id', '=', 'oauth_session_redirects.session_id')
                ->where('oauth_sessions.client_id', '=', $clientId)
                ->where('oauth_session_authcodes.auth_code', '=', $authCode)
                ->where('oauth_session_authcodes.auth_code_expires', '>=', time())
                ->where('oauth_session_redirects.redirect_uri', '=', $redirectUri)
                ->select(array(DB::raw('oauth_sessions.id AS session_id, oauth_session_authcodes.id AS authcode_id')));

        // TODO: fix this check that the object returned is like PDO client
        return ($result === false) ? false : (array) $result;
    }

    /**
     * Validate an access token
     *
     * Example SQL query:
     *
     * <code>
     * SELECT session_id, oauth_sessions.`client_id`, oauth_sessions.`owner_id`, oauth_sessions.`owner_type`
     *  FROM `oauth_session_access_tokens` JOIN oauth_sessions ON oauth_sessions.`id` = session_id WHERE
     *  access_token = :accessToken AND access_token_expires >= UNIX_TIMESTAMP(NOW())
     * </code>
     *
     * Expected response:
     *
     * <code>
     * array(
     *     'session_id' =>  (int),
     *     'client_id'  =>  (string),
     *     'owner_id'   =>  (string),
     *     'owner_type' =>  (string)
     * )
     * </code>
     *
     * @param  string $accessToken The access token
     * @return array|bool              False if invalid or an array as above
     */
    public function validateAccessToken($accessToken)
    {
        // TODO: Implement validateAccessToken() method.
        $result =
            DB::table('oauth_session_access_tokens')
                ->join('oauth_sessions', 'session_id', '=', 'oauth_sessions.id')
                ->where('access_token', '=', $accessToken)
                ->where('access_token_expires', '>=', time())
                ->get(array('session_id', 'oauth_sessions.client_id', 'oauth_sessions.owner_id', 'oauth_sessions.owner_type'));

        return ($result === false) ? false : (array) $result;
    }

    /**
     * Removes a refresh token
     *
     * Example SQL query:
     *
     * <code>
     * DELETE FROM `oauth_session_refresh_tokens` WHERE refresh_token = :refreshToken
     * </code>
     *
     * @param  string $refreshToken The refresh token to be removed
     * @return void
     */
    public function removeRefreshToken($refreshToken)
    {
        // TODO: Implement removeRefreshToken() method.
        DB::table('oauth_session_refresh_tokens')
            ->where('id', '=', $refreshToken)
            ->delete();
    }

    /**
     * Validate a refresh token
     *
     * Example SQL query:
     *
     * <code>
     * SELECT session_access_token_id FROM `oauth_session_refresh_tokens` WHERE refresh_token = :refreshToken
     *  AND refresh_token_expires >= UNIX_TIMESTAMP(NOW()) AND client_id = :clientId
     * </code>
     *
     * @param  string $refreshToken The access token
     * @param  string $clientId     The client ID
     * @return int|bool               The ID of the access token the refresh token is linked to (or false if invalid)
     */
    public function validateRefreshToken($refreshToken, $clientId)
    {
        // TODO: Implement validateRefreshToken() method.
        $result =
            DB::table('oauth_session_refresh_tokens')
                ->where('refresh_token', '=', $refreshToken)
                ->where('client_id', '=', $clientId)
                ->where('refresh_token_expires', '>=', time())
                ->get(array('session_access_token_id'));

        return ($result === false) ? false : $result->session_access_token_id;
    }

    /**
     * Get an access token by ID
     *
     * Example SQL query:
     *
     * <code>
     * SELECT * FROM `oauth_session_access_tokens` WHERE `id` = :accessTokenId
     * </code>
     *
     * Expected response:
     *
     * <code>
     * array(
     *     'id' =>  (int),
     *     'session_id' =>  (int),
     *     'access_token'   =>  (string),
     *     'access_token_expires'   =>  (int)
     * )
     * </code>
     *
     * @param  int $accessTokenId The access token ID
     * @return array
     */
    public function getAccessToken($accessTokenId)
    {
        // TODO: Implement getAccessToken() method.
        $result =
            DB::table('oauth_session_access_tokens')
                ->where('id', '=', $accessTokenId)
                ->get();

        return ($result === false) ? false : (array) $result;
    }

    /**
     * Associate scopes with an auth code (bound to the session)
     *
     * Example SQL query:
     *
     * <code>
     * INSERT INTO `oauth_session_authcode_scopes` (`oauth_session_authcode_id`, `scope_id`) VALUES
     *  (:authCodeId, :scopeId)
     * </code>
     *
     * @param  int $authCodeId The auth code ID
     * @param  int $scopeId    The scope ID
     * @return void
     */
    public function associateAuthCodeScope($authCodeId, $scopeId)
    {
        // TODO: Implement associateAuthCodeScope() method.
        DB::table('oauth_session_token_scopes')
            ->insert(array(
                 'session_access_token_id' => $authCodeId,
                 'scope_id' => $scopeId
                ));
    }

    /**
     * Get the scopes associated with an auth code
     *
     * Example SQL query:
     *
     * <code>
     * SELECT scope_id FROM `oauth_session_authcode_scopes` WHERE oauth_session_authcode_id = :authCodeId
     * </code>
     *
     * Expected response:
     *
     * <code>
     * array(
     *     array(
     *         'scope_id' => (int)
     *     ),
     *     array(
     *         'scope_id' => (int)
     *     ),
     *     ...
     * )
     * </code>
     *
     * @param  int $oauthSessionAuthCodeId The session ID
     * @return array
     */
    public function getAuthCodeScopes($oauthSessionAuthCodeId)
    {
        // TODO: Implement getAuthCodeScopes() method.
        $result =
            DB::table('oauth_session_authcode_scopes')
                ->where('oauth_session_authcode_id', '=', $oauthSessionAuthCodeId)
                ->get();

        return $result;
    }

    /**
     * Associate a scope with an access token
     *
     * Example SQL query:
     *
     * <code>
     * INSERT INTO `oauth_session_token_scopes` (`session_access_token_id`, `scope_id`) VALUE (:accessTokenId, :scopeId)
     * </code>
     *
     * @param  int $accessTokenId The ID of the access token
     * @param  int $scopeId       The ID of the scope
     * @return void
     */
    public function associateScope($accessTokenId, $scopeId)
    {
        // TODO: Implement associateScope() method.
        DB::table('oauth_session_token_scopes')
            ->insert(array(
                  'session_access_token_id' => $accessTokenId,
                  'scope_id' => $scopeId
                ));
    }

    /**
     * Get all associated access tokens for an access token
     *
     * Example SQL query:
     *
     * <code>
     * SELECT oauth_scopes.* FROM oauth_session_token_scopes JOIN oauth_session_access_tokens
     *  ON oauth_session_access_tokens.`id` = `oauth_session_token_scopes`.`session_access_token_id`
     *  JOIN oauth_scopes ON oauth_scopes.id = `oauth_session_token_scopes`.`scope_id`
     *  WHERE access_token = :accessToken
     * </code>
     *
     * Expected response:
     *
     * <code>
     * array (
     *     array(
     *         'key'    =>  (string),
     *         'name'   =>  (string),
     *         'description'    =>  (string)
     *     ),
     *     ...
     *     ...
     * )
     * </code>
     *
     * @param  string $accessToken The access token
     * @return array
     */
    public function getScopes($accessToken)
    {
        // TODO: Implement getScopes() method.
        $result =
            DB::table('oauth_session_token_scopes')
                ->join('oauth_session_access_tokens', 'oauth_session_token_scopes.session_access_token_id', '=', 'oauth_session_access_tokens.id')
                ->join('oauth_scopes', 'oauth_session_token_scopes.scope_id', '=', 'oauth_scopes.id')
                ->where('access_token', '=', $accessToken)
                ->get(array('oauth_scopes.id', 'oauth_scopes.scope', 'oauth_scopes.name', 'oauth_scopes.description'));
        return $result;
    }
}