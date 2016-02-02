<?php
/**
 * PageLines Customize functions.php.
 *
 * @author Simon Prosser
 */
/*
// ---- ADDING NEW TEMPLATES ---- //

	Want another page template for drag and drop? Easy :)
	1. Add File called page.[page-id].php to this folder.
	2. Add Template Name: Your Page Name to that file ( see page.base.php for an example. )
	3. Thats it! We do the rest for you!
	
// ---- ADDING NEW SECTIONS ---- //

	Adding new sections is really easy in 2.0
	1. Copy your section.[sectionname].php file into the sections folder
	2. It will be auto loaded for you.
	3. You can now enable/disable the section in the extensions menu.

// FILTERS EXAMPLE ---------//

	// The following filter will add the font  Ubuntu into the font array $thefoundry.
	// This makes the font available to the framework and the user via the admin panel.
*/
add_filter ( 'pagelines_foundry', 'my_google_font' );

function my_google_font( $thefoundry ) {
	$myfont = array( 'Ubuntu' => array(
			'name' => 'Ubuntu',
			'family' => '"Ubuntu", arial, serif',
			'web_safe' => true,
			'google' => true,
			'monospace' => false
			)
		);
	return array_merge( $thefoundry, $myfont );
}
/*
// ====================================================
// = YOUR FUNCTIONS - Where you should add your code  =
// ====================================================
*/