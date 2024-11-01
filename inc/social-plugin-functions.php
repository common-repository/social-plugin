<?php
if (!function_exists('add_action')) {
  die('<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Flinksku.com%2F&amp;layout=button_count&amp;show_faces=false&amp;width=78&amp;action=like&amp;colorscheme=light&amp;font=arial" scrolling="no" frameborder="0" allowtransparency="true"></iframe>');
}

function socialplugin_url() {
  $pageURL = 'http';
  if ($_SERVER["HTTPS"] == "on") {
    $pageURL .= "s";
  }
  $pageURL .= "://";
  if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  }
  else {
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  }
  return $pageURL;
}

function socialplugin_check() {
  $crawlers = array('w3', 'validator');
  foreach($crawlers as $c) {
    if (stristr($_SERVER['HTTP_USER_AGENT'], $c)) return false;
  }
  $display = get_option('socialplugin_display');
  if (get_option('socialplugin_template') || is_admin() || $display['all'] ||
      (($display['post'] && is_single()) ||
      ($display['page'] && is_page()) ||
      ($display['home'] && is_home()) ||
      ($display['category'] && is_category()) ||
      ($display['search'] && is_search()) ||
      ($display['archive'] && is_archive())))
    return true;
  else return false;
}

function socialplugin_create_menu() {
  //create new top-level menu
  add_submenu_page('options-general.php', 'Social Plugin Settings', 'Social Plugin', 'administrator', 'socialplugin', 'socialplugin_admin');
  if (((float) substr(get_bloginfo('version'), 0, 3)) >= 2.7) {
    if (is_admin()) {
      //call register settings function
      add_action('admin_init', 'register_socialplugin');
    }
  }
}

function socialplugin_thanks($echo=true,$persistant=false){
  $texts=array('Share links online','Read the top news online','Read the latest news online',
  'Discover links to the latest news','The most Liked news on Facebook','Find the news with the most Likes on Facebook',
  'The top news on the web','Links to the latest, most popular news on the web!','Find links to the latest, most popular news on the web!',
  'Links to the best news on the Internet','Linksku','Linksku.com','www.linksku.com');
  $title=$texts[array_rand($texts)];
  $text=$texts[array_rand($texts)];
  $link=($persistant ? 'Social buttons by <a href="http://linksku.com">Linksku</a>' : "<a href='http://linksku.com/' title='$title'>$text</a>");
  if($echo)
    echo $link;
  return $link;
}

function socialplugin_links($links, $file) {
  if (preg_match('/^wp\-buttons\//', $file)) {
    $settings_link = '<a href="admin.php?page=socialplugin">Settings</a>';
    array_unshift($links, $settings_link);
  }
  return $links;
}

function socialplugin_button($content = '') {
  return socialplugin_buttons($content);
}

function socialplugin_bot() {
  $crawlers = array('alexa', 'altavista', 'baidu', 'google', 'lycos', 'msn', 'yahoo');
  foreach($crawlers as $c) {
    if (stristr($_SERVER['HTTP_USER_AGENT'], $c)) return true;
  }
  return false;
}

?>