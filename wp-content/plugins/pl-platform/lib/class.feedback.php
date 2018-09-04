<?php

class PL_Feedback {

  function __construct() {
    add_action( 'load-plugins.php', array( $this, 'init' ) );
    add_action( 'wp_ajax_pl_admin_feedback',  array( $this, 'ajax' ) );
  }

  function init() {
    add_action( 'admin_footer', array( $this, 'feedback' ) );

  }

  function ajax() {

    $postdata = $_POST;

    if ( isset( $postdata['nonce'] ) ) {
      pl_verify_ajax( $postdata['nonce'] );
    } else {
      die( 'No Nonce set!' );
    }

    $url = $postdata['data']['url'];
    $rsp = wp_remote_post( $url, array( 'body' => $postdata['data']['entries'] ) );

  }

  function feedback() {
    ?>
    <div class="remodal" data-remodal-id="modal">
      <button data-remodal-action="close" class="remodal-close"></button>
  <h1>Deactivate PageLines</h1>
<h4>Would you like to tell us why you are deactivating the plugin?</h4>
<p>
    <ul class="feedback-form">
    <?php
      foreach( $this->get_radios() as $k => $radio ) {
        printf( "<li><input type='radio' name='reason' value='%s' %s/>&nbsp;%s</li>", $k, $radio['checked'], $radio['text'] );
      }

     ?>
     <li><input type="radio" name="reason" value="other" />&nbsp;Other</li>
     <li><textarea></textarea></li>
   </ul>
   <span class="disclaimer">Only your answer will be sent, no other data.</span>
</p>
  <br>
  <button data-remodal-action="cancel" class="remodal-cancel">Just Deactivate</button>
  <button data-remodal-action="confirm" class="remodal-confirm">Deactivate And Tell Us Why</button>
</div>

    <?php
  }

  function get_radios() {

    $radios = array(
      'couldnt_figure' => array(
        'text' => "I couldn't figure out how to use it.",
        'checked' => 'checked'
      ),
      'didnt_work_as_expected' => array(
        'text' => 'Didnt work as I expected.',
        'checked' => ''
      ),
      'uninstalled_will_reinstall' => array(
        'text' => 'I am deactivating and intend to reactivate later.',
        'checked' => ''
      ),
      'found_better' => array(
        'text' => 'I have found something better.',
        'checked' => ''
      )
    );
    return $radios;
  }

}

new PL_Feedback;
