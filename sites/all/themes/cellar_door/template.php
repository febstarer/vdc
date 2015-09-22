<?php

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('clear_registry')) {
	// Rebuild .info data.
	system_rebuild_theme_data();
	// Rebuild theme registry.
	drupal_theme_rebuild();
}

/**
 * Implements hook_html_head_alter().
 */
function cellar_door_html_head_alter(&$head_elements) {
	// This meta uses 'about' attribute, which is non-standard
	unset($head_elements['rdf_node_title']);
}

/**
 * Implements hook_admin_paths_alter().
 */
function cellar_door_admin_paths_alter(&$paths) {
  $paths['node/*'] = FALSE;
}

/**
 * Preprocesses the wrapping HTML.
 *
 * @param array &$vars
 *   Template variables.
 */
function cellar_door_preprocess_html(&$vars) {
	if ($vars['is_front']) {
   	$vars['head_title'] = $vars['head_title_array']['name'];
  }

	// Setup IE meta tag to force IE rendering mode
	$meta_ie_render_engine = array(
		'#type' => 'html_tag',
		'#tag' => 'meta',
		'#attributes' => array(
			'content' =>  'IE=edge,chrome=1',
			'http-equiv' => 'X-UA-Compatible',
		)
	);
	drupal_add_html_head($meta_ie_render_engine, 'meta_ie_render_engine');

	// Mobile viewport optimized: h5bp.com/viewport
	// Add this for the Responsive web
	$meta_viewport = array(
		'#type' => 'html_tag',
		'#tag' => 'meta',
		'#attributes' => array(
			'content' =>  'initial-scale=1.0, width=device-width',
			'name' => 'viewport',
		),
	);
  drupal_add_html_head($meta_viewport, 'meta_viewport');

  // external scripts
  drupal_add_js(libraries_get_path('modernizr'). '/modernizr.custom.87176.js');

  // Touch screen icons
  $icon =  array(
    '#tag' => 'link',
    '#attributes' => array(
      'href' => base_path() . path_to_theme() . '/touch-icon.png',
      'rel' => 'apple-touch-icon',
    ),
  );
  drupal_add_html_head($icon, 'meta_touch_icon');
  $icon_sizes = array(76, 120, 152);
  foreach($icon_sizes as $size){
    $icon = array(
      '#tag' => 'link',
      '#attributes' => array(
        'href' => base_path() . path_to_theme() . '/touch-icon-' . $size . 'x' . $size . '.png',
        'rel' => 'apple-touch-icon',
        'sizes' => $size . 'x' . $size,
      ),
    );
    drupal_add_html_head($icon, 'meta_touch_icon_' . $size);
  }

  // PAGE FORMATS
  // if is body, print just the contents of the body, without anything else (to use in async calls that also need the wrapping)
	$vars['is_format_body'] = cellar_door_is_format('body');
	// if is oasync, print just the content, without anything else (pure data to use in async calls)
	$vars['is_format_ajax'] = cellar_door_is_format('oasync');
	// if is oasis, print just the content and also styles (<head>) and scripts (useful for an overlay showing just the content but with styles)
	$vars['is_format_oasis'] = cellar_door_is_format('oasis');
}

function cellar_door_is_format($format){
	return (arg(0) == $format || (isset($_GET[$format]) && $_GET[$format] == '1'));
}

function cellar_door_preprocess_page(&$vars, $hook) {
	$header = drupal_get_http_header("status");
	if($header == "404 Not Found" || $header == "403 Forbidden" || $header == "500 Internal server error") {
	   $vars['error']['info'] = t($header);
	   $vars['theme_hook_suggestions'][] = 'page__error';
	}

	if (isset($vars['node_title'])) {
		$vars['title'] = $vars['node_title'];
	}

	$vars['is_format_ajax'] = cellar_door_is_format('oasync');
	$vars['is_format_oasis'] = cellar_door_is_format('oasis');

	// Adding a class to #page in wireframe mode
	if (theme_get_setting('wireframe_mode')) {
		$vars['classes_array'][] = 'wireframe-mode';
	}

	// Adding classes wether #navigation is here or not
	if (!empty($vars['main_menu']) or !empty($vars['sub_menu'])) {
		$vars['classes_array'][] = 'with-navigation';
	}

	// must show title
	$vars['must_show_title'] = FALSE;

	// taxonomy page
	if (arg(0) == 'taxonomy' && arg(1) == 'term' && is_numeric(arg(2))) {
		$vars['page']['content']['system_main']['nodes']['#prefix'] = '<div class="term-nodes">';
    $vars['page']['content']['system_main']['nodes']['#suffix'] = '</div>';
	}
}

function cellar_door_preprocess_region(&$vars) {
  $vars['is_format_ajax'] = cellar_door_is_format('oasync');
	$vars['is_format_oasis'] = cellar_door_is_format('oasis');
}

function cellar_door_preprocess_search_result(&$vars){
	$node_obj = $vars['result']['node'];

}

function cellar_door_preprocess_node(&$vars) {
	$node_obj = $vars['elements']['#node'];

	// Add a striping class.
	$vars['classes_array'][] = 'node-' . $vars['zebra'];

	// Add view mode class (if not teaser, because it already has it)
	if ($vars['view_mode'] != 'teaser') $vars['classes_array'][] = 'node-' . $vars['view_mode'];

	// entity title
  if ($vars['view_mode'] == 'full'){
  	if (drupal_is_front_page()){
  		unset($vars['title']);
  	}else{
	  	$entity_title = field_get_items('node', $node_obj, 'title_field');
		  if (isset($entity_title[0]['safe_value'])){
		    $vars['title'] = $entity_title[0]['safe_value'];
		  }
  	}
	}

	// body and summary
	$body = field_get_items('node', $node_obj, 'body');
	if (isset($body[0]['safe_value'])){
		$vars['node_body_html'] = $body[0]['safe_value'];
		$summary = $body[0]['safe_value'];
		if (isset($body[0]['safe_summary']) && $body[0]['safe_summary'] != ''){
			$summary = $body[0]['safe_summary'];
		}
		$vars['node_body_summary_html'] = cellar_door_truncate($summary, 160);
	}

	// other type specific fields
	//oh_log($vars['type']);
	switch ($vars['type']) {
		case 'page': /********** PAGE **********/

			break;
		case 'article': /********** ARTICLE **********/
			// images
			/*$images = field_get_items('node', $node_obj, 'field_images');
			if (isset($images[0]['uri'])){
				if ($vars['view_mode'] == 'teaser'){
					$vars['teaser_image'] = theme('image_style', array('path' => $images[0]['uri'], 'style_name' => '4_cols'));
				}else{
					$vars['images'] = array();
					foreach ($images as $key => $image) {
						$vars['images'][] = theme('image_style', array('path' => $image['uri'], 'style_name' => 'full_width'));
					}
				}
			}*/
			break;
	}
}

function cellar_door_preprocess_comment(&$vars) {
	$comment = $vars['elements']['#comment'];
	$vars['picture'] = theme('user_picture', array('account' => $comment));
}

function cellar_door_preprocess_block(&$vars, $hook) {
	// Add a striping class.
	//$vars['classes_array'][] = 'block-' . $vars['zebra'];

	// is this a navigation block
	$vars['is_navigation'] = ($vars['block']->module == 'menu' || in_array($vars['block']->delta, array('main-menu')));
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function cellar_door_breadcrumb($vars) {
	$breadcrumb = $vars['breadcrumb'];  // Determine if we are to display the breadcrumb.
	$show_breadcrumb = theme_get_setting('cellar_door_breadcrumb');
	if ($show_breadcrumb == 'yes' || ($show_breadcrumb == 'admin' && arg(0) == 'admin')) {

		// Optionally get rid of the homepage link.
		$show_breadcrumb_home = theme_get_setting('cellar_door_breadcrumb_home');
		if (!$show_breadcrumb_home) {
			array_shift($breadcrumb);
		}
		// Return the breadcrumb with separators.
		if (!empty($breadcrumb)) {
			$breadcrumb_separator = theme_get_setting('cellar_door_breadcrumb_separator');
			$trailing_separator = $title = '';
			if (theme_get_setting('cellar_door_breadcrumb_title')) {
				$item = menu_get_item();
				if (!empty($item['tab_parent'])) {
					// If we are on a non-default tab, use the tab's title.
					$title = check_plain($item['title']);
				}
				else {
					$title = drupal_get_title();
				}
				if ($title) {
					$trailing_separator = $breadcrumb_separator;
				}
			}
			elseif (theme_get_setting('cellar_door_breadcrumb_trailing')) {
				$trailing_separator = $breadcrumb_separator;
			}
			// Provide a navigational heading to give context for breadcrumb links to
			// screen-reader users. Make the heading invisible with .element-invisible.
			$heading = '<h2 class="element-invisible sure">' . t('You are here') . '</h2>';


			return $heading . '<div class="breadcrumb">' . implode($breadcrumb_separator, $breadcrumb) . $trailing_separator . $title . '</div>';
		}
	}
	// Otherwise, return an empty string.
	return '';
}

/*
 *   Converts a string to a suitable html ID attribute.
 *
 *    http://www.w3.org/TR/html4/struct/global.html#h-7.5.2 specifies what makes a
 *    valid ID attribute in HTML. This function:
 *
 *   - Ensure an ID starts with an alpha character by optionally adding an 'n'.
 *   - Replaces any character except A-Z, numbers, and underscores with dashes.
 *   - Converts entire string to lowercase.
 *
 *   @param $string
 *     The string
 *   @return
 *     The converted string
 */
function cellar_door_id_safe($string) {
	// Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
	$string = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $string));
	// If the first character is not a-z, add 'n' in front.
	if (!ctype_lower($string{0})) { // Don't use ctype_alpha since its locale aware.
		$string = 'id' . $string;
	}
	return $string;
}

/**
 * Generate the HTML output for a menu link and submenu.
 *
 * @param $vars
 *   An associative array containing:
 *   - element: Structured array data for a menu link.
 *
 * @return
 *   A themed HTML string.
 *
 * @ingroup themeable
 */
function cellar_door_menu_link(array $vars) {
	$element = $vars['element'];

	$sub_menu = '';

	// Adding a class depending on the TITLE of the link (not constant)
	$element['#attributes']['class'][] = cellar_door_id_safe($element['#title']);
	// Adding a class depending on the ID of the link (constant)
	if (isset($element['#original_link']['mlid']) && !empty($element['#original_link']['mlid'])) {
		$element['#attributes']['class'][] = 'mid-' . $element['#original_link']['mlid'];

		// changing some link
		/*if ($element['#original_link']['mlid'] == 796){
			$element['#localized_options']['attributes']['rel'] = 'external';
		}*/
	}

	if ($element['#below']) {
		$sub_menu = drupal_render($element['#below']);
	}
	$output = l($element['#title'], $element['#href'], $element['#localized_options']);

	return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Override or insert variables into theme_menu_local_task().
 */
function cellar_door_preprocess_menu_local_task(&$vars) {
	$link =& $vars['element']['#link'];

	// If the link does not contain HTML already, check_plain() it now.
	// After we set 'html'=TRUE the link will not be sanitized by l().
	if (empty($link['localized_options']['html'])) {
		$link['title'] = check_plain($link['title']);
	}
	$link['localized_options']['html'] = TRUE;
	$link['title'] = '<span class="tab">' . $link['title'] . '</span>';
}

/*
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function cellar_door_menu_local_tasks(&$vars) {
	$output = '';

	if (!empty($vars['primary'])) {
		$vars['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
		$vars['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
		$vars['primary']['#suffix'] = '</ul>';
		$output .= drupal_render($vars['primary']);
	}
	if (!empty($vars['secondary'])) {
		$vars['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
		$vars['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
		$vars['secondary']['#suffix'] = '</ul>';
		$output .= drupal_render($vars['secondary']);
	}

	return $output;
}

// disable annoying grippie in textareas
function cellar_door_textarea($vars) {
	$element = $vars['element'];
	$element['#attributes']['name'] = $element['#name'];
	$element['#attributes']['id'] = $element['#id'];
	$element['#attributes']['cols'] = $element['#cols'];
	$element['#attributes']['rows'] = $element['#rows'];
	_form_set_class($element, array('form-textarea'));

	$wrapper_attributes = array(
		'class' => array('form-textarea-wrapper'),
	);

	// Add resizable behavior.
	if (!empty($element['#resizable'])) {
		$wrapper_attributes['class'][] = 'resizable';
	}

	$output = '<div' . drupal_attributes($wrapper_attributes) . '>';
	$output .= '<textarea' . drupal_attributes($element['#attributes']) . '>' . check_plain($element['#value']) . '</textarea>';
	$output .= '</div>';
	return $output;
}


function cellar_door_truncate($text, $max_length = 160, $allowed_tags = array(), $wordsafe = TRUE, $add_ellipsis = TRUE){
  return truncate_utf8(filter_xss($text, $allowed_tags), $max_length, $wordsafe, $add_ellipsis);
}