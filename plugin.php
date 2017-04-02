<?php
/*
Plugin Name: Fred's Twitter Widget
Plugin URI: https://github.com/fredbradley/WP-Twitter-Widget
Description: Something inspiring will arrive here soon!
Author: Fred Bradley <fred@swipe.digital>
Version: 1.4.0
Author URI: http://www.fredbradley.uk
GitHub Plugin URI: https://github.com/fredbradley/WP-Twitter-Widget
Github Branch:	master
*/

class SwipeEmapTweet {
	function __construct() {
		add_shortcode('fb_twitter_widget', array($this,'the_shortcode'));
		add_action('wp_enqueue_scripts', array($this, 'add_script'));
		add_action( 'widgets_init', array($this, 'register_widget' ));
		add_action('admin_notices', array($this, 'fredtest'));
	}
	// register Foo_Widget widget
	function register_widget() {
		require_once('widget.php');
	    register_widget( 'FB_Twitter_Widget' );
	}

	function add_script() {
		wp_enqueue_script('emapTweet-js', plugins_url('twitter-fetcher.js', __FILE__), array(), time(), false);
		wp_enqueue_style('emapTweet-style', plugins_url('stylesheet.css', __FILE__), array(), time());
	}
	function the_shortcode( $atts, $content = null ) {
		$config = shortcode_atts( array(
			'div_id' => 'emaptweet',
			'timeline_id' => '615814546540900352',
			'js_function' => "showTweet",
			'num_tweets' => 1,
			'show_user' => false,
			'show_links' => true,
			"hide_rts" => true,
			"hide_interaction" => false,
			"hide_timestamp" => false,
			"show_images" => false,
			
		        // ...etc
		), $atts );
		return $this->show($config);
	}
	
	
	function show($config) {
		$config = (object)$config;
		$javascript_config_name = "config_".$config->js_function;
		$output = " <div id=\"".$config->div_id."\"></div>";
		$output .= "
<script type='text/javascript'>
		var ".$javascript_config_name." = {
			id:'".$config->timeline_id."',
			domId:'".$config->js_function."',
			maxTweets:".$config->num_tweets.",
			showUser:false,
			lang:'en',
			showImages:false,
			enableLinks: true,
			customCallback: ".$config->js_function."
		};";
		
		$output .= "\n\n";
		if ($config->show_links === false) {
			$output .= $javascript_config_name.".enableLinks=false;";
		}
		if ($config->show_user) {
			$output .= "\n\n";
			$output .= $javascript_config_name.".showUser=true;";
		}
		if ($config->show_time) {
			$output .= "\n\n";
			$output .= $javascript_config_name.".showTime=true;";
		}
		if ($config->hide_rts) {
			$output .= "\n\n";
			$output .= $javascript_config_name.".showRetweet=false;";
		}
		if ($config->hide_interaction) {
			$output .= "\n\n";
			$output .= $javascript_config_name.".showInteraction=false;";
		}
		if ($config->hide_timestamp) {
			$output .= "\n\n";
			$output .= $javascript_config_name.".showTime=false;";
		}
		if ($config->show_images) {
			$output .= "\n\n";
			$output .= $javascript_config_name.".showImages=true;";
		}
		$output .= "
	
		
		function ".$config->js_function."(tweets){
			var x = tweets.length;
			var n = 0;
			var element = document.getElementById('".$config->div_id."');
			var html = '<!-- START --><div class=\"fb_twitter_widget\">';
			while(n < x) {
				html += '<div class=\"a-tweet\">' + tweets[n] + '</div>';
				n++;
			}
			html += '</div><!-- END -->';
			element.innerHTML = html;
		}

		
		twitterFetcher.fetch(".$javascript_config_name.");
		
		window.onLoad = function() {
			var linkList = document.querySelectorAll('.tweet a');

			for(var i in linkList){
				linkList[i].setAttribute('target', '_blank');
			}
		};
 </script>
		
		";
		return $output;
		$check_code = "yes";
	}
	
}
$swipeemaptweet = new SwipeEmapTweet();
