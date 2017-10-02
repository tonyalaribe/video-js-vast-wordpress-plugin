<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Settings Page
 *
 * Handle HolaCDN integration settings
 *
 * @package True Pundit Video Player
 * @since 1.3
 */

//$cdn_customerid = get_option('hvp-cdn-customerid');
//wp_add_inline_script('hvp_ga_script', "ga('hvp.set', 'page', 'wp-plugin-settings'); ga('hvp.send', 'pageview');");
?>
<!-- . begining of wrap -->
<div class="wrap">
  <?php
    echo screen_icon('options-general'); 
    echo "<h1>" . __('True Pundit Video Player', HVP_TEXTDOMAIN) . "</h1>";
  ?> 

  <h2>True Pundit Video Settings .</h2>
  <ul class="hvp-cdn-signup-steps">
<!--     <li>
      <?php if ($cdn_customerid) { ?>
          <p>HolaCDN analytics account activated!!</p>
      <?php } else { ?>
        <a href="//holacdn.com?need_signup=1&cam=wordpress" target="_blank"
        onclick="window.ga('hvp.send', 'event', 'wp-plugin', 'click', 'cdn-signup')"
        class="button button-primary">Sign up</a> for HolaCDN.
      <?php } ?>
    </li> -->
<!--     <li>
      <form method="post" name="hvp-cdn-customerid" action="options.php">
        <?php settings_fields('hvp-cdn-settings'); ?>
        <?php do_settings_sections('hvp-cdn-settings'); ?>
        <p>Insert your Customer ID. You can find your customer ID at <a
        href="https://holacdn.com/cp/account" target="_blank">your HolaCDN
        account page</a>.</p>
        <input type="text" class="hvp-input"
          id="hvp-cdn-customerid" name="hvp-cdn-customerid"
          onchange="window.ga('hvp.send', 'event', 'wp-plugin', 'setvalue', 'cdn-customerid')"
          value="<?php echo esc_attr(get_option('hvp-cdn-customerid')); ?>" />
        <?php submit_button(); ?>
      </form>
    </li> -->

      <form method="post" name="hvp-cdn-customerid" action="options.php">
        <?php settings_fields('hvp-cdn-settings'); ?>
        <?php do_settings_sections('hvp-cdn-settings'); ?>
        <li>
          <p>Insert your Default VAST URL</p>
          <input type="text" class="hvp-input"
            id="tp-default-vast-urlmerid" name="tp-default-vast-url"
            value="<?php echo esc_attr(get_option('tp-default-vast-url')); ?>" />
        </li>
        <li>
          <p>Insert your AWS access key id</p>
          <input type="text" class="hvp-input"
            id="tp-aws-access-key-id" name="tp-aws-access-key-id"
            value="<?php echo esc_attr(get_option('tp-aws-access-key-id')); ?>" />
        </li>
        <li>
          <p>Insert your AWS Secret key</p>
          <input type="text" class="hvp-input"
            id="tp-aws-secret-key" name="tp-aws-secret-key"
            value="<?php echo esc_attr(get_option('tp-aws-secret-key')); ?>" />
        </li>
        <?php submit_button(); ?>
      </form>
    </li>
  </ol>
</div><!-- .end of wrap -->
