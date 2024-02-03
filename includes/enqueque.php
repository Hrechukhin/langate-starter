<?PHP

/**
 * Enqueue scripts and styles.
 */
if (!defined('_S_VERSION')) {
	define('_S_VERSION', '1.0.0');
}

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style('theme', get_theme_file_uri('assets/css/main.css'), array(), _S_VERSION);
		wp_enqueue_style('tailwind', get_theme_file_uri('assets/css/tailwind.css'), array(), _S_VERSION);

		wp_enqueue_script('theme', get_theme_file_uri('assets/js/main.js'), array(), _S_VERSION, true);

		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
);
