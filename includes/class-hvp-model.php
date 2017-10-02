<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Plugin Model Class
 *
 * Handles generic functionailties
 *
 * @package True Pundit Video Player
 * @since 1.0.0
 */

class Hvp_Model {
          
     //class constructor
    public function __construct()    {        
    }
        
     /**
      * Stripslashes
       *
        * It will strip slashes from the content
      *
      * @package True Pundit Video Player
      * @since 1.0.0
      */
    
     public function hvp_escape_slashes_deep($data = array(),$flag = false){
         
         if($flag != true) {
            $data = $this->hvp_nohtml_kses($data);
        }
        $data = stripslashes_deep($data);
        return $data;
     }
    /**
     * Strip Html Tags
     *
     * It will sanitize text input (strip html tags, and escape characters)
     *
     * @package True Pundit Video Player
     * @since 1.0.0
     */
    public function hvp_nohtml_kses($data = array()) {
        
        
        if (is_array($data)) {
            
            $data = array_map(array($this,'hvp_nohtml_kses'), $data);
            
        } elseif (is_string($data)) {
            
            $data = wp_filter_nohtml_kses($data);
        }
        
        return $data;
    }    
}
?>
