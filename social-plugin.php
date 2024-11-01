<?php
/**
* Plugin Name: Social Plugin
* Description: Adds sharing buttons to your WordPress blog. Configure which buttons to display on the <a href="admin.php?page=socialplugin">settings</a> page.
* Version: 1.0
* Author: WordPress Plugin
* Author URI: http://wordpress.org/
* License: GPL
*/

/*********************************************************************
 * File: social-plugin.php
 * Author: WordPress Plugin
 * Date Created: September 2011
 * Project Name: Social Plugin
 * Description:
 *        Adds sharing buttons to WordPress posts
 * Copyright © 2011 - WordPress Plugin
 *********************************************************************/

if (!defined(socialplugin_INIT))
  define('socialplugin_INIT', '1.1.2');
else
  return;

require('inc/social-plugin-functions.php');
if(is_admin()){
	require('social-plugin-admin.php');
} 

// Styles in the header
function socialplugin_header(){
if(!socialplugin_check())
  return;
global $is_IE;
$buttons = get_option('socialplugin_buttons');

$display=($is_IE ? 'inline' : 'inline-block');

echo '<style type="text/css">
@import url('.get_bloginfo('wpurl').'/wp-content/plugins/social-plugin/css/style.css);
.socialplugin{'.($buttons['send'] ? '' : 'overflow:hidden;').(get_option('socialplugin_ajax') ? 'display:none;' : '').'}
.socialplugin li{display:'.$display.';
.socialplugin .fb_share_count_nub_right{background:transparent url('.get_bloginfo('wpurl').'/wp-content/plugins/social-plugin/css/share.png) no-repeat right 5px !important;}
'.get_option('socialplugin_styles').'
</style>';

}

// Scripts in the footer
function socialplugin_footer(){
if(socialplugin_bot() && !is_user_logged_in()){
  socialplugin_thanks();return;
}
if(!socialplugin_check()){
  if(get_option('socialplugin_thanks'))
    socialplugin_thanks(true,true);
  return;
}
$buttons = get_option('socialplugin_buttons');

if(get_option('socialplugin_thanks'))
  socialplugin_thanks(true,true);

if(!get_option('socialplugin_cloak') || !socialplugin_bot()){
echo '<script type="text/javascript">';
if($buttons['addthis'])
  echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://s7.addthis.com/js/250/addthis_widget.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['buzz'])
  echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://www.google.com/buzz/api/button.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['delicious'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://delicious-button.googlecode.com/files/jquery.delicious-button-1.0.min.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['digg'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://widgets.digg.com/buttons.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['linkedin'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://platform.linkedin.com/in.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['plusone'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://apis.google.com/js/plusone.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['send'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://connect.facebook.net/en_US/all.js#xfbml=1";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['share'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://static.ak.fbcdn.net/connect.php/js/FB.Share";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['sharethis'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://w.sharethis.com/button/buttons.js";s1.parentNode.insertBefore(s,s1)})();';
if(get_option('socialplugin_ajax'))
  echo 'jQuery(window).bind("load",function(){jQuery(\'.socialplugin\').fadeIn(\'slow\');})';
echo '</script>';
  }
}

// Displays the buttons
function socialplugin_buttons($content=''){
if(socialplugin_bot() && !is_user_logged_in()){
if(get_option('socialplugin_template')){
socialplugin_thanks();return;
}else{
return socialplugin_thanks(false).$content;
}
}

if(!socialplugin_check())return $content;
  
global $is_IE,$is_chrome,$is_windows;
$buttons = get_option('socialplugin_buttons');
$spbuttons = array();

$output='<!-- Social Plugin plugin by Linksku -->
<ul class="socialplugin">';

if(intval($content)>0 && get_option('socialplugin_template'))
  $purl = get_permalink($content);
else
  $purl = get_permalink();
$url = rawurlencode($purl);

// gets title
if(intval($content)>0 && get_option('socialplugin_template'))
  $title = get_the_title($content);
else
  $title = get_the_title();

// Addthis
if($buttons['addthis']){
  $spbuttons['addthis']='<li class="spaddthis"><div class="addthis_toolbox addthis_default_style"><a class="addthis_counter addthis_pill_style" addthis:url="'.$purl.'"></a></div></li>';
}

// Buzz
if($buttons['buzz']){
  $spbuttons['buzz']='<li class="spbuzz"><a title="Post to Google Buzz" class="google-buzz-button" href="http://www.google.com/buzz/post" data-button-style="small-count" data-url="'.$purl.'"></a></li>';
}

// Delicious
if($buttons['delicious']){
  $spbuttons['delicious']='<li class="spdelicious"><a class="delicious-button" href="http://delicious.com/save"><!-- {url:"'.$purl.'",title:"'.$title.'",button:"wide"} -->Delicious</a></li>';
}

// Digg
if($buttons['digg']){
  $spbuttons['digg']='<li class="spdigg"><span class="digg-button"><a class="DiggThisButton DiggCompact" href="http://digg.com/submit?url='.$url.'&amp;related=no"></a></span></li>';
}

// Twitter Follow
if($buttons['follow'] && strlen(get_option('socialplugin_twitter_username'))>0){
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['follow']='<li class="spfollow"><object data="http://platform.twitter.com/widgets/follow_button.html?screen_name='.trim(get_option('socialplugin_twitter_username')).'&amp;bg=light&amp;show_count=true" type="text/html"></object></li>';
  else
    $spbuttons['follow']='<li class="spfollow"><iframe src="http://platform.twitter.com/widgets/follow_button.html?screen_name=LinksKu&amp;bg=light&amp;show_count=true" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

// Like
if($buttons['like']){
  $fburl= $url.'&amp;layout=button_count&amp;show_faces=false&amp;width=80&amp;action=like&amp;colorscheme=light&amp;font=arial';
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['like']='<li class="splike"><object data="http://www.facebook.com/plugins/like.php?href='.$fburl.'" type="text/html"></object></li>';
  else
    $spbuttons['like']='<li class="splike"><iframe src="http://www.facebook.com/plugins/like.php?href='.$fburl.'" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

// Link
if($buttons['link']){
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['link']='<li class="splink"><object data="http://linksku.com/button.php?url='.$url.'"></object></li>';
  else
    $spbuttons['link']='<li class="splink"><iframe src="http://linksku.com/button.php?url='.$url.'" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

// LinkedIn
if($buttons['linkedin']){
  $spbuttons['linkedin']='<li class="splinkedin"><script type="in/share" data-url="'.$purl.'" data-counter="right"></script></li>';
}

// +1
if($buttons['plusone']){
  $spbuttons['plusone']='<li class="spplusone"><g:plusone href="'.$purl.'" size="medium" count="true"></g:plusone></li>';
}

// Reddit
if($buttons['reddit']){
  $spbuttons['reddit']='<li class="spreddit"><iframe src="http://www.reddit.com/static/button/button1.html?width=120&amp;url='.$url.'" height="22" width="120" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

// ReTweet
if($buttons['retweet']){
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['retweet']='<li class="spretweet"><object data="http://api.tweetmeme.com/button.js?url='.$url.'&amp;style=compact&amp;o='.rawurlencode(socialplugin_url()).'&amp;b=1"></object></li>';
  else
    $spbuttons['retweet']='<li class="spretweet"><iframe src="http://api.tweetmeme.com/button.js?url='.$url.'&amp;style=compact&amp;o='.rawurlencode(socialplugin_url()).'&amp;b=1" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}
 
// Send
if($buttons['send']){
  $spbuttons['send']='<li class="spsend"><fb:send href="'.$purl.'" font="arial" class="splike"></fb:send></li>';
}

// Share
if($buttons['share']){
  $spbuttons['share']='<li class="spshare"><a share_url="'.$purl.'" href="http://www.facebook.com/sharer.php" name="fb_share" type="button_count">Share</a></li>';
}

// ShareThis
if($buttons['sharethis']){
$spbuttons['sharethis']='<li class="spsharethis"><span class="st_sharethis_hcount" displayText="Share" st_url="'.$purl.'"></span></li>';
}

// StumbleUpon
if($buttons['stumble']){
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['stumble']='<li class="spstumble"><object data="http://www.stumbleupon.com/badge/embed/1/?url='.$url.'"></object></li>';
  else
    $spbuttons['stumble']='<li class="spstumble"><iframe src="http://www.stumbleupon.com/badge/embed/1/?url='.$url.'" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

// Twitter
if($buttons['tweet']){
  $twitterTitle = rawurlencode($title.(strlen(trim(get_option('socialplugin_twitter_username')))>0 ? ' via @'.trim(get_option('socialplugin_twitter_username')) : ''));
  $twitterVia = rawurlencode( strlen(trim(get_option('socialplugin_twitter_username')))>0 ? '&amp;via='.trim(get_option('socialplugin_twitter_username')) : '' );
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['tweet']='<li class="sptweet"><object data="http://platform0.twitter.com/widgets/tweet_button.html?_=1298252536917&amp;count=horizontal&amp;lang=en&amp;text='.$twitterTitle.$twitterVia.'&amp;url='.$url.'"></object></li>';
  else
    $spbuttons['tweet']='<li class="sptweet"><iframe src="http://platform0.twitter.com/widgets/tweet_button.html?_=1298252536917&amp;count=horizontal&amp;lang=en&amp;text='.$twitterTitle.$twitterVia.'&amp;url='.$url.'" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

asort($buttons);
foreach($buttons as $b=>$v){
  if($v==false)
    continue;

  if(isset($spbuttons[$b]))
    $output.=$spbuttons[$b];
}

$output.='</ul>
<!-- / Social Plugin plugin by Linksku -->';

if(get_option('socialplugin_template')){
  echo $output;
  return;
}

if(get_option('socialplugin_display_where')=='top')
  return $output.$content;
return $content.$output;
}

add_action('wp_footer','socialplugin_footer',1);
if(!get_option('socialplugin_cloak') || !socialplugin_bot())
  add_action('wp_head','socialplugin_header');
if(!get_option('socialplugin_template'))
  add_filter('the_content','socialplugin_buttons');

// Delicious requires JQuery
$buttons = get_option('socialplugin_buttons');
if($buttons['delicious'] || get_option('socialplugin_ajax'))
  wp_enqueue_script('jquery');       

?>