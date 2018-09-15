<?php

trait ShowRepositoriesPart
{

    //    public static REPOSITORIES_OPTION = 'git_helper_options_repositories';


    public function setUpShowRepositoryPageMenu()
    {
        add_submenu_page($this->menu_slugs[0], 'Pull Sth', 'Pull Sth', 'manage_options', $this->menu_slugs[1], [$this, 'showRepositories']);
    }

    public function showRepositories()
    {
        $url = $_SERVER['REQUEST_URI'];
        if (($rep = $this->getOptions($_GET, 'repository')) && ($bra = $this->getOptions($_GET, 'branch')) && ($com = $this->getOptions($_GET, 'commit')) && ($pull = $this->getOptions($_GET, 'pull')) && ($fi = $this->getOptions($_GET, 'file'))) {
            set_time_limit(0);
            $option = self::COMMIT_OPTION . '_' . esc_attr($rep) . '_' . esc_attr($bra) . '_' . esc_attr($com);
            $commit = null;
            if (!$this->hasOptions($_GET, 'reset_cache')) {
                $commit = get_option($option);
            }
            $dir = $this->getDirectoryToSave();
            if (!file_exists($dir)) {
                mkdir($dir);
            }
            $commit = json_decode($commit);
            $files = $commit->files;
            foreach ($files as $file) {
                if ($file->sha !== $fi)
                    continue;
                $path = $dir;
                $address = $file->filename;
                $raw_url = $file->raw_url;
                $status = $file->status;
                $separated_parts = preg_split('/\//', $address);
                foreach ($separated_parts as $index => $separated_part) {
                    $path .= '/' . $separated_part;
                    if ($index == count($separated_parts) - 1) {
                        if ($status === 'modified' || $status === 'added') {
                            $rs = fopen($path, 'w+');
                            if (!$text = file_get_contents($raw_url)) {
                                if (!$text = file_get_contents($raw_url)) {
                                    if (!$text = file_get_contents($raw_url)) {
                                        if (!$text = file_get_contents($raw_url)) {
                                            if (!$text = file_get_contents($raw_url)) {
                                                echo "Refresh to do it again some problem with server";
                                                exit();
                                            }
                                        }
                                    }
                                }
                            }
                            fwrite($rs, $text);
                            fclose($rs);
                            continue;
                        } elseif ($status === 'removed') {
                            unlink($path);
                            continue;
                        }
                    }
                    if (!file_exists($path)) {
                        mkdir($path);
                    }

                }
            }

            header('location:'.substr($url, 0, stripos($url, '&pull')));

        } elseif (($rep = $this->getOptions($_GET, 'repository')) && ($bra = $this->getOptions($_GET, 'branch')) && ($com = $this->getOptions($_GET, 'commit')) && ($pull = $this->getOptions($_GET, 'pull'))) {
            set_time_limit(0);
            $option = self::COMMIT_OPTION . '_' . esc_attr($rep) . '_' . esc_attr($bra) . '_' . esc_attr($com);
            $commit = null;
            if (!$this->hasOptions($_GET, 'reset_cache')) {
                $commit = get_option($option);
            }
            $dir = $this->getDirectoryToSave();
            if (!file_exists($dir)) {
                mkdir($dir);
            }
            $commit = json_decode($commit);
            $files = $commit->files;
            foreach ($files as $file) {
                $path = $dir;
                $address = $file->filename;
                $raw_url = $file->raw_url;
                $status = $file->status;
                $separated_parts = preg_split('/\//', $address);
                foreach ($separated_parts as $index => $separated_part) {
                    $path .= '/' . $separated_part;
                    if ($index == count($separated_parts) - 1) {
                        if ($status === 'modified' || $status === 'added') {
                            $rs = fopen($path, 'w+');
                            if (!$text = file_get_contents($raw_url)) {
                                if (!$text = file_get_contents($raw_url)) {
                                    if (!$text = file_get_contents($raw_url)) {
                                        if (!$text = file_get_contents($raw_url)) {
                                            if (!$text = file_get_contents($raw_url)) {
                                                echo "Refresh to do it again some problem with server";
                                                exit();
                                            }
                                        }
                                    }
                                }
                            }
                            fwrite($rs, $text);
                            fclose($rs);
                            continue;
                        } elseif ($status === 'removed') {
                            unlink($path);
                            continue;
                        }
                    }
                    if (!file_exists($path)) {
                        mkdir($path);
                    }

                }
            }
            header('location:'.substr($url, 0, stripos($url, '&pull')));
        } elseif (($rep = $this->getOptions($_GET, 'repository')) && ($bra = $this->getOptions($_GET, 'branch')) && ($com = $this->getOptions($_GET, 'commit'))) {
            $option = self::COMMIT_OPTION . '_' . esc_attr($rep) . '_' . esc_attr($bra) . '_' . esc_attr($com);
            $commit = null;
            if (!$this->hasOptions($_GET, 'reset_cache')) {
                $commit = get_option($option);
            } else {
                $url = substr($url, 0, stripos($url, '&reset'));
            }
            if (empty($commit)) {
                update_option($option, $commit = $this->get('/repos/' . $this->currentUser['login'] . '/' . $rep . '/commits/' . $com));

                if (empty($commit)) {
                    echo "refresh page";
                    exit();
                }
            }
            $commit = json_decode($commit);
            ?>
            <div class="bootstraped" style="width: 100%">
                <div class="container col-12">
                    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
                    <div class="row justify-content-center">
                        <div class="card col-11">
                            <div class="card-header font-weight-bold">Commit of <?php echo $bra ?> of <?php echo $rep ?> Repository !
                                <a href="<?php echo substr($url, 0, stripos($url, '&commit')) ?>" class="float-right btn btn-danger ml-2">Back</a>
                                <a href="<?php echo esc_url($url . '&reset_cache=1') ?>" class="btn btn-info float-right ml-2" title="Reset Cache">RC</a>
                                <a href="<?php echo esc_url($url . '&pull=1') ?>" class="btn btn-warning float-right" title="Pull commit <?php echo $commit->sha ?>">Pull</a>
                                <p>Message : <?php echo $commit->commit->message ?></p>
                            </div>
                            <div class="card-body">
                                <p class="alert alert-success"> A view of files which are going to be deleted or added to the project directory <a href="<?php echo substr($url, 0, stripos($url, '&repository')) ?>">here</a></p>
                                <div class="row">
                                    <?php foreach ($commit->files as $file): ?>
                                        <div class="col col-4 mb-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a href="<?php echo esc_url($file->raw_url) ?>">
                                                        <?php echo $file->filename ?>
                                                    </a>
                                                    <a href="<?php echo esc_url($url . '&pull=1&file=' . $file->sha) ?>" class="btn btn-warning float-right" title="Pull <?php echo $file->filename ?>">
                                                        Pull
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } elseif (($rep = $this->getOptions($_GET, 'repository')) && ($bra = $this->getOptions($_GET, 'branch'))) {
            $option = self::COMMITS_OPTION . '_' . esc_attr($rep) . '_' . esc_attr($bra);
            $commits = null;
            if (!$this->hasOptions($_GET, 'reset_cache')) {
                $commits = get_option($option);
            } else {
                $url = substr($url, 0, stripos($url, '&reset'));
            }
            if (empty($commits)) {
                update_option($option, $commits = $this->get('/repos/' . $this->currentUser['login'] . '/' . $rep . '/commits'));

                if (empty($commits)) {
                    echo "refresh page";
                    exit();
                }
            }
            $commits = json_decode($commits);
            ?>
            <div class="bootstraped" style="width: 100%">
                <div class="container col-12">
                    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
                    <div class="row justify-content-center">
                        <div class="card col-11">
                            <div class="card-header font-weight-bold">Commits of <?php echo $bra ?> of <?php echo $rep ?>
                                <a href="<?php echo substr($url, 0, stripos($url, '&branch')) ?>" class="float-right btn btn-danger ml-2">Back</a>
                                <a href="<?php echo esc_url($url . '&reset_cache=1') ?>" class="btn btn-danger float-right" title="Reset Cache">RC</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($commits as $commit): ?>
                                        <div class="col col-4 mb-2">
                                            <a href="<?php echo esc_url($url . '&commit=' . $commit->sha) ?>">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <?php echo $commit->commit->message ?>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } elseif ($rep = $this->getOptions($_GET, 'repository')) {
            $option = self::BRANCHES_OPTION . '_' . esc_attr($rep);
            $branches = null;
            if (!$this->hasOptions($_GET, 'reset_cache')) {
                $branches = get_option($option);
            } else {
                $url = substr($url, 0, stripos($url, '&reset'));
            }
            if (empty($branches)) {
                update_option($option, $branches = $this->get('/repos/' . $this->currentUser['login'] . '/' . $rep . '/branches'));

                if (empty($branches)) {
                    echo "refresh page";
                    exit();
                }
            }
            $branches = json_decode($branches);
            ?>
            <div class="bootstraped" style="width: 100%">
                <div class="container col-12">
                    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
                    <div class="row justify-content-center">
                        <div class="card col-11">
                            <div class="card-header font-weight-bold">Branches of <?php echo $rep ?>
                                <a href="<?php echo substr($url, 0, stripos($url, '&repository')) ?>" class="float-right btn btn-danger ml-2">Back</a>
                                <a href="<?php echo esc_url($url . '&reset_cache=1') ?>" class="btn btn-danger float-right" title="Reset Cache">RC</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($branches as $branch): ?>
                                        <div class="col col-4 mb-2">
                                            <a href="<?php echo esc_url($url . '&branch=' . $branch->name) ?>">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <?php echo $branch->name ?>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            $option = self::REPOSITORIES_OPTION;
            $repositories = null;
            if (!$this->hasOptions($_GET, 'reset_cache')) {
                $repositories = get_option($option);
            } else {
                $url = substr($url, 0, stripos($url, '&reset_cache'));
            }
            if ($this->getOptions($_GET, 'reset_cache_directory')) {
                $options = get_option(self::OPTIONS_NAME);
                $options[self::GIT_HELPER_DIR_TO_SAVE] = '';
                update_option(self::OPTIONS_NAME, $options);
            }
            if (empty($repositories)) {
                update_option($option, $repositories = $this->get('/users/' . $this->currentUser['login'] . '/repos'));

                if (empty($repositories)) {
                    echo "refresh page";
                    exit();
                }
            }
            $repositories = json_decode($repositories);
            ?>
            <div class="bootstraped" style="width: 100%">
                <div class="container col-12">
                    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
                    <div class="row justify-content-center">

                        <div class="card col-11">
                            <div class="card-header font-weight-bold">Repositories of <?php echo $this->currentUser['login'] ?>
                                <a href="<?php echo esc_url($url . '&reset_cache=1') ?>" class="btn btn-danger float-right" title="Reset Cache">RC</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($repositories as $repository): ?>
                                        <div class="col col-4 mb-2">
                                            <a href="<?php echo esc_url($url . '&repository=' . $repository->name) ?>">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <?php echo $repository->full_name ?>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="card col-9 mt-md-3">
                            <div class="card-header">Project Directory
                                <a href="<?php echo esc_url($url . '&reset_cache_directory=1') ?>" class="btn btn-danger float-right" title="Reset Cache">RC</a>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="options.php">
                                    <div class="form-group row">
                                        <label for="token" class="col-sm-12 col-md-2 col-form-label text-md-right">Project Directory</label>
                                        <div class="col-md-10">

                                            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce() ?>">
                                            <?php
                                            // output security fields for the registered setting "pullSthSlug"
                                            settings_fields($this->menu_slugs[1]);
                                            // output setting sections and their fields
                                            // (sections are registered for "pullSthSlug", each field is registered to a specific section)
                                            //                                        do_settings_sections($this->menu_slugs[1]);
                                            // output save settings button
                                            ?>
                                            <input id="token" type="text" name="git_helper_options[git_helper_dir_to_save]" value="<?php echo $this->getDirectoryToSave() ?>" autofocus="autofocus" class="form-control">

                                            <span>This app dir : </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-10 row mb-0">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary">
                                                Save
                                            </button>
                                        </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
        }

    }

    /**
     * @return string
     */
    public function getDirectoryToSave()
    {
        return (isset($this->options['' . self::GIT_HELPER_DIR_TO_SAVE . '']) && !empty($this->options[self::GIT_HELPER_DIR_TO_SAVE])) ? $this->options[self::GIT_HELPER_DIR_TO_SAVE] : PLUGIN_DIR;
    }

    public function currentUrl()
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }

    private function setUpShowRepositoryPage()
    {
        register_setting($this->menu_slugs[1], self::OPTIONS_NAME);

        add_settings_section('git_helper_directory_section', 'Directory Section', function () { }, $this->menu_slugs[1]);

        add_settings_field(
            'git_helper_directory_section_dir',
            'Directory',
            function () { },
            $this->menu_slugs[1],
            'git_helper_directory_section'
        );
    }

}