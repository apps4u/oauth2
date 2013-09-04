<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 3/09/13
 * Time: 12:16 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */


use Platform\Routing\Controllers\BaseController;
use View;

class Oauth2Controller  extends BaseController
{
    public function getIndex()
    {
        return View::make('');
    }
}