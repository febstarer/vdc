<?php if (!$is_format_ajax && !$is_format_oasis){ ?>
<div id="page" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <header class="header" id="header" role="banner">
    <div class="inner">
    <?php if ($logo){ ?>
    <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="header__logo" id="logo">
      <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="header__logo-image" />
    </a>
    <?php } ?>

    <?php if ($site_name || $site_slogan){ ?>
    <div class="header__name-and-slogan" id="name-and-slogan">
      <?php if ($site_name){ ?>
      <h1 class="header__site-name" id="site-name">
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" class="header__site-link" rel="home">
          <span><?php print $site_name; ?></span>
        </a>
      </h1>
      <?php } ?>

      <?php if ($site_slogan){ ?>
      <div class="header__site-slogan" id="site-slogan"><?php print $site_slogan; ?></div>
      <?php } ?>
    </div>
    <?php } ?>

    <?php print render($page['header']); ?>
    </div>
  </header>

  <div id="main">
    <div class="inner">
      <div id="content" class="column" role="main">
        <?php print render($page['highlighted']); ?>
        <?php print $breadcrumb; ?>
        <a id="main-content"></a>
        <?php print render($title_prefix); ?>
        <?php if ($title && $must_show_title){ ?>
        <h1 class="page__title title" id="page-title"><?php print $title; ?></h1>
        <?php } ?>
        <?php print render($title_suffix); ?>
        <?php print $messages; ?>
        <?php print render($tabs); ?>
        <?php print render($page['help']); ?>
        <?php if ($action_links){ ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php } ?>
        <?php print render($page['content']); ?>
        <?php print $feed_icons; ?>
      </div>

      <?php if (!empty($page['navigation'])){ ?>
      <div id="navigation">
        <?php print render($page['navigation']); ?>
      </div>
      <?php } ?>

      <?php if (!empty($page['sidebar_first']) || !empty($page['sidebar_second'])){ ?>
      <aside class="sidebars">
        <?php print render($page['sidebar_first']); ?>
        <?php print render($page['sidebar_second']); ?>
      </aside>
      <?php } ?>
    </div>
  </div>

  <?php if (!empty($page['footer'])){ ?>
  <footer id="footer" role="contentinfo">
  <?php print render($page['footer']); ?>
  </footer>
  <?php } ?>

</div>

<?php print render($page['bottom']); ?>

<?php }else{ ?>
  <?php print render($page['content']) ?>
<?php }
