<?php
/**
 * Account Handling Class
 *
 * @class     PL_Platform_Account
 * @version   5.0.0
 * @package   PageLines/Classes
 * @category  Class
 * @author    PageLines
 */
if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
class PL_Platform_Account {

  function __construct() {

    add_filter( 'pl_platform_config_account',  array( $this, 'config' ) );
    add_action( 'pl_platform_ui_body_account', array( $this, 'template' ), 10, 2 );
  }

  /**
   * Master Settings configuration for the admin.
   */
  function config() {

    $d = array(
      'default'   => array(
      'title'     => get_admin_page_title(),
      ),
    );

    return $d;
  }

  /**
   * Account page template
   */
  function template( $ui ) {

    $data = $ui->platform->oauth->get_cache_data();

    if ( ! $data || ! isset( $data->user->email ) ) {
      return; }

    echo '<div class="pl-dashboard">';

      $this->version( $data, $ui );
      $this->account( $data, $ui );

    echo '</div>';
  }

  function account( $data, $ui ) {

    $current_user       = wp_get_current_user();
    $connected_user     = get_option( '_pl_oauthed_user' );

    if ( $current_user->user_login == $connected_user ) {
      $btns = sprintf( '<div class="actions"><a class="button button-primary" href="%s" target="_blank"><i class="pl-icon pl-icon-user"></i>&nbsp; %s</a> <a class="button" href="%s">%s</a> <a class="button" href="%s">%s</a></div>',
          PL()->urls->my_account,
          __( 'My Account', 'pl-platform' ),
          $ui->platform->url( 'account', array( 'action' => 'refresh_user' ) ),
          __( 'Refresh', 'pl-platform' ),
          $ui->platform->url( 'account', array( 'pl_platform_logout' => 1 ) ),
          __( 'Disconnect', 'pl-platform' )
      );
    } else {
      $btns = sprintf( '<div class="actions"><a class="button" href="%s">%s</a></div>',
          $ui->platform->url( 'account', array( 'pl_platform_logout' => 1 ) ),
          __( 'Disconnect', 'pl-platform' )
      );
    }

    echo $ui->banner( array(
          'classes' => 'banner-dashboard',
          'title'   => __( 'PageLines Account', 'pl-platform' ),
          'header'  => $data->user->display_name,
          'suphead' => __( 'Site Connected As', 'pl-platform' ),
          'subhead' => sprintf( '%s %s',
              __( 'Member Since', 'pl-platform' ),
              date_i18n( 'F Y', strtotime( $data->user->user_registered ) )
          ),
          'content' => $btns,
          'img'     => get_avatar( $data->user->email, 250 ),
    ));

  }

  /**
   * Work out the installed licence and display buttons accordingly
   */
  function version( $data, $ui ) {

    $domain_data        = $ui->platform->oauth->get_domains_data();
    $registered         = $ui->platform->oauth->is_site_registered();
    $local_pro          = $ui->platform->oauth->is_local_and_has_pro();
    $can_register       = $ui->platform->oauth->can_register_site();
    $grandfathered      = $ui->platform->oauth->is_grandfathered();
    $affiliate          = $ui->platform->oauth->get_affiliate_data();
    $grandfathered_txt  = '';
    $current_user       = wp_get_current_user();
    $connected_user     = get_option( '_pl_oauthed_user' );

    // if user has NOT registered this domain and is able to
    if ( ! $registered ) {

      $version  = __( 'Free', 'pl-platform' );
      $desc     = __( 'Only free features and extensions are available.', 'pl-platform' );

      if ( $can_register ) {

        $domain_format = PL_Platform()->oauth->get_domain_data_format();

        $action_url = PL_Platform()->oauth->domain_activate_link();

        $txt        = __( 'Activate Pro ', 'pl-platform' ) . $domain_format;
        $action_txt = sprintf( '<i class="pl-icon pl-icon-bolt"></i> %s', $txt );
      } else {
        $action_url = PL()->urls->purchase;
        $txt        = sprintf( '<strong>%s</strong>', __( 'Get License', 'pl-platform' ) );
        $action_txt = sprintf( '<i class="pl-icon pl-icon-shopping-cart"></i> %s', $txt );
      }

      $thumb = pl_framework_url( 'images' ) . '/thumb-free.png';
    } // user has already registered this domain so show button to unregister it.
    else {

      $version    = __( 'Professional', 'pl-platform' );
      $desc       = __( 'All features are available. Yay!', 'pl-platform' );

      $desc       .= ( $local_pro ) ? sprintf( '<p>(<strong>%s</strong>)</p>', __( 'Localhost/Staging and at least one pro license detected in account.', 'pl-platform' ) ) : '';

      $action_url = PL_Platform()->url( 'extend' );
      $action_txt = sprintf( '<i class="pl-icon pl-icon-download"></i> %s', __( 'Install New Extensions', 'pl-platform' ) );
      $thumb      = pl_framework_url( 'images' ) . '/thumb-pro.png';
    }
    // see if user is grandfathered in to platform.
    if ( true == $grandfathered ) {
      $grandfathered_txt = sprintf( ' (%s)', __( 'Grandfathered', 'pl-platform' ) );
    }

    $desc .= sprintf( '<p><strong>%s</strong> of <strong>%s total</strong> Pro licenses available in your account%s</p>',
        $domain_data->remaining,
        $domain_data->allowed,
        $grandfathered_txt
    );

    if ( 0 == $domain_data->allowed ) {
      $desc = sprintf( '<p>%s</p>', __( 'There are no Pro licenses available in your account.', 'pl-platform' ) );
    }

    $actions  = sprintf( '<div class="actions"><a class="button button-primary" href="%s">%s</a> &nbsp; <a class="button" href="%s">%s</a></div>',
        $action_url,
        $action_txt,
        PL()->urls->pro,
        __( 'Learn More', 'pl-platform' )
    );

    echo $ui->banner( array(
             'classes'     => 'banner-dashboard',
             'title'       => __( 'PageLines Version', 'pl-platform' ),
             'suphead'     => __( 'PageLines Version', 'pl-platform' ),
             'header'      => sprintf( '<strong>%s</strong>', $version ),
             'subhead'     => $desc,
             'content'     => $actions,
             'src'         => $thumb,
    ));

    if ( $registered && ! pl_is_local() ) {

      // if we have a valid affiliate ID
      if ( isset( $affiliate->id ) ) {
        $subtext = sprintf( '%s<br /><br />%s: <em>%s</em>',
            __( 'Give your client your affiliate link to earn extra cash during client handover.', 'pl-platform' ),
            __( 'Your Affiliate link is', 'pl-platform' ),
            $affiliate->link
        );
      } else {
        $subtext = __( 'Get your professional slot back by activating pro with any other account.', 'pl-platform' );
      }

      // if the current user is the same one that connected the site
      if ( $connected_user == $current_user->user_login ) {

        $content = sprintf( __( 'You will have %s %s after a successful handoff.', 'pl-platform' ),
            $domain_data->remaining + 1,
            _n( 'slot', 'slots', $domain_data->remaining + 1, 'pl-platform' )
        );

        $content  = sprintf( '<p class="banner-subheader">%s</p>', $content );

        echo $ui->banner( array(
                 'classes'     => 'banner-dashboard',
                 'title'       => __( 'Switching Accounts', 'pl-platform' ),
                 'suphead'     => __( 'Need to handoff to a client?', 'pl-platform' ),
                 'subhead'     => $subtext,
                 'header'      => __( 'Switch Accounts', 'pl-platform' ),
                 'content'     => $content,
        ));
      } // we are *not* the user that activated, another admin. So show handoff instructions with link for PL5
      else {
        if ( $affiliate->id ) {
          $link = $affiliate->link;
        } else {
          $link = PL()->urls->purchase;
        }

        // array to build list
        $list = array(
          sprintf( '%s <a href="%s">%s</a>.',
              __( 'Purchase your copy of Platform 5 by clicking', 'pl-platform' ),
              $link,
              __( 'HERE', 'pl-platform' )
          ),
                __( 'Click the disconnect button below.', 'pl-platform' ),
                __( 'Activate Platform 5 with your new PageLines account.', 'pl-platform' ),
                __( 'Your site is now activated', 'pl-platform' ),
              );

        $content  = sprintf( '<p><ol><li>%s</li></ol>',
            implode( '</li><li>', $list )
        );

        echo $ui->banner( array(
                 'classes'     => 'banner-dashboard',
                 'title'       => __( 'Switching Accounts', 'pl-platform' ),
                 'header'      => __( 'Switching Accounts', 'pl-platform' ),
                 'content'     => $content,
        ));
      }
}

  }
}
new PL_Platform_Account;
