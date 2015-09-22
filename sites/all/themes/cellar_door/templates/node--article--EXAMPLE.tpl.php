<?php $tag = ($view_mode != 'full')? 'div' : 'article'; ?>
<<?php print $tag; ?> id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>">
  <?php if ($view_mode == 'teaser') { ?>
  <?php /* ----------------- TEASER DISPLAY ----------------- */ ?>
    <a href="<?php print $node_url; ?>" class="image-and-content">
      <?php if (isset($images[0]['uri'])){ ?>
      <div class="image">
        <img src="<?php print image_style_url('ratio_4_3', $images[0]['uri']); ?>" alt="<?php print $images[0]['attr']['alt']; ?>" title="<?php print $images[0]['attr']['title']; ?>"/>
      </div>
      <?php } ?>
      <div class="content">
        <h2><?php print $title; ?></h2>
      	<?php if (isset($node_body_summary_html)){ ?>
      	<div class="summary">
          <p><?php print $node_body_summary_html; ?></p>
      	</div>
        <?php } ?>
    	</div>
    </a>
  <?php } elseif ($view_mode == 'full') { ?>
  <?php /* ----------------- FULL DISPLAY ----------------- */ ?>
  <?php if (isset($title)){ ?>
  <header>
    <h1><?php print $title; ?></h1>
  </header>
  <?php } ?>
  <div class="content">
     <?php if (isset($images[0]['uri']) && count($images) > 0){ ?>
     <div class="image">
        <figure>
          <img src="<?php print image_style_url('ratio_16_9', $images[0]['uri']); ?>" alt="<?php print $images[0]['attr']['alt']; ?>" title="<?php print $images[0]['attr']['title']; ?>"/>
          <figcaption>
            <?php if (isset($images[0]['description'])){ ?>
              <?php print $images[0]['description']; ?>
            <?php } ?>
          </figcaption>
        </figure>
     </div>
     <?php } ?>

    <div class="body">
      <?php if (isset($node_body_html)) { ?>
      <?php print $node_body_html; ?>
      <?php } ?>
    </div>

    <?php if (isset($node_tags)) { ?>
    <aside class="tags">
      <?php print $node_tags; ?>
    </aside>
    <?php } ?>

  </div><!-- /.content -->
  <?php } ?>

</<?php print $tag; ?>> <!-- /node-->