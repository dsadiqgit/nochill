<?php
add_action( 'after_setup_theme', 'generic_setup' );
function generic_setup() {
load_theme_textdomain( 'generic', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'custom-logo' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'html5', array( 'search-form', 'navigation-widgets' ) );
add_theme_support( 'woocommerce' );
global $content_width;
if ( !isset( $content_width ) ) { $content_width = 1920; }
register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'generic' ) ) );
}

add_action( 'wp_footer', 'generic_footer' );
function generic_footer() {
?>
<script>
jQuery(document).ready(function($) {
$(".before").on("focus", function() {
$(".last").focus();
});
$(".after").on("focus", function() {
$(".first").focus();
});
$(".menu-toggle").on("keypress click", function(e) {
if (e.which == 13 || e.type === "click") {
e.preventDefault();
$("#menu").toggleClass("toggled");
$(".looper").toggle();
}
});
$(document).keyup(function(e) {
if (e.keyCode == 27) {
if ($("#menu").hasClass("toggled")) {
$("#menu").toggleClass("toggled");
}
}
});
$("img.no-logo").each(function() {
var alt = $(this).attr("alt");
$(this).replaceWith(alt);
});
});
</script>
<?php
}
add_filter( 'document_title_separator', 'generic_document_title_separator' );
function generic_document_title_separator( $sep ) {
$sep = esc_html( '|' );
return $sep;
}
add_filter( 'the_title', 'generic_title' );
function generic_title( $title ) {
if ( $title == '' ) {
return esc_html( '...' );
} else {
return wp_kses_post( $title );
}
}
function generic_schema_type() {
$schema = 'https://schema.org/';
if ( is_single() ) {
$type = "Article";
} elseif ( is_author() ) {
$type = 'ProfilePage';
} elseif ( is_search() ) {
$type = 'SearchResultsPage';
} else {
$type = 'WebPage';
}
echo 'itemscope itemtype="' . esc_url( $schema ) . esc_attr( $type ) . '"';
}
add_filter( 'nav_menu_link_attributes', 'generic_schema_url', 10 );
function generic_schema_url( $atts ) {
$atts['itemprop'] = 'url';
return $atts;
}
if ( !function_exists( 'generic_wp_body_open' ) ) {
function generic_wp_body_open() {
do_action( 'wp_body_open' );
}
}
add_action( 'wp_body_open', 'generic_skip_link', 5 );
function generic_skip_link() {
echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', 'generic' ) . '</a>';
}
add_filter( 'the_content_more_link', 'generic_read_more_link' );
function generic_read_more_link() {
if ( !is_admin() ) {
return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', 'generic' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
}
}
add_filter( 'excerpt_more', 'generic_excerpt_read_more_link' );
function generic_excerpt_read_more_link( $more ) {
if ( !is_admin() ) {
global $post;
return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', 'generic' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
}
}
add_filter( 'big_image_size_threshold', '__return_false' );
add_filter( 'intermediate_image_sizes_advanced', 'generic_image_insert_override' );
function generic_image_insert_override( $sizes ) {
unset( $sizes['medium_large'] );
unset( $sizes['1536x1536'] );
unset( $sizes['2048x2048'] );
return $sizes;
}
add_action( 'widgets_init', 'generic_widgets_init' );
function generic_widgets_init() {
register_sidebar( array(
'name' => esc_html__( 'Sidebar Widget Area', 'generic' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
add_action( 'wp_head', 'generic_pingback_header' );
function generic_pingback_header() {
if ( is_singular() && pings_open() ) {
printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
}
}
add_action( 'comment_form_before', 'generic_enqueue_comment_reply_script' );
function generic_enqueue_comment_reply_script() {
if ( get_option( 'thread_comments' ) ) {
wp_enqueue_script( 'comment-reply' );
}
}
function generic_custom_pings( $comment ) {
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
<?php
}
add_filter( 'get_comments_number', 'generic_comment_count', 0 );
function generic_comment_count( $count ) {
if ( !is_admin() ) {
global $id;
$get_comments = get_comments( 'status=approve&post_id=' . $id );
$comments_by_type = separate_comments( $get_comments );
return count( $comments_by_type['comment'] );
} else {
return $count;
}
}

// ---------------------------------------- Custom Functions -------------------------------------------

// -------- Bootstrap CDN
wp_register_style( 'Bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' );
wp_enqueue_style('Bootstrap');

// -------- Fontawesome CDN
wp_register_style( 'Font_Awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css' );
wp_enqueue_style('Font_Awesome');

// --------- Load Custom CSS
function generic_enqueue() {
    wp_enqueue_style( 'generic-style', get_stylesheet_uri() );
    wp_enqueue_style( 'generic-icons', get_template_directory_uri() . '/icons/icons.css' );
    wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'generic_enqueue' );

// -------- Slick slider css
wp_register_style( 'Slick_slider_css', get_stylesheet_directory_uri() . '/vendors/slick.css');
wp_enqueue_style('Slick_slider_css');

// -------- Slick slider JS
function slick_slider_load() {
    wp_enqueue_script( 'slick_slider_script', get_stylesheet_directory_uri() . '/js/vendors/slick.min.js');
}

add_action('wp_enqueue_scripts','slick_slider_load');

// -------- Custom JS
function custom_js_load() {
    wp_enqueue_script( 'custom-js-script', get_stylesheet_directory_uri() . '/js/custom.js');
}

add_action('wp_enqueue_scripts','custom_js_load');


// Footer Menu

function wpb_custom_footer_menu() {
  register_nav_menus(
    array(
      'main-footer-menu' => __( 'Main Footer Menu' )
    )
  );
}
add_action( 'init', 'wpb_custom_footer_menu' );

// Useful Links Menu

function useful_links_menu() {
  register_nav_menus(
    array(
      'useful-links-menu' => __( 'Useful Links Menu' )
    )
  );
}
add_action( 'init', 'useful_links_menu' );

//
function space_change_custom_taxonomy_slug_args( $taxonomy, $object_type, $args ){
  if( 'category' == $taxonomy ){ // Instead of the "old-slug", add current slug, which you want to change.
      remove_action( current_action(), __FUNCTION__ );
      $args['rewrite'] = array( 'slug' => 'security-solutions' ); // Instead of the "new-slug", add a new slug name.
      register_taxonomy( $taxonomy, $object_type, $args );
  }
}
add_action( 'registered_taxonomy', 'space_change_custom_taxonomy_slug_args', 10, 3 );

// changing blog excerpt length 
function mytheme_custom_excerpt_length( $length ) {
  return 15;
}
add_filter( 'excerpt_length', 'mytheme_custom_excerpt_length', 999 );