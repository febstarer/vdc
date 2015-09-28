<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function cellar_door_preprocess_maintenance_page(&$vars) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  cellar_door_preprocess_html($vars, $hook);
  cellar_door_preprocess_page($vars, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cellar_door_preprocess_html(&$vars) {
  if ($vars['is_front']) {
    $vars['head_title'] = $vars['head_title_array']['name'];
  }

  // external scripts
  drupal_add_js(libraries_get_path('modernizr'). '/modernizr.custom.87176.js');

  // Touch screen icons
  /*$icon =  array(
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
  }*/

  // Page formats
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

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cellar_door_preprocess_page(&$vars) {
  // Error pages templating
  $header = drupal_get_http_header("status");
  if($header == "404 Not Found" || $header == "403 Forbidden" || $header == "500 Internal server error") {
     $vars['error']['info'] = t($header);
     $vars['theme_hook_suggestions'][] = 'page__error';
  }

  // Page formats
  $vars['is_format_ajax'] = cellar_door_is_format('oasync');
  $vars['is_format_oasis'] = cellar_door_is_format('oasis');

  // Adding classes if it has navigation
  if (!empty($vars['page']['navigation'])) {
    $vars['classes_array'][] = 'with-navigation';
  }

  // must show title
  $vars['must_show_title'] = FALSE;

  // taxonomy page
  if (arg(0) == 'taxonomy' && arg(1) == 'term' && is_numeric(arg(2))) {
    // proper wrapping
    $vars['page']['content']['system_main']['nodes']['#prefix'] = '<div class="term-nodes">';
    $vars['page']['content']['system_main']['nodes']['#suffix'] = '</div>';
  }
}

/**
 * Override or insert variables into the region templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cellar_door_preprocess_region(&$vars) {
  // Page formats
  $vars['is_format_ajax'] = cellar_door_is_format('oasync');
  $vars['is_format_oasis'] = cellar_door_is_format('oasis');
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cellar_door_preprocess_node(&$vars) {
  $node_obj = $vars['elements']['#node'];

  // Add a striping class.
  //$vars['classes_array'][] = 'node-' . $vars['zebra'];

  // Add view mode class (if not teaser, because it already has it)
  //if ($vars['view_mode'] != 'teaser') $vars['classes_array'][] = 'node-' . $vars['view_mode'];

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
  /*$body = field_get_items('node', $node_obj, 'body');
  if (isset($body[0]['safe_value'])){
    $vars['node_body_html'] = $body[0]['safe_value'];
    $summary = $body[0]['safe_value'];
    if (isset($body[0]['safe_summary']) && $body[0]['safe_summary'] != ''){
      $summary = $body[0]['safe_summary'];
    }
    $vars['node_body_summary_html'] = oh_truncate($summary, 160);
  }*/

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

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
function cellar_door_preprocess_comment(&$vars) {
  /*$comment = $vars['elements']['#comment'];
  $vars['picture'] = theme('user_picture', array('account' => $comment));*/
}

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function cellar_door_preprocess_block(&$vars, $hook) {
  // Add a striping class.
  //$vars['classes_array'][] = 'block-' . $vars['zebra'];

  // is this a navigation block
  $vars['is_navigation'] = ($vars['block']->module == 'menu' || in_array($vars['block']->delta, array('main-menu')));
}

/**
 * Process variables for search-result.tpl.php.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cellar_door_preprocess_search_result(&$vars){
  $node_obj = $vars['result']['node'];

}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $variables
 *   - title: An optional string to be used as a navigational heading to give
 *     context for breadcrumb links to screen-reader users.
 *   - title_attributes_array: Array of HTML attributes for the title. It is
 *     flattened into a string within the theme function.
 *   - breadcrumb: An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
/*function cellar_door_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  $output = '';

  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('zen_breadcrumb');
  if ($show_breadcrumb == 'yes' || $show_breadcrumb == 'admin' && arg(0) == 'admin') {

    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('zen_breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $breadcrumb_separator = filter_xss_admin(theme_get_setting('zen_breadcrumb_separator'));
      $trailing_separator = $title = '';
      if (theme_get_setting('zen_breadcrumb_title')) {
        $item = menu_get_item();
        if (!empty($item['tab_parent'])) {
          // If we are on a non-default tab, use the tab's title.
          $breadcrumb[] = check_plain($item['title']);
        }
        else {
          $breadcrumb[] = drupal_get_title();
        }
      }
      elseif (theme_get_setting('zen_breadcrumb_trailing')) {
        $trailing_separator = $breadcrumb_separator;
      }

      // Provide a navigational heading to give context for breadcrumb links to
      // screen-reader users.
      if (empty($variables['title'])) {
        $variables['title'] = t('You are here');
      }
      // Unless overridden by a preprocess function, make the heading invisible.
      if (!isset($variables['title_attributes_array']['class'])) {
        $variables['title_attributes_array']['class'][] = 'element-invisible';
      }

      // Build the breadcrumb trail.
      $output = '<nav class="breadcrumb" role="navigation">';
      $output .= '<h2' . drupal_attributes($variables['title_attributes_array']) . '>' . $variables['title'] . '</h2>';
      $output .= '<ol><li>' . implode($breadcrumb_separator . '</li><li>', $breadcrumb) . $trailing_separator . '</li></ol>';
      $output .= '</nav>';
    }
  }

  return $output;
}*/

