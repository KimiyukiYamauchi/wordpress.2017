<?php
/**
 * アイキャッチ画像を使用可能にする
 */
add_theme_support('post-thumbnails');

 /**
  * カスタムメニュー機能を使用可能にする
  */
add_theme_support('menus');

/**
 * コメント投稿フォームのカスタマイズ
 */
add_filter('comment_form_default_fields'
, 'my_comment_form_default_fields');
function my_comment_form_default_fields($args) {
  $args['author'] = ''; // 「名前」を削除
  $args['email'] = ''; // 「メールアドレス」を削除
  $args['url'] = ''; // 「ウェブサイト」を削除
  return $args;
}

/**
 * head内にRSSのlink要素を出力する
 */
add_theme_support('automatic-feed-links');

/**
 * RSSに配信する文字数を設定する
 */
add_filter('excerpt_mblength', 'my_excerpt_mblength');
function my_excerpt_mblength($length) {
  return 100; // 抜粋に出力する文字数
}

/**
 * RSSに「続きを読む」のリンクを追加する
 */
add_filter('excerpt_more', 'my_excerpt_more');
function my_excerpt_more($more) {
  return '...<a href="' . get_permalink(get_the_ID()) . '">続きを読む→</a>';
}

// RSS 2.0を停止
// remove_action( 'do_feed_rss2', 'do_feed_rss2', 10, 1);

/**
 * トップページで表示する投稿数を3件にする
 */
add_action( 'pre_get_posts', 'my_pre_get_posts' );
function my_pre_get_posts($query) {
  // 管理画面、メインクエリ以外には設定しない
  if( is_admin() || !$query->is_main_query()){
    return;
  }

  // トップページの場合
  if($query->is_home()){
    $query->set('posts_per_page', 3);
    return;
  }
}

/**
 * 管理画面に独自のCSSを読み込ませる
 */
add_action('admin_print_styles', 'print_admin_stylesheet');

/**
 * ログイン画面に独自のCSSを読み込ませる
 */
add_action('login_head', 'print_admin_stylesheet');

/**
 * admin.cssを読み込む部分を共通化
 */
function print_admin_stylesheet() {
  echo '<link href="' . get_template_directory_uri() . '/css/admin.css" type="text/css" rel="stylesheet" media="all" />' . PHP_EOL;
}

/**
 * ビジュアルモードをデフォルトに設定
 */
add_filter('wp_default_editor', 'my_wp_default_editor');
function my_wp_default_editor(){
  return 'tinymce';
}

/**
 * 定型句を表示するショートコード
 */
function shortcode_test() {
  return "「ショートコードのテストです」";
}
add_shortcode('test', 'shortcode_test');
function shortcode_twitter() {
  return 'こんにちは！山内(<a href="https://twiter.com/yamauchi" target="_blank">@yamauchi</a>)です。';
}
add_shortcode('twitter', 'shortcode_twitter');

/**
 * 属性を指定したショートコード
 */
function shortcode_apple($atts) {
  $atts = shortcode_atts(array(
    'num' => 5,   // $numの初期値を設定
  ), $atts);
  extract($atts); // 連想配列から変数を作成
  return "リンゴが" . $num . "個ありました。";
}
add_shortcode('apple', 'shortcode_apple');

/**
 * 囲み型のショートコード
 */
function shortcode_price($atts, $content=null) {
  return '<div class="wrap"><em>価格</em>: ' . $content . '</div>';
}
add_shortcode('price', 'shortcode_price');

/**
 * テーマディレクトリを返すショートコード
 */
function shortcode_url() {
  echo get_template_directory_uri();
}
add_shortcode('dir_url', 'shortcode_url');

/**
 * サムネイル画像を表示する処理
 */
function display_thumbnail() {
  if ( has_post_thumbnail() ){
    echo '<a href="' . get_permalink() . '">' .
      get_the_post_thumbnail(get_the_ID(), 'thumbnail') . '</a>';
  }else{
    echo '<a href="' . get_permalink() . 
      '"><img src="' .  get_template_directory_uri() .
      '/images/common/noimage_180x180.png" height="180" width="180" alt=""></a>';
  }
}

/**
 * 部屋の画像を表示する処理
 */
function display_image($field_name, $size = 'medium') {
  $image = get_field($field_name);
  if(!empty($image)) {
    $url = $image['sizes'][$size]; // 中サイズ画像のURL
    $width = $image['sizes'][$size . '-width']; // 中サイズ画像の横幅
    $height = $image['sizes'][$size . '-height']; // 中サイズ画像の縦幅
    echo '<img src="' . $url .  '" height="' . $height . '" width="' .  $width . '" />';

  }
}