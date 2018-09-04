<?php
/**
 * Global functions used in Platform
 *
 * @class     PL_Platform_Functions
 * @version   5.0.0
 * @package   PageLines/Classes
 * @category  Class
 * @author    PageLines
 */
if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
class PL_Platform_Functions {

  function __construct( PL_Platform $platform ) {
    $this->platform = $platform;
  }

  /**
  * Get plugins and optionally filter out WP plugins
  */
  static function pl_get_plugins( $filter = false, $pro = false ) {

    $default_headers = array(
     'Version'      => 'Version',
     'PageLines'    => 'PageLines',
     'Plugin Name'  => 'Plugin Name',
     'Description'  => 'Description',
     'Version'      => 'Version',
     'Category'     => 'Category',
     'reqver'       => 'reqver',
    );

    /**
     * Check for cached plugins data, if false then use get_plugins and parse the headers.
     */
    if ( false === ( $plugins = self::cache_get( 'pl_get_plugins' ) ) ) {
      include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
      $plugins = get_plugins();
      // get the headers for each plugin file
      foreach ( $plugins as $path => $data ) {
        $fullpath = sprintf( '%s%s', trailingslashit( WP_PLUGIN_DIR ), $path );
        $plugins[ $path ] = get_file_data( $fullpath, $default_headers );
      }
      self::cache_set( array( 'slug' => 'pl_get_plugins', 'data' => $plugins ) );
    }

    if ( ! $filter ) {
      return $plugins;
    }

    // if the headers do not contain 'PageLines' then unset from the array and let WP handle them
    foreach ( $plugins as $path => $data ) {
      if ( ! $data['PageLines'] ) {
        unset( $plugins[ $path ] );
      }
    }

    foreach ( $plugins as $path => $data ) {

      /**
       * Ignore pl-platform wporg will handle updates for us.
       */
      if ( 'pl-platform' == dirname( $path ) ) {
        unset( $plugins[ $path ] );
        continue;
      }

      $cats = array_map( 'trim', explode( ',', $data['Category'] ) );

      // if plugin does not have framework category then do not include it, probably old products.
      if ( ! in_array( 'framework', $cats ) ) {
        unset( $plugins[ $path ] );
        continue;
      }

      // if $pro then remove all but pro plugins, used for counting pro plugins
      if ( $pro ) {
        if ( ! array_search( 'pro', $cats ) ) {
          unset( $plugins[ $path ] );
          continue;
        }
      }
    }

    return $plugins;
  }

  /**
  * Cache something into a transient, default is one day
  */
  static function cache_set( $args ) {

    $defaults = array(
     'expires'  => DAY_IN_SECONDS,
     'slug'     => '',
     'data'     => '',
    );
    $args = wp_parse_args( $args, $defaults );

    // no slug set or no data
    if ( ! $args['slug'] || ! $args['data'] ) {
      return false;
    }
    return set_transient( $args['slug'], $args['data'], $args['expires'] );
  }

  /**
   * Fetch from cache
   */
  static function cache_get( $slug ) {
    return get_transient( $slug );
  }

  /**
   * Clear cache
   */
  static function cache_clear( $slug ) {
    return delete_transient( $slug );
  }
}
