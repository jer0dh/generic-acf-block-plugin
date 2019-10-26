<?php
/**
 * For mr_menu block.  Read in available menus to populate ACF field.
 *
 * @param array $field  ACF.
 * @return array
 */
function acf_load_menu_field_choices( $field ) {

	// reset choices.
	$field['choices'] = array();
	$menus            = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
	// * $menus = get_registered_nav_menus();  //uncomment this if you want to populate the dropdown with all Menu Locations.
	$blank_list = wp_json_encode(
		array(
			'name'    => 'Default Menu',
			'term_id' => '',
		)
	);
	$blank_list = json_decode( $blank_list );
	array_unshift( $menus, $blank_list );
	foreach ( $menus as $val ) {
		$value                      = $val->term_id;
		$label                      = $val->name;
		$field['choices'][ $value ] = $label;
	}
	// return the field.
	return $field;
}

// * Call via
// * add_filter( 'acf/load_field/name=mr_menu', array( $this, 'acf_load_menu_field_choices' ) );
// * where mr_menu is the field name
