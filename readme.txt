=== WP Twitter Widget ===
Contributors: fredbradley
Tags: twitter, timeline, widget, shortcode, plugin
Requires at least: 3.0.0
Tested up to: 4.2.4
Stable tag: 4.2.4

A widget and short-code for Wordpress installations that will fetch tweets from the [Twitter Widget Timeline](https://dev.twitter.com/web/embedded-timelines) and display them using Javascript on your page.

== Description ==
Isn’t the standard Twitter Timeline widget a bore? Wouldn’t it be nice to have something that is styled similar to your own website. 

== Installation ==
Install as you normally would for any other Wordpress plugin. 

Ensure the plugin is activated. From this moment the plugin is installed and will be shown on your site. 

== Usage ==
Upon installing and activating, nothing will happen just yet.

There are two ways of using this plugin. Both ways can be used multiple times in one Wordpress installation.

=== 1. As A Short-code ===

Use the short-code to place your Twitter widget anywhere on your site.

`[fb_twitter_widget]` will set up your timeline with default parameters.

==== Parameters ====

| Param Name | Required? | Default Value | Description |
| --- | --- | --- | --- | --- |
| timeline_id | Yes | `null` | Find out how to find your Twitter Timeline ID |
| num_tweets | No | `1` | How many latest Tweets do you want to pull in from your timeline? |
| div_id | No. (Unless multiple occurrences on the same page) | `emaptweet` | The ID of the div where the Javascript will place the twitter timeline |
| js_function | No. (Unless multiple occurrences on the same page) | `showTweet` | We have to name the function that does the hard work. If you are pulling in more than one timeline you will have more than one function, so therefore they need difference names! |

==== Example ====

`[fb_twitter_widget num_tweets="3" timeline_id="615814546540900352" div_id="my_twitter_div" js_function="my_get_tweets"]`

=== 2. As A Widget ===

We've also created a Widget so that you can easily place your Twitter Timeline in your sidebars and footers.

This has the same parameters but in form format. See screenshot:

![Widget Screenshot](https://raw.githubusercontent.com/fredbradley/WP-Twitter-Widget/master/widget_screenshot.png)

== Frequently Asked Questions == 
= Can I email you? =
I’d rather you didn’t, but you will find my email address on the plugin.php file!

== Changelog == 
= 1.3.2 = 
 * Added readme.txt
 
= 1.3.1 = 
 * Completed Readme.md
 * Added functionality as a Widget
 
= 1.0 =
 * Initial Upload
