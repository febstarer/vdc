<?php if (!$is_format_ajax && !$is_format_oasis): ?>
<?php if ($content): ?>
  <div class="<?php print $classes; ?>">
    <?php print $content; ?>
  </div>
<?php endif; ?>
<?php else: ?>
<?php print $content; ?>
<?php endif;