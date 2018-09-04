<?php
/**
 * Extensions Updates Handler
 *
 * Handles Updates for plugins/themes installed via Platforms Extend Menu
 *
 * ALL UPDATES FOR THE CORE PLUGIN WILL BE DEFFERED TO STANDARD WORDPRESS UPDATES
 *
 * Only PageLines Plugins/Themes installed from the extension menu that are not and/or cannot
 * be hosted on wordpress.org are updated, all normal plugin/theme updates are simply returned
 * in the filters.
 *
 * @class     PL_Platform_Updater
 * @version   5.0.0
 * @package   PageLines/Classes
 * @category  Class
 * @author    PageLines
 */
if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
class PL_Platform_Updater {

  function __construct() {

    /**
     * Include the updater code.
     */
    include_once( 'plugin-update-checker.php' );
    include_once( 'theme-update-checker.php' );

    /**
     * Run the update hooks
     */
    add_action( 'wp_loaded',                   array( $this, 'update_plugins' ) );
    add_action( 'admin_init',                  array( $this, 'update_themes' ) );

    /**
     * If there are any error notices then display them
     */
    add_action( 'admin_notices',               array( $this, 'error_notice' ) );

    /**
     * Clear our cached plugins data
     */
    add_action( 'activate_plugin',             array( $this, 'reset_cache' ) );
    add_action( 'deactivate_plugin',           array( $this, 'reset_cache' ) );
    add_action( 'upgrader_process_complete',   array( $this, 'reset_cache' ) );
  }

  /**
   * Reset the cache
   */
  function reset_cache() {
    delete_transient( 'pl_get_plugins' );
  }

  /**
   * Show a notice if a plugin requires a later version of PL5
   */
  function error_notice() {

    // load plugins from the db
    $plugins = PL_Platform()->functions->pl_get_plugins( true );

    if ( is_array( $plugins ) ) {
      foreach ( $plugins as $path => $data ) {

        // shouldnt happen but.. no reqver so clear cache we'll get it on next pageload.
        if ( ! isset( $data['reqver'] ) ) {
          PL_Platform()->functions->cache_clear( 'pl_get_plugins' );
          return false;
        }

        /**
         * show the notice
         */
        if ( version_compare( $data['reqver'], PL()->version, '>' ) ) {
          pl_create_notice( array(
              'title'   => 'Update Required',
              'msg'     => sprintf( 'The plugin %s requires at least version %s of Platform 5 and has been deactivated to prevent errors.',
                  $data['Plugin Name'],
                  $data['reqver']
              ),
              'icon'    => 'warning',
          ));
          // deactivate the problem extension
          deactivate_plugins( $path );
        }
      }
    }
  }

  /**
   * Maybe add update info for a theme hosted by PageLines.
   * NOTE All themes hosted on wordpress.org are handled by WordPress.
   *
   */
  function update_themes() {

    /**
     * If updates are disabled then just dont.
     */
    if ( defined( 'PL_DISABLE_UPDATES' ) ) {
      return false;
    }

    $themes = wp_get_themes( array( 'errors' => false ) );

    /**
     * Loop through themes, if its a PL theme then run the updater code.
     */
    foreach ( $themes as $slug => $theme ) {

        $themedata = wp_get_theme( $slug );

        $author = $themedata->get( 'Author' );

        if ( 'PageLines' === $author ) {
          new ThemeUpdateChecker(
              $slug,
              sprintf( 'https://wpecdn.pagelines.com/?updates-json=1&slug=%s', $slug )
          );
        }
    }
  }

  /**
   * Maybe add update info for a plugin hosted by PageLines.
   * All plugins hosted on wordpress.org are handled by WordPress.
   *
   * NOTE: This plugin pl-platform is also deffered to wordpress.org because it is hosted there.
   */
  function update_plugins() {

    $pl_plugins = PL_Platform()->functions->pl_get_plugins( true );

    /**
     * If updates are disabled then just dont.
     */
    if ( defined( 'PL_DISABLE_UPDATES' ) ) {
      return false;
    }

    /**
     * Loop through plugins and add to updater.
     */
    foreach ( $pl_plugins as $path => $plugin ) {

      $slug = dirname( $path );

      /**
       * Check plugin is valid before passing to the updater libs.
       */
      if ( is_file( WP_PLUGIN_DIR . '/' . $path ) ) {
        PucFactory::buildUpdateChecker(
            sprintf( 'https://wpecdn.pagelines.com/?updates-json=1&slug=%s', $slug ),
            sprintf( '%s%s', trailingslashit( WP_PLUGIN_DIR ), $path )
        );
      }
    }
  }
} // end of class

new PL_Platform_Updater;
