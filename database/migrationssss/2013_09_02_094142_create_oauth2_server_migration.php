<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOauth2ServerMigration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//            // Create Schema for OAuth2-server
//          Schema::create('oauth_clients', function(Blueprint $table){
//                  $table->engine = "InnoDB";
//                  // auto incremental id (PK)
//                  $table->string('id',40)->primary();
//                  $table->string('secret',40);
//                  $table->string('name',255);
//                  $table->tinyInteger('auto_approve')->default('0');
//                  $table->unique('secret');
//
//                  // created_at | updated_at DATETIME
//                  $table->timestamps();
//                  });
//          Schema::create('oauth_client_endpoints', function(Blueprint $table){
//
//                  $table->engine = "InnoDB";
//                  // auto incremental id (PK)
//                  $table->increments('id');
//                  // link to oauth_clients on clients_id to id
//                  $table->integer('clients_id',false,40);
//                  $table->string('redirect_uri',255);
//                  // created_at | updated_at DATETIME
//                  $table->timestamps();
//
////                  $table->foreign('clients_id')->references('id')->on('oauth_clients')->onDelete('cascade')->onUpdate('cascade');
//
//              });
//          Schema::create('oauth_sessions', function(Blueprint $table){
//
//                  $table->engine = "InnoDB";
//                  // auto incremental id (PK)
//                  $table->increments('id');
//                  // link to oauth_clients on clients_id to id
//                  $table->string('client_id',40);
//                  $table->enum('owner_type',array('user','client'))->default('user');
//                  $table->string('owner_id',255)->index();
//                  // created_at | updated_at DATETIME
//                  $table->timestamps();
//                  $table->index(array('client_id','owner_type','owner_id'));
//                  $table->foreign('client_id')->references('id')->on('oauth_clients')->onDelete('cascade')->onUpdate('cascade');
//
//              });
//          Schema::create('oauth_session_access_tokens', function(Blueprint $table){
//
//                  $table->engine = "InnoDB";
//                  // auto incremental id (PK)
//                  $table->increments('id');
//                  $table->unsignedInteger('session_id',false)->index();
//                  $table->string('access_token',40);
//                  $table->unsignedInteger('access_token_expires',false);
//                  // created_at | updated_at DATETIME
//                  $table->timestamps();
//                  $table->unique(array('access_token','session_id'));
//
//                  $table->foreign('session_id')->references('id')->on('oauth_sessions')->onDelete('cascade');
//              });
//          Schema::create('oauth_session_authcodes', function(Blueprint $table){
//
//                  $table->engine = "InnoDB";
//                  // auto incremental id (PK)
//                  $table->increments('id');
//                  $table->unsignedInteger('session_id',false)->unique();
//                  $table->string('auth_code',40);
//                  $table->unsignedInteger('auth_code_expires');
//                  // created_at | updated_at DATETIME
//                  $table->timestamps();
//
//                  $table->foreign('session_id')->references('id')->on('oauth_sessions')->onDelete('cascade');
//
//              });
//          Schema::create('oauth_session_redirects', function(Blueprint $table){
//
//                  $table->engine = "InnoDB";
//                  // auto incremental session_id (PK)
//                  $table->unsignedInteger('session_id',false)->primary();
//                  $table->string('redirect_url',255);
//                  // created_at | updated_at DATETIME
//                  $table->timestamps();
//
//                  $table->foreign('session_id')->references('id')->on('oauth_sessions')->onDelete('cascade')->onUpdate('cascade');
//
//              });
//          Schema::create('oauth_session_refresh_tokens', function(Blueprint $table){
//
//                  $table->engine = "InnoDB";
//                  // auto incremental session_access_token_id (PK)
//                  $table->unsignedInteger('session_access_token_id')->primary();
//                  $table->string('refresh_token',40);
//                  $table->unsignedInteger('refresh_token_expires',false);
//                  $table->string('client_id',40)->index();
//                  // created_at | updated_at DATETIME
//                  $table->timestamps();
//
//                  $table->foreign('client_id')->references('id')->on('oauth_clients')->onDelete('cascade')->onUpdate('cascade');
//                  $table->foreign('session_access_token_id')->references('id')->on('oauth_session_access_tokens')->onDelete('cascade');
//
//              });
//          Schema::create('oauth_scopes', function(Blueprint $table){
//
//                  $table->engine = "InnoDB";
//                  // auto incremental id (PK)
//                  $table->increments('id');
//                  $table->string('scope',255)->unique();
//                  $table->string('name',255);
//                  $table->string('description');
//                  // created_at | updated_at DATETIME
//                  $table->timestamps();
//              });
//          Schema::create('oauth_session_token_scopes', function(Blueprint $table){
//
//                  $table->engine = "InnoDB";
//                  // auto incremental id (PK)
//                  $table->increments('id');
//                  $table->unsignedInteger('session_access_token_id',false);
//                  $table->unsignedInteger('scope_id',false)->index();
//                  // created_at | updated_at DATETIME
//                  $table->timestamps();
////                  $table->unique(array('session_access_token_id','scope_id'));
//
//                  $table->foreign('session_access_token_id')->references('id')->on('oauth_session_access_tokens')->onDelete('cascade');
//                  $table->foreign('scope_id')->references('id')->on('oauth_scopes')->onDelete('cascade');
//
//
//              });
//          Schema::create('oauth_session_authcode_scopes', function(Blueprint $table){
//
//                  $table->engine = "InnoDB";
//                  $table->unsignedInteger('oauth_session_authcode_id')->index();
//                  $table->unsignedInteger('scope_id',false)->index();
//                  // created_at | updated_at DATETIME
//                  $table->timestamps();
//
//                  $table->foreign('scope_id')->references('id')->on('oauth_scopes')->onDelete('cascade');
//                  $table->foreign('oauth_session_authcode_id')->references('id')->on('oauth_session_authcodes')->onDelete('cascade');
//
//              });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
//          Schema::drop('oauth_session_authcode_scopes');
//          Schema::drop('oauth_session_token_scopes');
//          Schema::drop('oauth_scopes');
//          Schema::drop('oauth_session_refresh_tokens');
//          Schema::drop('oauth_session_redirects');
//          Schema::drop('oauth_session_authcodes');
//          Schema::drop('oauth_session_access_tokens');
//          Schema::drop('oauth_sessions');
//          Schema::drop('oauth_client_endpoints');
//          Schema::drop('oauth_clients');
	}
}