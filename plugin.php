<?php
/*
Plugin Name: Fred's Twitter Widget
Plugin URI: https://github.com/fredbradley/WP-Twitter-Widget
Description: Something inspiring will arrive here soon!
Author: Fred Bradley <fred@swipe.digital>
Version: 1.1.1
Author URI: http://www.fredbradley.uk
GitHub Plugin URI: https://github.com/fredbradley/WP-Twitter-Widget
Github Branch:	master
*/

class SwipeEmapTweet {
	function __construct() {
		add_shortcode('emaptweet', array($this,'shortcode_swipe_copyright'));
		add_action('wp_enqueue_scripts', array($this, 'add_script'));
	}
	
	function add_script() {
		wp_enqueue_script('emapTweet-js', plugins_url('twitter-fetcher.js', __FILE__), array(), time(), false);
		wp_enqueue_style('emapTweet-style', plugins_url('stylesheet.css', __FILE__), array(), time());
	}
	function shortcode_swipe_copyright( $atts, $content = null ) {
		$a = shortcode_atts( array(
			'div_id' => 'emaptweet',
			'timeline_id' => '615814546540900352',
			'js_function' => "showTweet",
			'num_tweets' => 1
		        // ...etc
				), $atts );
		$div = $a['div_id'];
		$timeline_id = $a['timeline_id'];
		$function_name = $a['js_function'];
		$num_tweets = $a['num_tweets'];

		return $this->show($function_name, $div, $timeline_id, $num_tweets);
	}
	
	function show($function, $div_id, $timeline_id, $num_tweets) {
		return "<script type='text/javascript'>
		twitterFetcher.fetch('".$timeline_id."', '".$div_id."', ".$num_tweets.", true, false, false, '', true, ".$function.");

function ".$function."(tweets){
    var x = tweets.length;
    var n = 0;
    var element = document.getElementById('".$div_id."');
    var html = '<p>';
    while(n < x) {
      html += '' + tweets[n] + '';
      n++;
    }
    html += '</p>';
    element.innerHTML = html;
}
window.onload = function() {
var linkList = document.querySelectorAll('.tweet a');

for(var i in linkList){
 linkList[i].setAttribute('target', '_blank');
 }
 };
</script><div id=\"".$div_id."\"></div>";

	}
}
$swipeemaptweet = new SwipeEmapTweet();
