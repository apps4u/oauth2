<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 8/09/13
 * Time: 7:37 AM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

namespace Apps4u\Oauth2\Controllers\Admin;

use Platform\Admin\Controllers\Admin\AdminController;
use View;

class ScopesController extends AdminController
{
    public function getIndex()
    {
//        set_active_menu('admin-apps4u-oauth2-scopes');
        return View::make('apps4u/oauth2::scopes/index');
    }
}