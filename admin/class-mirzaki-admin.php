<?php

/**
 * The admin_specific functionality of the plugin.
 *
 * @link       http://husseinmirzaki.ir
 * @since      0.0.1
 *
 * @package    Mirzaki
 * @subpackage Mirzaki/admin
 */

/**
 * The admin_specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin_specific stylesheet and JavaScript.
 *
 * @package    Mirzaki
 * @subpackage Mirzaki/admin
 * @author     Seyed Hussein Mirzaki <husseinmirzaki@gmail.com>
 */
class Mirzaki_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    0.0.1
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    0.0.1
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    private $options;

    /**
     * Initialize the class and set its properties.
     *
     * @since    0.0.1
     *
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version     The version of this plugin.
     */
    private $options_name = 'git_helper_options';

    private $menu_slug = 'git_helper_main_page';

    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    0.0.1
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Mirzaki_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Mirzaki_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/mirzaki_admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    0.0.1
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Mirzaki_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Mirzaki_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/mirzaki_admin.js', array('jquery'), $this->version, false);

    }

    public function add_setting_GitHelper()
    {
        $this->options = get_option($this->options_name);
        $this->authWithToken();
        $this->authWithUserPass();

    }

    public function add_GitHelper_admin_menu()
    {
        // add a menu slut fot the plugin
        add_menu_page('GitHelper', 'GitHelper', 'manage_options', $this->menu_slug, [$this, 'GiHelper_main_page']);

    }

    public function GiHelper_main_page()
    {

        // check user capabilities
        if (!current_user_can('manage_options')) {
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
                <?php
                // output security fields for the registered setting "wporg"
                settings_fields($this->menu_slug);
                // output setting sections and their fields
                // (sections are registered for "wporg", each field is registered to a specific section)
                do_settings_sections($this->menu_slug);
                // output save settings button
                submit_button('Save Settings');
                ?>
            </form>
        </div>
        <?php

    }

    public function authWithToken()
    {
        //register a setting
        register_setting($this->menu_slug, $this->options_name);

        //a simple setting to Main Page
        add_settings_section('git_helper_token_section', __('GitHelper Auth With Token', 'mirzaki'), null, $this->menu_slug);

        //add a field to that page
        add_settings_field(
            'git_helper_token_section_token', // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __('Token', 'mirzaki'),
            function () {
                printf(
                    '<input type="text" id="git_helper_token_section_token" name="git_helper_options[git_helper_token_section_token]" value="%s" />',
                    isset($this->options['git_helper_token_section_token']) ? esc_attr($this->options['git_helper_token_section_token']) : ''
                );
            },
            $this->menu_slug,
            'git_helper_token_section'
        );
    }

    public function authWithUserPass()
    {
        //register a setting
        register_setting($this->menu_slug, $this->options_name);

        //a simple setting to Main Page
        add_settings_section('git_helper_user_pass_section', __('GitHelper Auth With Username/Password', 'mirzaki'), null, $this->menu_slug);

        //add a field to that page
        add_settings_field(
            'git_helper_user_pass_section_username', // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __('Username', 'mirzaki'),
            function () {
                printf(
                    '<input type="text" id="git_helper_user_pass_section_username" name="git_helper_options[git_helper_user_pass_section_username]" value="%s" />',
                    isset($this->options['git_helper_user_pass_section_username']) ? esc_attr($this->options['git_helper_user_pass_section_username']) : ''
                );
            },
            $this->menu_slug,
            'git_helper_user_pass_section'
        );

        //add a field to that page
        add_settings_field(
            'git_helper_user_pass_section_password', // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __('Password', 'mirzaki'),
            function () {
                printf(
                    '<input type="password" id="git_helper_user_pass_section_password" name="git_helper_options[git_helper_user_pass_section_password]" value="%s" />',
                    isset($this->options['git_helper_user_pass_section_password']) ? esc_attr($this->options['git_helper_user_pass_section_password']) : ''
                );
            },
            $this->menu_slug,
            'git_helper_user_pass_section'
        );
    }

}
