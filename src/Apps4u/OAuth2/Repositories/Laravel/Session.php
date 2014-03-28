<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 4/09/13
 * Time: 10:47 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\OAuth2\Repositories\Laravel;


use League\OAuth2\Server\Storage\SessionInterface;
use DB;
use Carbon;
class Session implements SessionInterface {

    /**
     *  {@inherited}
     *
     * @api
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
                'owner_id' => $ownerId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ));
        return $id;
    }

    /**
     * {@inherited}
     *
     * @api
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
     * {@inherited}
     *
     * @api
     * @param  int $sessionId   The session ID
     * @param  string $redirectUri The redirect URI
     * @return void
     */
    public function associateRedirectUri($sessionId, $redirectUri)
    {
        DB::table('oauth_session_redirects')->insert(array(
                'session_id' => $sessionId,
                'redirect_uri' => $redirectUri,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ));
    }

    /**
     * {@inherited}
     *
     *@api
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
                'access_token_expires' => $expireTime,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ));
    }

    /**
     * {@inherited}
     *
     * @api
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
                'client_id' => $clientId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ));
    }

    /**
     * {@inherited}
     *
     * @api
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
                'auth_code_expires' => $expireTime,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ));
        return $id;
    }

    /**
     * {@inherited}
     *
     * @api
     * @param  int $sessionId   The session ID
     * @return void
     */
    public function removeAuthCode($sessionId)
    {
        DB::table('oauth_session_authcodes')->where('session_id', '=', $sessionId)
            ->delete();
    }

    /**
     * {@inherited}
     *
     * @api
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
                ->select('oauth_sessions.id AS session_id', 'oauth_session_authcodes.id AS authcode_id')
                ->first();

        // TODO: fix this check that the object returned is like PDO client
        return ($result === false) ? false : (array) $result;
    }

    /**
     * {@inherited}
     *
     * @api
     * @param  string $accessToken The access token
     * @return array|bool              False if invalid or an array as above
     */
    public function validateAccessToken($accessToken)
    {
        // TODO: Implement validateAccessToken() method.
        $result =
            DB::table('oauth_session_access_tokens')
                ->select('session_id', 'oauth_sessions.client_id', 'oauth_sessions.owner_id', 'oauth_sessions.owner_type')
                ->join('oauth_sessions', 'session_id', '=', 'oauth_sessions.id')
                ->where('access_token', '=', $accessToken)
                ->where('access_token_expires', '>=', time())
                ->get();

        return ($result === false) ? false : (array) $result;
    }

    /**
     * {@inherited}
     *
     * @api
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
     * {@inherited}
     *
     * @api
     * @param  string $refreshToken The access token
     * @param  string $clientId     The client ID
     * @return int|bool               The ID of the access token the refresh token is linked to (or false if invalid)
     */
    public function validateRefreshToken($refreshToken, $clientId)
    {
        // TODO: Implement validateRefreshToken() method.
        $result =
            DB::table('oauth_session_refresh_tokens')
                ->select('session_access_token_id')
                ->where('refresh_token', '=', $refreshToken)
                ->where('client_id', '=', $clientId)
                ->where('refresh_token_expires', '>=', time())
                ->get();

        return ($result === false) ? false : $result->session_access_token_id;
    }

    /**
     * {@inherited}
     *
     * @api
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
     * {@inherited}
     *
     * @api
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
                 'scope_id' => $scopeId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ));
    }

    /**
     * {@inherited}
     *
     * @api
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
     * {@inherited}
     *
     * @api
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
                  'scope_id' => $scopeId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ));
    }

    /**
     * {@inherited}
     *
     * @api
     * @param  string $accessToken The access token
     * @return array
     */
    public function getScopes($accessToken)
    {
        // TODO: Implement getScopes() method.
        $result =
            DB::table('oauth_session_token_scopes')
                ->select('oauth_scopes.id', 'oauth_scopes.scope', 'oauth_scopes.name', 'oauth_scopes.description')
                ->join('oauth_session_access_tokens', 'oauth_session_token_scopes.session_access_token_id', '=', 'oauth_session_access_tokens.id')
                ->join('oauth_scopes', 'oauth_session_token_scopes.scope_id', '=', 'oauth_scopes.id')
                ->where('access_token', '=', $accessToken)
                ->get();
        return $result;
    }
}