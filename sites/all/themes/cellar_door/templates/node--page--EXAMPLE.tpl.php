<?php $tag = ($view_mode != 'full')? 'div' : 'article'; ?>
<<?php print $tag; ?> id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>">

  <?php if ($view_mode == 'teaser') { ?>
  <?php // there is no teaser display ?>
  <?php } elseif ($view_mode == 'full') { ?>
  <?php /* ----------------- FULL DISPLAY ----------------- */ ?>
  <section class="main-content">
    <?php if (isset($title)) { ?>
    <header>
      <h1><?php print $title; ?></h1>
    </header>
    <?php } ?>
    <div class="content">
      <div class="body">
        <?php if (isset($node_body_html)) { ?>
        <?php print $node_body_html; ?>
        <?php } ?>
      </div>
    </div><!-- /.content -->
  </section><!-- /.main-content -->
  <?php } ?>
</<?php print $tag; ?>> <!-- /node-->