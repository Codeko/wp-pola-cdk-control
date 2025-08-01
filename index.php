<?php
/**
 * Plugin Name: POLA-CDK - Control
 * Description: Currently, only provides a function to check updates for POLA-CDK plugins
 * Version: 0.0.2
 * Author: Pola Network
 * Author URI: https://github.com/Codeko/pola-cdk-control
 */

namespace PolaCDK;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists( 'WP_GitHub_Updater' ) ){
    include_once('updater.php');
}

class PolaCDK_Control {
    public function __construct() {
        if (is_admin()) {
            add_action('init', array(static::class, 'self_updater'));
        }
    }

    public static function self_updater() {
        $config = array(
            'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
            'proper_folder_name' => 'wp-pola-cdk-control', // this is the name of the folder your plugin lives in
            'api_url' => 'https://api.github.com/repos/Codeko/wp-pola-cdk-control', // the GitHub API url of your GitHub repo
            'raw_url' => 'https://raw.github.com/Codeko/wp-pola-cdk-control/main', // the GitHub raw url of your GitHub repo
            'github_url' => 'https://github.com/Codeko/wp-pola-cdk-control', // the GitHub url of your GitHub repo
            'zip_url' => 'https://github.com/Codeko/wp-pola-cdk-control/zipball/main', // the zip url of the GitHub repo
            'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
            'requires' => '6.4.1', // which version of WordPress does your plugin require?
            'tested' => '6.4.1', // which version of WordPress is your plugin tested up to?
            'readme' => 'README.md', // which file to use as the readme for the version number
            'access_token' => '', // Access private repositories by authorizing under Plugins > GitHub Updates when this example plugin is installed
        );
        self::plugin_updater($config);
    }

    public static function plugin_updater($config) {
        define( 'WP_GITHUB_FORCE_UPDATE', true );
        if (is_admin() && class_exists( 'WP_GitHub_Updater')) {
            //self::notice( __('Checking updates for',  'pola_cdk_control') . " " . $config['proper_folder_name']);
            new \WP_GitHub_Updater($config);
        }

    }

    public static function notice($text) {
        echo '<div class="notice"><p>' .$text . '</p></div>';
    }
}

new PolaCDK_Control;
