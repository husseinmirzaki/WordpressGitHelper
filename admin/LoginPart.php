<?php

trait LoginPart
{
    /*public static $OPTIONS_NAME = 'git_helper_options';

    public static $GIT_HELPER_USER_PASS_SECTION_PASSWORD = 'git_helper_user_pass_section_password';

    public static $GIT_HELPER_TOKEN_SECTION_TOKEN = 'git_helper_token_section_token';

    public static $GIT_HELPER_USER_PASS_SECTION_USERNAME = 'git_helper_user_pass_section_username';*/

    public function setUpAuth()
    {
        $this->authWithToken();
        $this->authWithUserPass();
    }

    public function authWithToken()
    {
        //register a setting
        register_setting($this->menu_slugs[0], self::OPTIONS_NAME);

        //a simple setting to Main Page
        add_settings_section('git_helper_token_section', __('GitHelper Auth With Token', 'mirzaki'), null, $this->menu_slugs[0]);

        //add a field to that page
        add_settings_field(
            self::GIT_HELPER_TOKEN_SECTION_TOKEN, // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __('Token', 'mirzaki'),
            function () {
                printf(
                    '<input type="text" id="git_helper_token_section_token" name="git_helper_options[git_helper_token_section_token]" value="%s" />',
                    isset($this->options['git_helper_token_section_token']) ? esc_attr($this->options['git_helper_token_section_token']) : ''
                );
            },
            $this->menu_slugs[0],
            'git_helper_token_section'
        );
    }

    public function authWithUserPass()
    {
        //register a setting
        register_setting($this->menu_slugs[0], self::OPTIONS_NAME);

        //a simple setting to Main Page
        add_settings_section('git_helper_user_pass_section', __('GitHelper Auth With Username/Password', 'mirzaki'), null, $this->menu_slugs[0]);

        //add a field to that page
        add_settings_field(
            self::GIT_HELPER_USER_PASS_SECTION_USERNAME, // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __('Username', 'mirzaki'),
            function () {
                printf(
                    '<input type="text" id="git_helper_user_pass_section_username" name="git_helper_options[git_helper_user_pass_section_username]" value="%s" />',
                    isset($this->options['git_helper_user_pass_section_username']) ? esc_attr($this->options['git_helper_user_pass_section_username']) : ''
                );
            },
            $this->menu_slugs[0],
            'git_helper_user_pass_section'
        );

        //add a field to that page
        add_settings_field(
            self::GIT_HELPER_USER_PASS_SECTION_PASSWORD, // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __('Password', 'mirzaki'),
            function () {
                printf(
                    '<input type="password" id="git_helper_user_pass_section_password" name="git_helper_options[git_helper_user_pass_section_password]" value="%s" />',
                    isset($this->options['git_helper_user_pass_section_password']) ? esc_attr($this->options['git_helper_user_pass_section_password']) : ''
                );
            },
            $this->menu_slugs[0],
            'git_helper_user_pass_section'
        );
    }

    public function gitHelperMainPage()
    {

        // check user capabilities
        if (!current_user_can('manage_options') && isset($_POST['nonce']) & wp_verify_nonce($_POST['nonce'])) {
            return;
        }

        // add error/update messages

        // check if the user have submitted the settings
        // wordpress will add the "settings-updated" $_GET parameter to the url
        if (isset($_GET['settings-updated'])) {
            // add settings saved message with the class of "updated"
            add_settings_error('git_helper_messages', 'git_helper_message', __('Settings Saved', 'mirzaki'), 'updated');
        }

        // show error/update messages
        settings_errors('git_helper_messages');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce() ?>">
                <?php
                // output security fields for the registered setting "wporg"
                settings_fields($this->menu_slugs[0]);
                // output setting sections and their fields
                // (sections are registered for "wporg", each field is registered to a specific section)
                do_settings_sections($this->menu_slugs[0]);
                // output save settings button
                submit_button('Save Settings');
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * @return bool
     */
    public function checkForPassOrToken()
    {
        return $this->hasToken() || $this->hasUserPass();
    }

    /**
     * @return bool
     */
    public function hasToken()
    {
        return $this->hasOptions($this->options,self::GIT_HELPER_TOKEN_SECTION_TOKEN) &&
            !empty($this->options[self::GIT_HELPER_TOKEN_SECTION_TOKEN]);
    }

    /**
     * @return bool
     */
    public function hasUserPass()
    {
        return
            $this->hasOptions($this->options,self::GIT_HELPER_USER_PASS_SECTION_USERNAME) &&
            $this->hasOptions($this->options,self::GIT_HELPER_USER_PASS_SECTION_PASSWORD) &&
            !empty($this->options[self::GIT_HELPER_USER_PASS_SECTION_PASSWORD]) &&
            !empty($this->options[self::GIT_HELPER_USER_PASS_SECTION_USERNAME]);
    }

    public function getToken()
    {
        return $this->hasToken() ? $this->options[self::GIT_HELPER_TOKEN_SECTION_TOKEN] : '';
    }

    public function getUserPass()
    {
        return $this->hasUserPass() ? [
            'username' => $this->options[self::GIT_HELPER_USER_PASS_SECTION_USERNAME],
            'password' => $this->options[self::GIT_HELPER_USER_PASS_SECTION_PASSWORD]
        ] : '';
    }
}