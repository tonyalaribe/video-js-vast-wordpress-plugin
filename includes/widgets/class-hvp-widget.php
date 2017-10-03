<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

add_action('widgets_init', 'hvp_widget');

/**
 * Register the True Pundit Video Widget
 *
 * @package True Pundit Video Player
 * @since 1.0.0
 */
function hvp_widget() {
    register_widget('Hvp_Widget');
}

/**
 * Widget Class
 *
 * Handles generic functionailties
 *
 * @package True Pundit Video Player
 * @since 1.0.0
 */

class Hvp_Widget extends WP_Widget {
    
    public $model;
    public $template_arr = array('vjs-default-skin'=> 'Default');
    
    public function __construct() {
        global $hvp_model;
        $widget_ops = array('classname' => 'widget_text', 'description' => __('Display video with True Pundit Video Player', HVP_TEXTDOMAIN));        
        WP_Widget::__construct('hvp-widget', __('True Pundit Video Player', HVP_TEXTDOMAIN), $widget_ops);
        $this->model = $hvp_model;
    }

    public function form($instance) {
        
        // outputs the options form on admin
        $default = array(
            'title' => '',
            'url' => '',
            'is_video_ads' => '',
            'adtagurl' => '',
            'width' => '',
            'height' => '',
            'poster' => '',
            'class' => '',
            'template' => $this->template_arr[0],
        );
        $cdn_customerid = get_option('hvp-cdn-customerid');

        $instance = wp_parse_args((array) $instance, $default);

        $title = $instance['title'];
        $url = $instance['url'];
        $adtagurl = $instance['adtagurl'];
        $width = $instance['width'];
        $height = $instance['height'];
        $poster = $instance['poster'];
        $ytcontrol = $instance['ytcontrol'];
        $class = $instance['class'];
        $template = $instance['template'];

        wp_nonce_field(HVP_PREFIX . '_noun');
        ?>
        
        <!-- Title: Text Box -->
        <p>
            <p class="hvp-title">
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', HVP_TEXTDOMAIN); ?></label>
            </p>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" 
              type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <!-- URL: Text Box -->
        <p>
            <p class="hvp-title">
                <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Video:', HVP_TEXTDOMAIN); ?></label>
            </p>
            <input class="widefat" placeholder="URL" id="<?php echo $this->get_field_id('url'); ?>" 
                name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" />
            or
            <input type="file" name="video-file" id="video-file">
            <button type="button" class="hvp-video-upload button button-primary"><?php _e('Upload', HVP_TEXTDOMAIN); ?></button>
        </p>

        <!-- Poster url: Text Box -->
        <p>
            <p class="hvp-title">
                <label for="<?php echo $this->get_field_id('poster'); ?>"><?php _e('Poster URL:', HVP_TEXTDOMAIN); ?></label>
            </p>
            
            <input class="widefat" placeholder="URL" id="<?php echo $this->get_field_id('poster'); ?>" 
                name="<?php echo $this->get_field_name('poster'); ?>" type="text" value="<?php echo esc_attr($poster); ?>" />
            or
            <button type="button" class="hvp-poster-upload button button-primary"><?php _e('Upload', HVP_TEXTDOMAIN); ?></button>
        </p>

        <!-- Width: Text Box -->
        <div class="hvp-widget-2col">
            <p class="hvp-popup-col">
                <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:', HVP_TEXTDOMAIN); ?></label>
                <input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>" />
            </p>
            <p class="hvp-popup-col">
                <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:', HVP_TEXTDOMAIN); ?></label>
                <input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" />
            </p>
        </div>

        <div class="hvp-chk widefat">
            <input type="checkbox" <?php checked($instance['controls'], 'on');?> id="<?php echo $this->get_field_id('controls'); ?>" 
                name="<?php echo $this->get_field_name('controls'); ?>">
            <label for="<?php _e($this->get_field_id('controls')); ?>"><?php _e('Show controls'); ?></label>
        </div>

        <div class="hvp-chk widefat">
            <input type="checkbox" <?php checked($instance['autoplay'], 'on');?> id="<?php echo $this->get_field_id('autoplay'); ?>" 
                name="<?php echo $this->get_field_name('autoplay'); ?>">
            <label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Autoplay (desktop only)'); ?></label>
        </div>

        <div class="hvp-chk widefat">
            <input type="checkbox" <?php checked($instance['loop'], 'on');?> id="<?php echo $this->get_field_id('loop'); ?>" 
                name="<?php echo $this->get_field_name('loop'); ?>">
            <label for="<?php echo $this->get_field_id('loop'); ?>"><?php _e('Loop video'); ?></label>
        </div>

        <div class="hvp-chk widefat">
            <input type="checkbox" <?php checked($instance['muted'], 'on');?> id="<?php echo $this->get_field_id('muted'); ?>" 
                name="<?php echo $this->get_field_name('muted'); ?>">
            <label for="<?php echo $this->get_field_id('muted'); ?>"><?php _e('Mute video'); ?></label>
        </div>

        <!-- Youtube or Vimeo Control : Select Box -->
        <div class="hvp-chk widefat">
            <input type="checkbox" <?php checked($instance['ytcontrol'], 'on');?> id="<?php echo $this->get_field_id('ytcontrol'); ?>"
                name="<?php echo $this->get_field_name('ytcontrol'); ?>">
            <label for="<?php echo $this->get_field_id('ytcontrol'); ?>"><?php _e('YouTube or Vimeo controls'); ?></label>
        </div>

        <!-- Modifier Class : Text Box -->
        <p>
            <p class="hvp-title">
                <label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Modifier Class:', HVP_TEXTDOMAIN); ?></label>
            </p>
            <input class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($class); ?>" />
        </p>
        
        <div class="hvp-chk widefat">
            <input type="checkbox" <?php checked($instance['is_video_ads'], 'on');?>
                id="<?php echo $this->get_field_id('is_video_ads'); ?>"
                class="hvp-video-ads"
                name="<?php echo $this->get_field_name('is_video_ads'); ?>">
            <label for="<?php echo $this->get_field_id('is_video_ads'); ?>"></label>
        </div>
        <input class="widefat hvp-ads-container" type="text"  name="<?php echo $this->get_field_name('adtagurl'); ?>" 
            placeholder="<?php _e('Ad tag url (IMA/VAST/VPAID/VMAP)', HVP_TEXTDOMAIN);?>"
            value="<?php echo esc_attr($adtagurl); ?>">
        <p>
<!--         <?php if ($cdn_customerid) { ?>
            <p>HolaCDN analytics activated for account <?php _e($cdn_customerid); ?>!</p>
        <?php } else { ?>
            <a target="_blank" onclick="window.ga('hvp.send', 'event', 'wp-plugin', 'click', 'widget-analytics-link')"
              href="<?php echo admin_url('admin.php?page=hvp_player_setting_page'); ?>">
                <?php _e('HolaCDN account required. Sign up and get free video analytics.'); ?>
            </a>
        <?php } ?> -->
        </p>

    <?php
    }

    public function update($new_instance, $old_instance) {
        // processes widget options to be saved
        $instance = $old_instance;
        $formNonce = $_POST['_wpnonce'];

        if(wp_verify_nonce($formNonce, HVP_PREFIX.'_noun')) {
            $instance['title'] = $this->model->hvp_escape_slashes_deep($new_instance['title']);
            $instance['url'] = $this->model->hvp_escape_slashes_deep($new_instance['url']);
            $instance['is_video_ads'] = $new_instance['is_video_ads'];
            $instance['adtagurl'] = $this->model->hvp_escape_slashes_deep($new_instance['adtagurl']);
            $instance['width'] = $this->model->hvp_escape_slashes_deep($new_instance['width']);
            $instance['height'] = $this->model->hvp_escape_slashes_deep($new_instance['height']);
            $instance['controls'] = $new_instance['controls'];
            $instance['autoplay'] = $new_instance['autoplay'];
            $instance['poster'] = $this->model->hvp_escape_slashes_deep($new_instance['poster']);
            $instance['loop'] = $new_instance['loop'];
            $instance['muted'] = $new_instance['muted'];
            $instance['ytcontrol'] = $new_instance['ytcontrol'];
            $instance['class'] = $this->model->hvp_escape_slashes_deep($new_instance['class']);
            $instance['template'] = $this->model->hvp_escape_slashes_deep($new_instance['template']);
        }

        return $new_instance;
    }

    public function widget($args, $instance) {
        foreach ($instance as $key => $value) {
            if ($value === 'on') {
                $instance[$key] = 'true';
            }
        }
        echo $args['before_widget'];
        if ($instance['title'])
            echo $args['before_title'], $instance['title'], $args['after_title'];
        echo hvp_build_video_tag($instance);
        echo $args['after_widget'];
    }
}

?>
