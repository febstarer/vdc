<?php
/**
 * @file
 * Returns the HTML for the footer region.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728140
 */

/* Using the same code as region.tpl.php, as long as we want to put the footer markup inside page.tpl.php.
 *  If we erased this useless tpl, it would fallback to zen's, something we do not want
 */
?>
<?php if ($content): ?>
  <div class="<?php print $classes; ?>">
    <?php print $content; ?>
  </div>
<?php endif; ?>
