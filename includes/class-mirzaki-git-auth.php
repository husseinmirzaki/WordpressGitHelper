<?php
/**
 * Created by PhpStorm.
 * User: Hussein Mirzaki
 * Date: 9/14/2018
 * Time: 12:37 PM
 */

class MirzakiGitAuth
{

    public $client;

    public function __construct()
    {
        // Does current user has enough permission
        if (!current_user_can('manage_options'))
            return;

        $this->client = new \Github\Client;
        // The options for github auth
        $get_option = get_option(Mirzaki_Admin::$options_name);

        // We will use the token first if is avail-able
        if (isset($get_option['git_helper_token_section_token'])) {
            $tokenOrLogin = $get_option['git_helper_token_section_token'];
            $this->client->authenticate($tokenOrLogin, null, \Github\Client::AUTH_HTTP_TOKEN);
        } elseif (isset($get_option['git_helper_user_pass_section_username']) && isset($get_option['git_helper_user_pass_section_password'])) {
            $username = $get_option['git_helper_user_pass_section_username'];
            $password = $get_option['git_helper_user_pass_section_password'];
            $this->client->authenticate($username, $password, \Github\Client::AUTH_HTTP_PASSWORD);
        }

        // Send github client in global
        $GLOBALS['client'] = $this->client;
    }



}