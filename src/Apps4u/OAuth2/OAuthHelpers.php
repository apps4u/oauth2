<?php
/**
 * Created by Apps 4 U Pty Ltd.
 * User: Jason Kristian <jasonkristian@gmail.com>
 * Date: 7/09/13
 * Time: 10:12 PM
 *  © 2013 Apps 4 U Pty. Ltd.
 */

if(!function_exists('gen_secret'))
{

    function gen_secret()
    {
        $secret = str_random(40);
        return $secret;
    }
}