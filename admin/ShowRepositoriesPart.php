<?php

trait ShowRepositoriesPart
{

    public function setUpShowRepositoryPageMenu()
    {
        add_submenu_page($this->menu_slugs[0], 'Pull Sth', 'Pull Sth', 'manage_options', $this->menu_slugs[1], [$this, 'showRepositories']);
    }

    public function showRepositories()
    {

        ?>
        <div class="bootstraped" style="width: 100%">
            <div class="container col-12">
                <div class="row justify-content-center">

                    <div class="card col-11">
                        <div class="card-header font-weight-bold">Repositories of</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col col-4 mb-2">
                                    <a href="">
                                        <div class="card">
                                            <div class="card-body">
                                                Test
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card col-9 mt-md-3">
                        <div class="card-header">Project Directory</div>
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
                                        do_settings_sections($this->menu_slugs[1]);
                                        // output save settings button
                                        ?>
                                        <input id="token" type="text" name="git_helper_options[git_helper_dir_to_save]" value="<?php echo isset($this->options['git_helper_dir_to_save']) ? $this->options['git_helper_dir_to_save'] : '' ?>" autofocus="autofocus" class="form-control">

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

    private function setUpShowRepositoryPage()
    {
    }

}