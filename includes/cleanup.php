<?php
define('WP_POST_REVISIONS', 1);

function clear_nav_menu_item_id($id, $item, $args)
{
	return "";
}
add_filter('nav_menu_item_id', 'clear_nav_menu_item_id', 10, 3);

function clear_nav_menu_item_class($classes, $item, $args)
{
	return array();
}
add_filter('nav_menu_css_class', 'clear_nav_menu_item_class', 10, 3);
function dequeue_jquery_migrate(&$scripts)
{
	if (!is_admin()) {
		$scripts->remove('jquery');
		$scripts->add('jquery', false, array('jquery-core'), '3.6.0');
	}
}
add_filter('wp_default_scripts', 'dequeue_jquery_migrate');

function my_deregister_scripts()
{
	wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'my_deregister_scripts');

remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );

add_filter( 'feed_links_show_comments_feed', '__return_false' );
function removeHeadLinks()
{
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
	remove_action('wp_head', 'wp_generator');
}
add_action('init', 'removeHeadLinks');

add_filter('xmlrpc_enabled', '__return_false');

function disable_wp_emojicons()
{
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}
add_action('init', 'disable_wp_emojicons');

function disable_emojicons_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}
add_filter('emoji_svg_url', '__return_false');

function remove_edit_post_link($link)
{
	return '';
}
add_filter('edit_post_link', 'remove_edit_post_link');

class WP_HTML_Compression
{
	protected $compress_css = true;
	protected $compress_js = true;
	protected $info_comment = true;
	protected $remove_comments = true;

	protected $html;
	public function __construct($html)
	{
		if (!empty($html)) {
			$this->parseHTML($html);
		}
	}
	public function __toString()
	{
		return $this->html;
	}
	protected function bottomComment($raw, $compressed)
	{
		$raw = strlen($raw);
		$compressed = strlen($compressed);
		$savings = ($raw - $compressed) / $raw * 100;
		$savings = round($savings, 2);
		return '<!-- HTML Minify | Gross page reduction of ' . $savings . '% | From ' . $raw . ' Bytes, To ' . $compressed . ' Bytes -->';
	}
	protected function minifyHTML($html)
	{
		$pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
		preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
		$overriding = false;
		$raw_tag = false;
		$html = '';
		foreach ($matches as $token) {
			$tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
			$content = $token[0];
			if (is_null($tag)) {
				if (!empty($token['script'])) {
					$strip = $this->compress_js;
				} else if (!empty($token['style'])) {
					$strip = $this->compress_css;
				} else if ($content == '<!--wp-html-compression no compression-->') {
					$overriding = !$overriding;
					continue;
				} else if ($this->remove_comments) {
					if (!$overriding && $raw_tag != 'textarea') {
						$content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
					}
				}
			} else {
				if ($tag == 'pre' || $tag == 'textarea') {
					$raw_tag = $tag;
				} else if ($tag == '/pre' || $tag == '/textarea') {
					$raw_tag = false;
				} else {
					if ($raw_tag || $overriding) {
						$strip = false;
					} else {
						$strip = true;
						$content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);
						$content = str_replace(' />', '/>', $content);
					}
				}
			}
			if ($strip) {
				$content = $this->removeWhiteSpace($content);
			}
			$html .= $content;
		}
		return $html;
	}
	public function parseHTML($html)
	{
		$this->html = $this->minifyHTML($html);
		if ($this->info_comment) {
			$this->html .= "\n" . $this->bottomComment($html, $this->html);
		}
	}
	protected function removeWhiteSpace($str)
	{
		$str = str_replace("\t", ' ', $str);
		$str = str_replace("\n", '', $str);
		$str = str_replace("\r", '', $str);
		while (stristr($str, '  ')) {
			$str = str_replace('  ', ' ', $str);
		}
		return $str;
	}
}
function wp_html_compression_finish($html)
{
	return new WP_HTML_Compression($html);
}
function wp_html_compression_start()
{
	ob_start('wp_html_compression_finish');
}
add_action('get_header', 'wp_html_compression_start');
