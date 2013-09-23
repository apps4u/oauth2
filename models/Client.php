<?php
/**
 * An Eloquent Model: 'Apps4u\Oauth2\Models\Client'
 *
 * @property string $id
 * @property string $secret
 * @property string $name
 * @property boolean $auto_approve
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

namespace Apps4u\Oauth2\Models;


use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'oauth_clients';
}