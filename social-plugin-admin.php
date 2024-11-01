<?php
// create custom plugin settings menu
add_action('admin_menu', 'socialplugin_create_menu');
add_filter('plugin_action_links', 'socialplugin_links', 10, 2 );


function register_socialplugin() {

add_option( 'socialplugin_buttons', array('like'=>1, 'tweet'=>2, 'plusone'=>3) );
add_option( 'socialplugin_display', array('post'=>1, 'home'=>1) );
add_option( 'socialplugin_display_where', 'bottom' );
add_option( 'socialplugin_styles', '.socialplugin li{margin-right:20px;}' );
add_option( 'socialplugin_cloak', 1 );
add_option( 'socialplugin_twitter_username', '' );

update_option( 'socialplugin_version', socialplugin_INIT );
}


function socialplugin_admin(){

$buttons = get_option('socialplugin_buttons');
$display = get_option('socialplugin_display');
?>
<style type="text/css">
#socialplugin{overflow:hidden;position:relative;min-width:500px;width:96%;min-height:500px;zoom:1;}
#socialplugin #sidebar{width:36.5%;margin-left:1%;float:right;border:1px solid #ddd;background-color:#f7f7f7;border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;}
#socialplugin #sidebar iframe{width:90%;margin:15px 5%;min-height:500px;}
#socialplugin #options{width:62%;float:left;}
#socialplugin table,#socialplugin tr,#socialplugin td,#socialplugin th{vertical-align:top;}

#top-wrap{margin-bottom:50px;}
#top-wrap th{font-family:'lucida grande', tahoma, verdana, arial, san-serfif;font-size:1.1em;text-indent:5px;color:#111;}
#top-wrap td{min-width:80px;padding:10px 7px 7px;}
#top-wrap input{width:5em;text-align:center;}
#socialplugin iframe,#socialplugin object{height:21px;border:0;overflow:hidden;}
#socialplugin .spsend{overflow:visible;}

#bottom-wrap th{text-align:left;min-width:200px;}
#bottom-wrap td{padding-bottom:40px;}
#bottom-wrap textarea{width:95%;}
#bottom-wrap input[type=radio],#bottom-wrap input[type=checkbox],#bottom-wrap input[type=text]{position:relative;bottom:2px;}

.info{font-size:11px;color:#555;}
.code{background-color:#dedede;}
.js{color:red;}
.jquery{color:blue;}
.html{color:green;}
.glitch{color:brown;}
</style>
<div id="socialplugin">
  <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
  <h2>Social Plugin Options</h2>
  
  <div id="sidebar">
    <iframe src="http://dev.linksku.com/wp/sidebar.php" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
  </div>
  
  <div id="options">
  <form method="post" action="options.php">
    <div id="top-wrap">
      <table class="widefat">
        <thead>
          <tr>
            <th>#</th>
            <th>Button</th>
            <th>Demo</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[addthis]" value="<?php if(intval($buttons['addthis'])>0) echo $buttons['addthis'] ?>" />
            </td>
            <td>AddThis <span class="js">*</span> <span class="html">*</span> <span class="glitch">*</span></td>
            <td>
              <div class="addthis_toolbox addthis_default_style">
                <a class="addthis_counter addthis_pill_style" addthis:url="http%3A%2F%2Flinksku.com"></a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[buzz]" value="<?php if(intval($buttons['buzz'])>0) echo $buttons['buzz'] ?>" />
            </td>
            <td>Buzz <span class="js">*</span></td>
            <td>
              <a title="Post to Google Buzz" class="google-buzz-button" href="http://www.google.com/buzz/post" data-button-style="small-count" data-url="http://linksku.com"></a>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[delicious]" value="<?php if(intval($buttons['delicious'])>0) echo $buttons['delicious'] ?>" />
            </td>
            <td>Delicious <span class="js">*</span> <span class="jquery">*</span></td>
            <td>
              <a class="delicious-button" href="http://delicious.com/save"><!-- {url:"http://linksku.com",title:"Linksku :: Share links online",button:"wide"} -->Delicious</a>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[digg]" value="<?php if(intval($buttons['digg'])>0) echo $buttons['digg'] ?>" />
            </td>
            <td>Digg <span class="js">*</span></td>
            <td>
              <span class="digg-button">
                <a class="DiggThisButton DiggCompact" href="http://digg.com/submit?url=http%3A%2F%2Flinksku.com"></a>
              </span>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[follow]" value="<?php if(intval($buttons['follow'])>0) echo $buttons['follow'] ?>" />
            </td>
            <td>Follow <span class="glitch">*</span></td>
            <td>
              <iframe class="spfollow" src="http://platform.twitter.com/widgets/follow_button.html?screen_name=LinksKu&amp;bg=light&amp;show_count=true" allowtransparency="true" frameborder="0" scrolling="no" class="twitter-follow-button"></iframe>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[like]" value="<?php if(intval($buttons['like'])>0) echo $buttons['like'] ?>" />
            </td>
            <td>Like</td>
            <td>
              <iframe class="splike" src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Flinksku.com&amp;layout=button_count&amp;show_faces=false&amp;width=78&amp;action=like&amp;colorscheme=light&amp;font=arial" scrolling="no" frameborder="0" allowtransparency="true"></iframe>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[linkedin]" value="<?php if(intval($buttons['linkedin'])>0) echo $buttons['linkedin'] ?>" />
            </td>
            <td>LinkedIn <span class="js">*</span> <span class="html">*</span></td>
            <td>
              <script type="text/javascript" src="http://platform.linkedin.com/in.js"></script><script type="in/share" data-url="http://linksku.com" data-counter="right"></script>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[plusone]" value="<?php if(intval($buttons['plusone'])>0) echo $buttons['plusone'] ?>" />
            </td>
            <td>Google +1 <span class="js">*</span> <span class="glitch">*</span></td>
            <td style="position:relative;" id="plusone">
              <g:plusone href="http://linksku.com" size="medium" count="true"></g:plusone>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[reddit]" value="<?php if(intval($buttons['reddit'])>0) echo $buttons['reddit'] ?>" />
            </td>
            <td>Reddit <span class="html">*</span></td>
            <td>
              <iframe src="http://www.reddit.com/static/button/button1.html?width=120&amp;url=http%3A%2F%2Flinksku.com" height="22" width="120" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[retweet]" value="<?php if(intval($buttons['retweet'])>0) echo $buttons['retweet'] ?>" />
            </td>
            <td>ReTweet</td>
            <td>
              <iframe class="spretweet" src="http://api.tweetmeme.com/button.js?url=http%3A%2F%2Flinksku.com&amp;style=compact&amp;o=<?php echo urlencode(socialplugin_url()); ?>&amp;b=1" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
            </td>
          </tr>
          <tr style="overflow:visible;">
            <td>
              <input type="text" name="socialplugin_buttons[send]" value="<?php if(intval($buttons['send'])>0) echo $buttons['send'] ?>" />
            </td>
            <td>Send <span class="js">*</span> <span class="html">*</span> <span class="glitch">*</span></td>
            <td style="overflow:visible;">
              <fb:send href="http://linksku.com" font="arial" class="spsend"></fb:send>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[share]" value="<?php if(intval($buttons['share'])>0) echo $buttons['share'] ?>" />
            </td>
            <td>Share <span class="js">*</span> <span class="html">*</span></td>
            <td>
              <a share_url='http%3A%2F%2Flinksku.com' href='http://www.facebook.com/sharer.php' name='fb_share' type='button_count'>Share</a>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[sharethis]" value="<?php if(intval($buttons['sharethis'])>0) echo $buttons['sharethis'] ?>" />
            </td>
            <td>Sharethis <span class="js">*</span> <span class="html">*</span> <span class="glitch">*</span></td>
            <td>
              <span class="st_sharethis_hcount" displayText="Share" st_url="http%3A%2F%2Flinksku.com"></span>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[stumble]" value="<?php if(intval($buttons['stumble'])>0) echo $buttons['stumble'] ?>" />
            </td>
            <td>Stumble</td>
            <td>
              <iframe class="spstumble" src="http://www.stumbleupon.com/badge/embed/1/?url=http%3A%2F%2Flinksku.com" scrolling="no" frameborder="0" allowtransparency="true"></iframe>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="socialplugin_buttons[tweet]" value="<?php if(intval($buttons['tweet'])>0) echo $buttons['tweet'] ?>" />
            </td>
            <td>Tweet</td>
            <td>
              <iframe class="sptweet" src="http://platform0.twitter.com/widgets/tweet_button.html?_=1298252536917&amp;count=horizontal&amp;lang=en&amp;text=Linksku%20%3A%3A%20Share%20links%20online&amp;via=Linksku&amp;url=http%3A%2F%2Flinksku.com" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" style="padding-left:20px;">
              <span class="info">
                Leave the buttons that you don&#39;t want blank.
                <br />
                <span class="js">*</span> requires Javascript
                <br />
                <span class="jquery">*</span> requires JQuery
                <br />
                <span class="html">*</span> breaks HTML validation
                <br />
                <span class="glitch">*</span> possibly glitchy
              </span>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
    
    <div id="bottom-wrap">
      <table>
        <tr>
          <th>Pages to display on</th>
          <td>
            <input type="checkbox" value="1" name="socialplugin_display[post]"<?php if($display['post']) echo ' checked="checked"'; ?> /> Post
            <br />
            <input type="checkbox" value="1" name="socialplugin_display[page]"<?php if($display['page']) echo ' checked="checked"'; ?> /> Page
            <br />
            <input type="checkbox" value="1" name="socialplugin_display[home]"<?php if($display['home']) echo ' checked="checked"'; ?> /> Homepage
            <br />
            <input type="checkbox" value="1" name="socialplugin_display[category]"<?php if($display['category']) echo ' checked="checked"'; ?> /> Category
            <br />
            <input type="checkbox" value="1" name="socialplugin_display[search]"<?php if($display['_search']) echo ' checked="checked"'; ?> /> Search
            <br />
            <input type="checkbox" value="1" name="socialplugin_display[archive]"<?php if($display['archive']) echo ' checked="checked"'; ?> /> Archive
            <br />
            <input type="checkbox" value="1" name="socialplugin_display[all]"<?php if($display['all']) echo ' checked="checked"'; ?> /> All Pages
          </td>
        </tr>
        <tr>
          <th>Where to display</th>
          <td>
            <input type="radio" value="top" name="socialplugin_display_where"<?php if(get_option('socialplugin_display_where')=='top') echo ' checked="checked"'; ?> /> Top of post
            <br />
            <input type="radio" value="bottom" name="socialplugin_display_where"<?php if(get_option('socialplugin_display_where')=='bottom') echo ' checked="checked"'; ?> /> Bottom of post
          </td>
        </tr>
      </table>
      <p><a href="" onclick="jQuery('#socialplugin_advanced').slideToggle('slow');return false;">Show/hide advanced options &raquo;</a><br /><br /></p>
      <div id="socialplugin_advanced" style="display:none;">
        <table>
          <tbody>
            <tr>
              <th>Custom styles</th>
              <td>
                <textarea name="socialplugin_styles" cols="50" rows="8"><?php echo (get_option('socialplugin_styles') ? get_option('socialplugin_styles') : ''); ?></textarea><br />
                <span class="info">Use <code>.socialplugin</code> for the container of the buttons, <code>.socialplugin li</code> for each button, and <code title="e.g. .socialplugin li.splike or .social li.sptweet">.socialplugin li.sp[buttonname]</code> for specific buttons.</span>
              </td>
            </tr>
            <tr>
              <th>Twitter username</th>
              <td>@<input type="text" value="<?php echo (get_option('socialplugin_twitter_username') ? get_option('socialplugin_twitter_username') : ''); ?>" name="socialplugin_twitter_username" /></td>
            </tr>
            <tr>
              <th>Manually insert buttons in template</th>
              <td>
                <input type="checkbox" value="1" name="socialplugin_template" <?php if(get_option('socialplugin_template')) echo ' checked="checked"'; ?> /><br />
                <span class="info">If you would like to manually add the buttons into your template, add <code>&lt;?php socialplugin_buttons(); ?&gt;</code> (inside the Loop) or <code>&lt;?php socialplugin_buttons($post_id); ?&gt;</code> (outside the Loop) to your theme</span>
              </td>
            </tr>
            <tr>
              <th>Cloak buttons</th>
              <td><input type="checkbox" value="1" name="socialplugin_cloak" <?php if(get_option('socialplugin_cloak')) echo ' checked="checked"'; ?> /> Hide buttons from bots and crawlers</td>
            </tr>
            <tr>
              <th>Delay loading buttons</th>
              <td><input type="checkbox" value="1" name="socialplugin_ajax" <?php if(get_option('socialplugin_ajax')) echo ' checked="checked"'; ?> /> Show buttons after everything else is loaded</td>
            </tr>
          </tbody>
        </table>
      </div>
      <table>
        <tbody>
          <tr>
            <th>Like this plugin?</th>
            <td><input type="checkbox" value="1" name="socialplugin_thanks" <?php if(get_option('socialplugin_thanks')) echo ' checked="checked"'; ?> /> Link to <a href="http://wordpress.org/extend/plugins/social-plugin/" title="WordPress plugin page">Social Plugin</a> in your footer!</td>
          </tr>
          <tr>
            <th></th>
            <td>
              <input type="hidden" name="action" value="update" />
              <input type="hidden" name="page_options" value="socialplugin_buttons,socialplugin_template,socialplugin_display,socialplugin_display_where,socialplugin_styles,socialplugin_cloak,socialplugin_ajax,socialplugin_twitter_username,socialplugin_thanks" />
              <?php wp_nonce_field('update-options'); ?>
              <input type="submit" class="button-primary" value="Save Changes" style="position:absolute;top:2px;right:38%;" />
              <input type="submit" class="button-primary" value="Save Changes" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </form>
  </div>
  <script type="text/javascript">
  (function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://s7.addthis.com/js/250/addthis_widget.js";s1.parentNode.insertBefore(s,s1)})();
  (function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://www.google.com/buzz/api/button.js";s1.parentNode.insertBefore(s,s1)})();
  (function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://delicious-button.googlecode.com/files/jquery.delicious-button-1.0.min.js";s1.parentNode.insertBefore(s,s1)})();
  (function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://widgets.digg.com/buttons.js";s1.parentNode.insertBefore(s,s1)})();
  (function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://static.ak.fbcdn.net/connect.php/js/FB.Share";s1.parentNode.insertBefore(s,s1)})();
  (function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://apis.google.com/js/plusone.js";s1.parentNode.insertBefore(s,s1)})();
  (function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://w.sharethis.com/button/buttons.js";s1.parentNode.insertBefore(s,s1)})();
  </script>
</div>
<?php
}
?>