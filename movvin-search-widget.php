<?php
/*
Plugin Name: MOVVIN Search Widget
Description: 'A search widget for rides on movvin.com
Version: 1.0
Author: Dimitris Mavroudis
Author URI: http://dimitrismavroudis.gr
License: GPLv2 or later
*/

class movvin_search_widget extends WP_Widget {

	// constructor
    function __construct() {
		parent::__construct(
			'movvin_search_widget', // Base ID
			esc_html__( 'MOVVIN Search Widget', 'movvin_search_widget' ), // Name
			array( 'description' => esc_html__( 'A search widget for rides on movvin.com', 'movvin_search_widget' ), ) // Args
		);
	}

	// widget form creation
	function form($instance) {	
            if( $instance) {
                $title = esc_attr($instance['title']);
                $startingPointText = esc_attr($instance['startingPointText']);
                $startingPointLatLng = esc_attr($instance['startingPointLatLng']);
            } else {
                $title = 'Search rides on Movvin';
                $startingPointText = '';
                $startingPointLatLng = '';
            } ?>

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'movvin_search_widget'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" placeholder="Optional" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('startingPointText'); ?>"><?php _e('Starting point', 'movvin_search_widget'); ?></label>
                <input class="widefat movvin-autocomplete-input" id="<?php echo $this->get_field_id('startingPointText'); ?>" name="<?php echo $this->get_field_name('startingPointText'); ?>" type="text" value="<?php echo $startingPointText;?>" placeholder="Optional" />
                <input id="<?php echo $this->get_field_id('startingPointLatLng'); ?>" name="<?php echo $this->get_field_name('startingPointLatLng'); ?>" type="hidden" value="<?php echo $startingPointLatLng;?>" />
            </p>
            <script>
                jQuery( document ).ready(function() {
                    var inputs = document.getElementsByClassName('movvin-autocomplete-input');

                    for (var i = 0; i < inputs.length; i++) {
                        initAutocomplete(inputs[i]);
                    }
                });
            </script>
        <?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['startingPointText'] = strip_tags($new_instance['startingPointText']);
        $instance['startingPointLatLng'] = strip_tags($new_instance['startingPointLatLng']);
        return $instance;
	}

	// widget display
	function widget($args, $instance) {
        extract( $args );
        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        $startingPointText = $instance['startingPointText'];
        $startingPointLatLng = $instance['startingPointLatLng'];
        echo $before_widget; 
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
        ?>
        <form id="movvinSearch" method="get" action="https://movvin.com/s" enctype="application/x-www-form-urlencoded"> 
            <div class="movvin-search-bar-container"> 
                <input id="p_p_id" name="p_p_id" type="hidden"  value="ridesearch_WAR_MOVVINLiferayportlet"/>
                <input id="p_p_lifecycle" name="p_p_lifecycle" value="0" type="hidden"/>
                <div class="search-b2c-block address starting-point">
                    <label for="movvinStartingPoint">From:</label> 
                    <input id="movvinStartingPoint" name="movvinStartingPoint" value="<?php echo $startingPointText; ?>"  type="text" class="movvin-autocomplete-input" required/>
                    <input class="movvin-autocomplete-input-hidden" value="<?php echo $startingPointLatLng; ?>" name="_ridesearch_WAR_MOVVINLiferayportlet_from" type="hidden"  />
                    <input class="movvin-autocomplete-input-hidden" value="<?php echo $startingPointText; ?>" name="_ridesearch_WAR_MOVVINLiferayportlet_fromText" type="hidden"/>
                </div> 
                <div class="search-b2c-block address destination">
                    <label for="movvinDestination">To:</label>
                    <input id="movvinDestination" name="movvinDestination" type="text" class="movvin-autocomplete-input" />
                    <input class="movvin-autocomplete-input-hidden" name="_ridesearch_WAR_MOVVINLiferayportlet_to" type="hidden"/>
                    <input class="movvin-autocomplete-input-hidden" name="_ridesearch_WAR_MOVVINLiferayportlet_toText" type="hidden"/>
                </div> 
                <div class="search-b2c-block date">
                    <label for="movvinDatePicker">Date:</label>
                    <input id="movvinDatePicker" type="text" value="<?php echo date("d/m/y"); ?>"/>
                    <input id="movvinDate" class="movvin-autocomplete-input-hidden" value="" name="_ridesearch_WAR_MOVVINLiferayportlet_date" type="hidden" required/>
                </div>
                <div class="search-b2c-block passengers">
                    <label for="movvinPassengers">Passengers:</label> 
                    <select id="movvinPassengers" required name="_ridesearch_WAR_MOVVINLiferayportlet_passengers" size="1"> 
                        <option value="1" selected="selected">1</option> 
                        <option value="2">2</option> 
                        <option value="3">3</option> 
                        <option value="4">4</option> 
                        <option value="5">5</option> 
                        <option value="6">6</option> 
                        <option value="7">7</option> 
                        <option value="8">8</option>
                        <option value="9">9</option> 
                        <option value="10">10</option> 
                    </select>
                </div> 
            <input id="_ridesearch_WAR_MOVVINLiferayportlet_radius" name="_ridesearch_WAR_MOVVINLiferayportlet_radius" type="hidden" value="18000"/>
            <button id="movvinSubmit" class="movvin-button" type="submit" role="button" aria-disabled="false">
                <span>Search</span>
            </button> 
            <div class="movvin-pwrby"><span>Powered by </span><img src="https://cdn.movvin.com/TestTheme/images/movvin-logo-original.svg" alt="Movvin" height="20" width="106"/></div>
        </div>
    </form>
    <?php
        echo $after_widget;
	}
}

if (! function_exists('enqueue_movvin_search_widget_css')) {
    function enqueue_movvin_search_widget_css() {
        wp_enqueue_style( 'movvin-search-widget-css', plugins_url( 'style.css', __FILE__ ) );
    }
    add_action( 'wp_enqueue_scripts', 'enqueue_movvin_search_widget_css' );
}

if (! function_exists('enqueue_movvin_search_widget_js')) {
    function enqueue_movvin_search_widget_js() {
        wp_enqueue_script('google-maps-api-js','https://maps.googleapis.com/maps/api/js?key=AIzaSyBi9TrT6Y45x72lDYLcMQFms2tizReTWO0&libraries=places', true);
        wp_enqueue_script('movvin-search-widget-js', plugins_url('movvin-search-widget.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker','google-maps-api-js'),false,  true);
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-datepicker');
    }
    add_action( 'wp_enqueue_scripts', 'enqueue_movvin_search_widget_js' );
}

// register movvin_search_widget widget
function register_movvin_search_widget() {
    register_widget( 'movvin_search_widget' );
}
add_action( 'widgets_init', 'register_movvin_search_widget' );

function load_custom_wp_admin_style($hook) {
    wp_enqueue_script('google-maps-api-js','https://maps.googleapis.com/maps/api/js?key=AIzaSyBi9TrT6Y45x72lDYLcMQFms2tizReTWO0&libraries=places', false);
    wp_enqueue_script('movvin-search-widget-admin-js', plugins_url('movvin-search-widget-admin.js', __FILE__), array('google-maps-api-js'), false, false);
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
?>