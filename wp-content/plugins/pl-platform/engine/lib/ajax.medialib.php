<?php
/**
 * Media Library 
 *
 * PHP and AJAX bindings for media library popups
 * 
 * @class     PL_Media_Library
 * @version   5.0.0
 * @package   PageLines/Classes
 * @category  Class
 * @author    PageLines
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PL_Media_Library{

  /**
   * Only runs the class hook if there is a context variable set. This is only set in an admin URL in the iFrame
   */
  function __construct() {

    if ( isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'pl-custom-attach' ) {

      $this->option_id = (isset( $_REQUEST['oid'] )) ? $_REQUEST['oid'] : '';

      add_filter( 'attachment_fields_to_edit',  array( $this, 'attachment_fields_to_edit' ), 15, 2 );
      add_filter( 'media_upload_tabs',          array( $this, 'filter_upload_tabs' ) );
      add_action( 'admin_head' ,                array( $this, 'the_js' ), 15 );
      add_action( 'admin_head',                 array( $this, 'media_css' ) );
      add_action( 'admin_print_scripts',        array( $this, 'dequeue_offending_scripts' ));
      add_filter( 'media_upload_mime_type_links', '__return_empty_array' );

    } else 
      return;
  }

  /** 
   * Used to create the iFrame link that is used
   * @return string The URL for the frame with context and other vars.
   */
  function pl_media_library_link( $type = 'image' ){
  
    global $post;

    $post_id = ( empty($post->ID) ) ? 0 : $post->ID;

    $image_library_url = add_query_arg( 'post_id', $post_id, admin_url('media-upload.php') );
    $image_library_url = add_query_arg( 'post_mime_type', $type,    $image_library_url );
    $image_library_url = add_query_arg( 'tab', 'library', $image_library_url);
    $image_library_url = add_query_arg( array( 'context' => 'pl-custom-attach', 'TB_iframe' => 1), $image_library_url );
    
    return $image_library_url;
    
  }

  // dequeue scripts that break the image uploader.
  function dequeue_offending_scripts() {
    wp_enqueue_style( 'dashicons' );
    // nextgen gallery destroys media uploader. 
    wp_dequeue_script( 'frame_event_publisher' );
  }
  
  /**
   * Make sure the media items are viewable.
   * Fixes an issue for DMS users.
   */
  function media_css() {
    ?>
    <style type="text/css">
    #media-upload #media-items {
      width: inherit;
    }
    </style>
    <?php
  }

  function the_js(){
    ?>
    <script>
    jQuery(document).ready(function(){
      jQuery('.pl-frame-button').on('click', function(){

        var oSel        = window.parent.PLWorkarea.iframeSelector,
            optID       = '#' + oSel,
            imgURL      = jQuery(this).data('imgurl'),
            imgURLShort = jQuery(this).data('short-img-url'),
            theOption   = jQuery( optID, top.document), 
            thePreview  = theOption.closest('.upload-box').find('.pl-dropzone-preview')
        
        theOption.val( imgURLShort ).trigger('blur')
        
        thePreview.html( '<div class="dz-preview dz-image-preview"><div class="dz-details"><img src="'+ imgURL +'" /></div></div>' )

        parent.eval('jQuery("'+optID+'").trigger("blur")')
        parent.eval('jQuery(".bootbox").modal("hide")')   
      })
    })
    </script>
    <?php
  }

  /**
   * Replace default attachment actions with "Set as header" link.
   *
   * @since 3.4.0
   */
  function attachment_fields_to_edit( $form_fields, $post ) {

    $form_fields = array();

    $attach_id = $post->ID;

    
    $image_url    = wp_get_attachment_url( $attach_id );
    $short_img_url  = pl_uploads_shortcode_url( $image_url );

    $form_fields['buttons'] = array(
      'tr' => sprintf(
            '<tr class="submit"><td></td>
              <td>
              <span class="pl-frame-button admin-blue button" data-selector="%s" data-imgurl="%s" data-short-img-url="%s">%s</span>
              </td></tr>',
              esc_attr( $this->option_id ),
              $image_url,
              $short_img_url,
              __( 'Select This For Option', 'pl-platform' )
          )
    );
    $form_fields['context'] = array(
      'input' => 'hidden',
      'value' => 'pl-custom-attach'
    );
    $form_fields['oid'] = array(
      'input' => 'hidden',
      'value' => $this->option_id
    );

    return $form_fields;
  }

  /**
   * Leave only "Media Library" tab in the uploader window.
   *
   * @since 3.4.0
   */
  function filter_upload_tabs( $tabs ) {
    return array( 
      'library' => __('Your Media Library', 'pl-platform'),
    );
  }
}
