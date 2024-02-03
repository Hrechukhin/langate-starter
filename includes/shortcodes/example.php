<?php
function shortcode_hello_world() {
    echo ('Hello, World!');
}
add_shortcode('hello_world', 'shortcode_hello_world');
