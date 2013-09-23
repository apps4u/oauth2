<?php
/**
 * An Eloquent Model: 'Apps4u\Oauth2\Models\Scope'
 *
 * @property integer $id
 * @property string $scope
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

namespace Apps4u\Oauth2\Models;

use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    protected $table = 'oauth_scopes';

}