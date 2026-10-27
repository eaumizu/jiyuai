<?php
/**
 * Plugin Name: JiyuAI App
 * Description: ブログと共存する Web アプリの拡張用ショートコード。
 * Version: 0.1.0
 */
if (!defined('ABSPATH')) { exit; }
add_shortcode('jiyuai_app', function () {
    return '<section class="jiyuai-app" aria-label="JiyuAI"><h2>'
        . esc_html('JiyuAI アプリ') . '</h2><p>'
        . esc_html('ここから Web アプリの機能を追加できます。') . '</p></section>';
});
