BETA still work in progress
Edit
oauth2
======

Porting league/oauth2-server to be used in a Laravel 4 or Cartalyst Platform2 application. Including working with Sentry.

I taking league/oauth2-server as a starting point and Im going to get it working with Cartalyst Platform2 first. Im going to have a admin dashboard to create Oauth scopes and display graphs showing OAuth usage. Im also creating a few frontend pages so users of your application can log in and create there OAuth2 token + secret. I would like to have it work with out Platform 2 but my main effort to start with is getting it working with Cartalyst (Api, Sentry, Platform2) packages once that is done and there is interest in getting it to work in other instances please help out all pull request are welcome.

Configure
=========
### Larvel 4
If you’d like to migrate tables, simply run `php artisan migrate --package=apps4u/oauth2` from the command line. Of course, feel free to write your own migrations which insert the correct tables if you’d like

### Platform 2
Just install and enable the extension from the operation page and the migration will be run for you and there is no need to add any service providers or publish and configuration files as platform 2 will take care of all that for you.
Once installed go to the Oauth admin page and create your scopes that you want manage by this extension it is designed to allow external API requests.
