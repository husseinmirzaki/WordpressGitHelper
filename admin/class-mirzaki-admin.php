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
    use MainPagePart;
    use LoginPart;
    use GitHubClient;
    use ShowRepositoriesPart;
    use ShowBranchesPart;
    use ShowCommitsPart;
    use ShowCommitPart;
    use Utilities;

    const REPOSITORIES_OPTION = 'git_helper_options_repositories';
    const BRANCHES_OPTION = 'git_helper_options_branches';
    const COMMITS_OPTION = 'git_helper_options_commits';
    const COMMIT_OPTION = 'git_helper_options_commit';
    const OPTIONS_NAME = 'git_helper_options';
    const GIT_HELPER_USER_PASS_SECTION_PASSWORD = 'git_helper_user_pass_section_password';
    const GIT_HELPER_TOKEN_SECTION_TOKEN = 'git_helper_token_section_token';
    const GIT_HELPER_USER_PASS_SECTION_USERNAME = 'git_helper_user_pass_section_username';
    const GIT_HELPER_DIR_TO_SAVE = 'git_helper_dir_to_save';
    /**
     * an array of all available options
     * @var array
     */
    protected $options;

    /**
     * an array of created menu items
     * @var array
     */
    protected $menu_slugs = ['git_helper_main_page', 'git_helper_pull_sth'];

    /**
     * plugin's name
     * @var string
     */
    private $plugin_name;

    /**
     * plugin's version
     * @var string
     */
    private $version;

    /**
     * plugin's name
     * @var $currentUser \Github\Api\CurrentUser
     */
    private $currentUser;

    public function __construct($plugin_name, $version, $client = 'default')
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->options = get_option(self::OPTIONS_NAME);
        try {

            if ($this->checkForPassOrToken() && $client === 'default') {
                $this->client = new \Github\Client;
                if ($this->hasToken()) {
                    $this->client->authenticate($this->getToken(), null, Github\Client::AUTH_HTTP_TOKEN);
                    $this->currentUser = $this->client->currentUser()->show();
                } elseif ($this->hasUserPass()) {
                    $userPass = $this->getUserPass();
                    $this->client->authenticate($userPass['username'], $userPass['password'], Github\Client::AUTH_HTTP_PASSWORD);
                    $this->currentUser = $this->client->currentUser()->show();
                }
                if (!$this->client) {
                    exit();
                }
            }
        } catch (Exception $exception) {
        }
    }

    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/mirzaki_admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/mirzaki_admin.js', array('jquery'), $this->version, false);
    }

    public function adminInitGitHelperHook()
    {
        $this->setUpAuth();
        $this->setUpShowRepositoryPage();
    }

    public function adminMenuGitHelperHook()
    {
        // add a menu slut fot the plugin
        $this->setUpMainPageMenu();
        $this->setUpShowRepositoryPageMenu();

    }


}
