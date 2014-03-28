<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 7/09/13
 * Time: 10:05 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\Oauth2\Controllers\Admin;


use Platform\Admin\Controllers\Admin\AdminController;
use View;

class ClientsController extends AdminController
{

   public function getIndex()
    {
//        set_active_menu('admin-apps4u-oauth2-clients');
        return View::make('apps4u/oauth2::clients/index');
    }
}