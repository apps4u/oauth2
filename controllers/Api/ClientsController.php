<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 7/09/13
 * Time: 10:06 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\Oauth2\Api\V1;


use Platform\Routing\Controllers\ApiController;
use Input;
use Response;
use Sentry;
use Validator;
use Apps4u\Oauth2\Models\Client;

class ClientsController extends ApiController
{
    /**
     * @var \Apps4u\Oauth2\Models\Client
     */
    protected $model;
    /**
     * Array of whitelisted methods which
     * do not need to be authorized.
     *
     * @var array
     */
    protected $authWhitelist = array(
        'show',
        'create',
        'update',
        'index',
        'destroy'

    );

    function __construct()
    {
        parent::__construct();
        $this->model = app('Apps4u\Oauth2\Models\Client');
    }

    /**
     * @api
     * @return \Cartalyst\Api\Http\Response
     */
    public function index()
    {
        $data = $this->model->all();
        return Response::api(compact('data'), 200);
    }

    /**
     *
     * @return \Cartalyst\Api\Http\Response
     */
    public function create()
    {
        return Response::api(array('create' => 'create'));
    }

    /**
     *
     * @param null $id
     * @return \Cartalyst\Api\Http\Response
     */
    public function update($id = null)
    {
        return Response::api(array('edit' => $id));
    }

    /**
     *
     * @param null $id
     * @return \Cartalyst\Api\Http\Response
     */
    public function destroy($id = null)
    {
        return Response::api(array('destroy' => $id));
    }


}