<?php
if (get_option('jiyuai_initialized')) { echo "Site already initialized.\n"; return; }
$pages = [
    'home' => ['JiyuAI', '<!-- wp:heading --><h2 class="wp-block-heading">自由な発想を、かたちに。</h2><!-- /wp:heading --><!-- wp:paragraph --><p>JiyuAI へようこそ。ブログと Web アプリを、ここから育てていきます。</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="/?pagename=blog">ブログ</a> · <a href="/?pagename=apps">Web アプリ</a></p><!-- /wp:paragraph -->'],
    'blog' => ['ブログ', ''],
    'apps' => ['Web アプリ', '<!-- wp:shortcode -->[jiyuai_app]<!-- /wp:shortcode -->'],
];
$ids = [];
foreach ($pages as $slug => [$title, $content]) {
    $existing = get_page_by_path($slug);
    $ids[$slug] = $existing ? $existing->ID : wp_insert_post([
        'post_type' => 'page', 'post_status' => 'publish',
        'post_name' => $slug, 'post_title' => $title, 'post_content' => $content,
    ], true);
    if (is_wp_error($ids[$slug])) { throw new RuntimeException($ids[$slug]->get_error_message()); }
}
update_option('show_on_front', 'page');
update_option('page_on_front', $ids['home']);
update_option('page_for_posts', $ids['blog']);
update_option('timezone_string', 'Asia/Tokyo');
update_option('blogdescription', '自由な発想を、かたちに。');
update_option('jiyuai_initialized', 1);
echo "Site pages configured.\n";
