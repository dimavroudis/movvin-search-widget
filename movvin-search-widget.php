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
                $starting_point = esc_attr($instance['starting_point']);
                $destination = esc_attr($instance['destination']);
            } else {
                $title = '';
                $starting_point = 'Starting Point (e.g. Thessaloniki)';
                $destination = 'Optional';
            } ?>

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'movvin_search_widget'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('starting_point'); ?>"><?php _e('Starting point field placeholder:', 'movvin_search_widget'); ?></label>
                <input  class="widefat" id="<?php echo $this->get_field_id('starting_point'); ?>" name="<?php echo $this->get_field_name('starting_point'); ?>" type="text" value="<?php echo $starting_point;?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('destination'); ?>"><?php _e('Destination field placeholder:', 'movvin_search_widget'); ?></label>
                <input  class="widefat" id="<?php echo $this->get_field_id('destination'); ?>" name="<?php echo $this->get_field_name('destination'); ?>" type="text" value="<?php echo $destination;?>" />
            </p>
        <?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['starting_point'] = strip_tags($new_instance['starting_point']);
        $instance['destination'] = strip_tags($new_instance['destination']);
        return $instance;
	}

	// widget display
	function widget($args, $instance) {
        extract( $args );
        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        $text = $instance['text'];
        $starting_point = $instance['starting_point'];
        $destination = $instance['destination'];
        echo $before_widget; ?>
        
        <form method="get" action="https://dev.movvin.com/s" enctype="application/x-www-form-urlencoded"> 
            <div class="movvin-search-bar-container"> 
                <input id="p_p_id" name="p_p_id" type="hidden" autocomplete="off" aria-disabled="false" aria-readonly="false" value="ridesearch_WAR_MOVVINLiferayportlet"/>
                <input id="p_p_lifecycle" name="p_p_lifecycle" type="hidden" autocomplete="off"  aria-disabled="false" aria-readonly="false" value="0"/>
                <div class="movvin-search-b2c-block address">
                   <label for="_ridesearchbar_WAR_MOVVINLiferayportlet_:search-bar-form:from-place-input">From:</label> 
                    <input id="_ridesearch_WAR_MOVVINLiferayportlet_fromText" name="_ridesearch_WAR_MOVVINLiferayportlet_fromText" type="text" autocomplete="off" placeholder="Starting point (e.g &quot;Thessaloniki&quot;)" class="movvin-autocomplete-input" role="textbox" aria-disabled="false" aria-readonly="false" value="Thessaloniki. Greece"/>
                    <input id="_ridesearch_WAR_MOVVINLiferayportlet_from" class="movvin-autocomplete-input-hidden" value="40.6400629-22.944419100000005" name="_ridesearch_WAR_MOVVINLiferayportlet_from" type="hidden" autocomplete="off"  role="textbox" aria-disabled="false" aria-readonly="false"/>
                </div> 
                <div class="search-b2c-block address">
                    <label for="_ridesearchbar_WAR_MOVVINLiferayportlet_:search-bar-form:to-place-input">To:</label>
                    <input id="_ridesearch_WAR_MOVVINLiferayportlet_toText" name="_ridesearch_WAR_MOVVINLiferayportlet_toText" type="text" autocomplete="off" placeholder="Optional" class="movvin-autocomplete-input" role="textbox" aria-disabled="false" aria-readonly="false"/>
                    <input id="_ridesearch_WAR_MOVVINLiferayportlet_to" class="movvin-autocomplete-input-hidden" name="_ridesearch_WAR_MOVVINLiferayportlet_to" type="hidden" autocomplete="off"  role="textbox" aria-disabled="false" aria-readonly="false"/>
                </div> 
                <div class="search-b2c-block date">
                    <label for="_ridesearch_WAR_MOVVINLiferayportlet_date">Date:</label>
                    <input id="_ridesearch_WAR_MOVVINLiferayportlet_date" name="_ridesearch_WAR_MOVVINLiferayportlet_date" type="datetime" aria-required="true" value="2017-09-24_21:23:58" autocomplete="off" role="textbox" aria-disabled="false" aria-readonly="false"/>
                </div>
                <div class="search-b2c-block passengers">
                    <label for="_ridesearch_WAR_MOVVINLiferayportlet_passengers">Passengers:</label> 
                    <select id="_ridesearch_WAR_MOVVINLiferayportlet_passengers" name="_ridesearch_WAR_MOVVINLiferayportlet_passengers" size="1"> 
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
                <input id="_ridesearch_WAR_MOVVINLiferayportlet_radius" name="_ridesearch_WAR_MOVVINLiferayportlet_radius" type="hidden" autocomplete="off"  role="textbox" aria-disabled="false" aria-readonly="false" value="18000"/>
                <button type="submit" role="button" aria-disabled="false">
                    <span>Search</span>
                </button> 
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
        wp_enqueue_script('google-maps-api-js','https://maps.googleapis.com/maps/api/js?key=AIzaSyBi9TrT6Y45x72lDYLcMQFms2tizReTWO0&libraries=places', array('jquery'), '', true);
        wp_enqueue_script('movvin-search-widget-js', plugins_url('movvin-search-widget.js', __FILE__), array('jquery'), '', true);
    }
    add_action( 'wp_enqueue_scripts', 'enqueue_movvin_search_widget_js' );
}

// register movvin_search_widget widget
function register_movvin_search_widget() {
    register_widget( 'movvin_search_widget' );
}
add_action( 'widgets_init', 'register_movvin_search_widget' );

?>