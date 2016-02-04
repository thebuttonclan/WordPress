<?php
/*

  Plugin Name:  PageLines Section Content
  Description:  The Main Content area (Post Loop in WP speak). Includes content and post information.

  Author:       PageLines
  Author URI:   http://www.pagelines.com

  PageLines:    PL_Content
  Filter:       basic

  Loading:      refresh

*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PL_Content extends PL_Section {

  function section_persistent(){

    // /** Support Media Post Formats */
    // add_theme_support( 'post-formats', array(
    //   'quote', 'video', 'audio', 'gallery', 'link'
    // ) );

    // //add_action( 'comment_form_before',              array( $this, 'comment_form_js' ) );

    // add_filter( 'pl_binding_media_size',            array( $this, 'callback_media_size'), 10, 2);

    // //add_filter( 'pl_platform_settings_array',       array($this, 'settings') );

    //add_filter( 'pl_platform_meta_settings_array',  array($this, 'meta_settings') );

    // register_sidebar( array(
    //     'id'          => 'primary',
    //     'name'        => __( 'Primary', 'pagelines' )
    // ) );

    // register_sidebar( array(
    //     'id'          => 'secondary',
    //     'name'        => __( 'Secondary', 'pagelines' )
    // ) );

    // register_sidebar( array(
    //     'id'          => 'tertiary',
    //     'name'        => __( 'Tertiary', 'pagelines' )
    // ) );
  }


  
  /**
  * Section template.
  */
   function section_template() {

      if( pl_is_static_template('sec template') ){

        global $pl_static_template_output;

        $binding = "plclassname: [ (tplwrap() == 'wrapped') ? 'pl-content-area' : '' ]";

        printf( '<div class="pl-page-content" data-bind="%s">%s</div>', $binding, $pl_static_template_output );

      }

      


  }



}
