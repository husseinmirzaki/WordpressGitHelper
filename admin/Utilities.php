<?php
/**
 * Created by PhpStorm.
 * User: Hussein Mirzaki
 * Date: 9/14/2018
 * Time: 10:02 PM
 */

trait Utilities
{
    public function getOption($option)
    {
        return $this->hasOption(get_option($option)) ? get_option($option) : '';
    }

    public function hasOption($option)
    {
        return !empty($option) ? false : $option;
    }

    public function getOptions($options, $option)
    {
        if (is_array($options))
            return $this->hasOptions($options, $option) ?: '';
        return $this->hasOptions(get_option($options), $option) ?: '';
    }

    public function hasOptions($options, $option)
    {
        return isset($options[$option]) ? $options[$option] : false;
    }

}