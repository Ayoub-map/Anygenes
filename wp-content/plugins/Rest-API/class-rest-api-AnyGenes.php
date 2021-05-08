<?php
/**
* Main class.
*
* @package Rest_Api_AnyGenes
*/

class Rest_Api_AnyGenes {

    /**
     * Returns the instance.
     */
    public static function get_instance() {

        static $instance = null;

        if ( is_null( $instance ) ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Constructor method.
     */
    private function __construct() {
        $this->includes();
    }

    // Includes
    public function includes() {
  include_once REST_API_AnyGenes_PLUGIN_DIR . '/parts/part-2/method-1.php';
    }
}