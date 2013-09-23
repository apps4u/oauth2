<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 22/09/13
 * Time: 8:37 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\Oauth2\Api\V1;

use Platform\Routing\Controllers\ApiController;
use Input;
use Response;
use Sentry;
use Validator;

class Oauth2Controller extends  ApiController
{
    protected $authWhitelist = array(
        'show',
        'create',
        'update',
        'index',
        'destroy'

    );



    /**
     * @api
     * @return array()
     */
    public function index()
    {
       $data = array('key'=>'value');
        return Response::api(compact('data'),200);
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