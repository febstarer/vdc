<?php if (!$is_format_ajax && !$is_format_body){ ?>
<!doctype html>
<!--[if IEMobile 7]><html class="no-js iem7"<?php print $html_attributes; ?>><![endif]-->
<!--[if lte IE 6]><html class="no-js lt-ie9 lt-ie8 lt-ie7"<?php print $html_attributes; ?>><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="no-js lt-ie9 lt-ie8"<?php print $html_attributes; ?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"<?php print $html_attributes; ?>><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><!--><html class="no-js"<?php print $html_attributes . $rdf_namespaces; ?>><!--<![endif]-->

<head>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>

  <?php if ($default_mobile_metatags): ?>
  <meta name="MobileOptimized" content="width">
  <meta name="HandheldFriendly" content="true">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php endif; ?>
  <meta http-equiv="cleartype" content="on">

  <?php print $styles; ?>
  <?php print $scripts; ?>

  <?php if ($add_html5_shim and !$add_respond_js): ?>
    <!--[if lt IE 9]>
    <script src="<?php print $base_path . $path_to_zen; ?>/js/html5.js"></script>
    <![endif]-->
  <?php elseif ($add_html5_shim and $add_respond_js): ?>
    <!--[if lt IE 9]>
    <script src="<?php print $base_path . $path_to_zen; ?>/js/html5-respond.js"></script>
    <![endif]-->
  <?php elseif ($add_respond_js): ?>
    <!--[if lt IE 9]>
    <script src="<?php print $base_path . $path_to_zen; ?>/js/respond.js"></script>
    <![endif]-->
  <?php endif; ?>
  <?php if (isset($environment) && $environment == 'pro') { ?>
  <?php // Insert here the Google Analytics code ?>
  <?php } ?>
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <?php if (!$is_format_oasis){ ?>

  <?php if ($skip_link_text && $skip_link_anchor){ ?>
  <p id="skip-link">
    <a href="#<?php print $skip_link_anchor; ?>" class="element-invisible element-focusable"><?php print $skip_link_text; ?></a>
  </p>
  <?php } ?>
  <?php print $page_top; ?>
  <?php print $page; ?>

  <?php }else{ ?>
  <?php print $page; ?>
  <?php } ?>

  <?php print $page_bottom; ?>
</body>
</html>
<?php } else { ?>
<?php print $page; ?>
<?php }