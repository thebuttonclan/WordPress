<?php
/*
  Plugin Name:   PageLines Section Menus
  Description:   A stylized navigation bar with multiple modes and styles.

  Author:       PageLines
  Author URI:   http://www.pagelines.com

  PageLines:     PL_Menus
  Filter:       nav
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PL_Menus extends PL_Section {

  function section_opts(){

    $opts = array(
      array(
        'type'    => 'multi',
        'key'     => 'navi_content',
        'title'   => __( 'Logo', 'pl-platform' ),
        'opts'    => array(
          pl_std_opt('menu'),
          pl_std_opt('logo'),
          array(
           'type'    => 'dragger',
           'label'    => __( 'Logo Size / Height', 'pl-platform' ),
           'opts'  => array(
             array(
               'key'      => 'logo_height',
               'min'      => 20,
               'max'      => 300,
               'def'      => 30,
               'unit'    => 'px'
             ),
           ),
          ),
          pl_std_opt( 'title',  array( 'default' => '' ) ),
          pl_std_opt( 'link',   array( 'label'   => __( 'Title Link', 'pl-platform' ) ) ),      
          array(
            'type'      => 'check',
            'key'       => 'space_between',
            'label'     => __( 'Fill menu space? (logo left, menu right)', 'pl-platform' )
          ),
        )
      )
    );
    return $opts;
  }
  
  /**
   * Register Menu Location, must match theme_location in menu config array
   */
  function section_persistent() {
    register_nav_menus( array( 'pl-nav' => $this->name . __( ' Section', 'pl-platform' ) ) );
  }

  function nav_config(){
    $config = array(
      'key'             => 'menu',
      'menu_class'      => 'pl-nav',
      'menu'            => $this->opt('menu'), 
      'depth'           => 1,
      'theme_location'  => 'pl-nav'
    );

    return $config;
  }

  /**
  * Section template.
  */
   function section_template( $location = false ) {

  ?>
  <div class="menu-wrap fix">
    <div class="menus-content pl-content-area pl-alignment-default-center" data-bind="plclassname: ( space_between() == 1 ) ? 'fill-space' : ''" >
      <div class="menus-branding menus-container" data-bind="visible: title() || logo()" >

        <a class="menus-logo site-logo" href="<?php echo home_url();?>" data-bind="plhref: link" >
          <img src="<?php echo $this->opt( 'logo', pl_fallback_image() ); ?>" alt="<?php echo get_bloginfo('name');?>" data-bind="visible: logo(), plimg: logo, style: {'max-height': logo_height() ? logo_height() + 'px' : '30px'}" />
          <span class="site-name menus-name" data-bind="visible: ! logo(), pltext: title"><?php echo get_bloginfo('name');?></span>
        </a>

      </div>
      <div class="menus-navigation menus-container ">

        <?php echo pl_dynamic_nav( $this->nav_config() ); ?>

      </div>
    </div>
  </div>
<?php }
}
