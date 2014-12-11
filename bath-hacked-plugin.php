<?php

/*
Plugin Name: Bath: Hacked
Description: Display data from the Bath: Hacked datastore
Version: 1.0
Author: Mark Owen & Bath: Hacked
Author URI: http://bathhacked.org
License:

  Copyright 2014  Mark Owen

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

require_once(__DIR__ . '/lib/Widgets/CarParks.php');
require_once(__DIR__ . '/lib/Shortcodes/CarParks.php');

if(!class_exists('BathHacked'))
{
    class BathHacked
    {
        public function __construct()
        {
            if(is_admin())
            {
                add_action('admin_print_styles', array($this, 'register_admin_styles'));
                add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));

                add_action('admin_init', array($this, 'register_admin_options'));
                add_action('admin_menu', array($this, 'register_admin_menu'));
            }
            else
            {
                add_action('wp_enqueue_scripts', array($this, 'register_plugin_styles'));
                add_action('wp_enqueue_scripts', array($this, 'register_plugin_scripts'));
            }

            register_activation_hook(__FILE__, array($this, 'activate'));
            register_deactivation_hook(__FILE__, array($this, 'deactivate'));
            register_uninstall_hook(__FILE__, array($this, 'uninstall'));

            add_action('widgets_init', array($this, 'register_widgets'));
            add_action('widgets_init', array($this, 'register_shortcodes'));
        }


        public function register_widgets()
        {
            register_widget('BathHacked_Widgets_CarParks');
        }

        public function register_shortcodes()
        {
            $carParkShortcode = new BathHacked_Shortcodes_CarParks();

            add_shortcode('bh_car_parks', array($carParkShortcode, 'render'));
        }

        public function activate($network_wide)
        {
            add_option('bath_hacked_settings', array(
                'bath_hacked_car_parks_url' => 'https://data.bathhacked.org/resource/u3w2-9yme.json'
            ));
        }

        public function deactivate($network_wide)
        {
        }

        public function uninstall($network_wide)
        {
            delete_option('bath_hacked_settings');
        }

        public function register_admin_styles()
        {
        }

        public function register_admin_scripts()
        {
        }

        public function register_admin_options()
        {
            register_setting('bath_hacked', 'bath_hacked_settings');

            add_settings_section(
                'bath_hacked_section',
                'Bath: Hacked',
                array($this, 'options_section'),
                'bath_hacked'
            );

            add_settings_field(
                'bath_hacked_car_parks_url',
                __('Car Park Dataset API URL', 'bathhacked'),
                array($this,'options_car_parks_url'),
                'bath_hacked',
                'bath_hacked_section'
            );
        }

        public function register_admin_menu()
        {
            add_options_page('Bath: Hacked', 'Bath: Hacked', 'manage_options', 'bath_hacked', array($this, 'options_page') );
        }

        public function register_plugin_styles()
        {
            wp_enqueue_style('bath-hacked-styles', plugins_url('bath-hacked-plugin/css/front.css'), null, '1.0');
        }

        public function register_plugin_scripts()
        {
            wp_enqueue_script('raphael', plugins_url('bath-hacked-plugin/js/raphael-min.js'), array(), '2.1.1', true);
            wp_enqueue_script('justgage', plugins_url('bath-hacked-plugin/js/justgage.min.js'), array('raphael'), '1.0.1', true);
            wp_enqueue_script('moment', plugins_url('bath-hacked-plugin/js/moment.min.js'), array(), '2.8.4', true);
            wp_enqueue_script('bath-hacked-front', plugins_url('bath-hacked-plugin/js/front.min.js'), array('jquery', 'justgage', 'moment'), '1.0', true);
        }

        public function options_page()
        {
            ?>
            <form action='options.php' method='post'>

                <?php
                settings_fields( 'bath_hacked' );
                do_settings_sections( 'bath_hacked' );
                submit_button();
                ?>

            </form>
        <?php
        }

        public function options_section()
        {
            echo __( 'Bath: Hacked settings', 'bathhacked' );
        }

        public function options_car_parks_url()
        {
            $options = get_option('bath_hacked_settings');

            ?>
            <input type='text' class="widefat" name='bath_hacked_settings[bath_hacked_car_parks_url]' value='<?php echo isset($options['bath_hacked_car_parks_url']) ? $options['bath_hacked_car_parks_url'] : '' ?>'>
            <?php
        }
    }

    $bathHackedPlugin = new BathHacked();
}