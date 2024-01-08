<?php
/*
Plugin Name: jQuery Accordion Category Posts
Plugin URI: https://draftpress.com/products
Description: A simple post listing by category widget usign jQuery UI Accordion
Version: 2.1
Author: DraftPress
Author URI: https://draftpress.com
*/

// INITIAL VARIABLES FUNCTION
function nnr_add_options()
{
    add_option('nnr_numcat', '5');
    add_option('nnr_numpost', '5');
}

register_activation_hook(__FILE__, 'nnr_add_options');

//REMOVE OPTIONS ON DEACTIVATION
function nnr_del_options()
{
    delete_option('nnr_numcat');
    delete_option('nnr_numpost');
}

register_deactivation_hook(__FILE__, 'nnr_del_options');

/* START - REGISTER JQUERY LIBS FOR ACCORDION */

function nnr_jquerylibs()
{
    // Call jQuery 1.4
    wp_deregister_script('jquery');
    wp_register_script('jquery', WP_PLUGIN_URL . '/jquery-accordion-category-posts/jqueryui/jquery-1.4.2.js', '', '1.4.2');

//    wp_deregister_script('jquery-ui-core');
//    wp_register_script('jquery-ui-core', WP_PLUGIN_URL . '/jquery-accordion-category-posts/jqueryui/ui/jquery.ui.core.js', '', '1.8.5');
//
    wp_register_script('jquery-ui-widget', WP_PLUGIN_URL . '/jquery-accordion-category-posts/jqueryui/ui/jquery.ui.widget.js', '', '1.8.5');
    wp_register_script('jquery-ui-accordion', WP_PLUGIN_URL . '/jquery-accordion-category-posts/jqueryui/ui/jquery.ui.accordion.js', '', '1.8.5');
    wp_register_script('jquery-accordion-func', WP_PLUGIN_URL . '/jquery-accordion-category-posts/jqueryui/jquery_accordion.js', '', '1.8.5');

    wp_enqueue_script( 'jquery' );
//    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-widget' );
    wp_enqueue_script( 'jquery-ui-accordion' );
    wp_enqueue_script( 'jquery-accordion-func' );
}
if (!is_admin()) {
    add_action('wp_enqueue_scripts', 'nnr_jquerylibs');
}

/* END - REGISTER JQUERY LIBS FOR ACCORDION */


/* START - STYLE SHEET FOR ACCORDION */
function nnr_call_uistyles()
{
    $nnrStyleUrl = WP_PLUGIN_URL . '/jquery-accordion-category-posts/jqueryui/themes/base/jquery.ui.all.css';
    $nnrStyleFile = WP_PLUGIN_DIR . '/jquery-accordion-category-posts/jqueryui/themes/base/jquery.ui.all.css';
    if (file_exists($nnrStyleFile)) {
        wp_register_style('myStyleSheets', $nnrStyleUrl);
        wp_enqueue_style('myStyleSheets');
    }
}

add_action('wp_print_styles', 'nnr_call_uistyles');
/* END - STYLE SHEET FOR ACCORDION */

function nnr_load_accordion()
{
    $accdivs = '<div id="accordion">';
    $numofcats = get_option('nnr_numcat');
    $numofposts = get_option('nnr_numpost');
    $catargs = 'number=' . $numofcats;

    $categories = get_categories($catargs);
    foreach ($categories as $category) {
        $nnr_catid = $category->term_id;
        $accdivs .= '<h3><a href="#">' . $category->cat_name . '</a></h3>';
        $accdivs .= '<div>';
        $queryargs = 'posts_per_page=' . $numofposts . '&cat=' . $nnr_catid;
        query_posts($queryargs);
        if (have_posts()) : while (have_posts()) : the_post();
            $accdivs .= '<a href=' . get_permalink() . ' rel=bookmark title=Permanent Link to ' . get_the_title() . '>' . get_the_title() . '</a><br>';
        endwhile;
        else:
        endif;
        wp_reset_query();
        $accdivs .= '</div>';
    }
    $accdivs .= '</div>';
    echo $accdivs;
    return $accdivs;
}

wp_register_sidebar_widget("1", "jQuery Accordion Categories", "nnr_load_accordion");


function nnr_admin_update()
{

    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    $CreateForm = '<div style="margin-top:60px;">';
    if ( isset( $_POST['submit'] ) && isset( $_POST['wp_nonce'] ) ) {
        
        // Verify the nonce.
        if (wp_verify_nonce($_POST['wp_nonce'], 'nnr_options_form_nonce')) {

            //Getting admin form update.
            $nnr_numcat = sanitize_text_field($_REQUEST['numcats']);
            $nnr_numpost = sanitize_text_field($_REQUEST['numposts']);
            update_option('nnr_numcat', $nnr_numcat);
            update_option('nnr_numpost', $nnr_numpost);
            $CreateForm .= '<strong>Options updated</strong>.<br /><br />';
        } else {
            // Nonce verification failed, handle the error or redirect
            $CreateForm .= '<strong>Error: Nonce verification failed</strong>.<br /><br />';
        }
    }

    // check the query string contains _wpnonce.
    if(!isset( $_GET['_wpnonce'] ) ) {

        // action=edit&popup_id=1 please add it to the url.
        if ( isset( $_GET['page'] ) && 'nnr-options' === $_GET['page'] ) {
            $new_url = add_query_arg(
                array(
                    'page' => 'nnr-options',
                    '_wpnonce' => wp_create_nonce( 'nnr_options_nonce' ),
                ),
                admin_url('options-general.php')
            );
        }
        else {

            $new_url = add_query_arg(
                array(
                    'page' => 'nnr-options',
                    '_wpnonce' => wp_create_nonce( 'nnr_options_nonce' ),
                ),
                admin_url('options-general.php')
            );

        }

        ?>
        <script type="text/javascript">
            window.location = "<?php echo $new_url; ?>";
        </script>
        <?php


    } else {

        $CreateForm .= '<h2>jQuery UI Accordion Categories Options</h2>';
        $CreateForm .= '<form name="form1" method="post" action="' . $_SERVER["REQUEST_URI"] . '">';
        $CreateForm .= 'Number of categories to be displayed: ';
        $CreateForm .= '<input type="text" name="numcats" value=' . get_option('nnr_numcat') . '><br />';
        $CreateForm .= 'Number of posts to be displayed under each category: ';
        $CreateForm .= '<input type="text" name="numposts" value=' . get_option('nnr_numpost') . '><br />';
        // Add nonce field.
        $CreateForm .= wp_nonce_field( 'nnr_options_form_nonce', 'wp_nonce' );
        $CreateForm .= '<br /><input type="submit" value="Update Options" name="submit"><br />';
        $CreateForm .= '</form>';
        $CreateForm .= '<br /><br />jQuery UI Accordion Categories plugin developed by <a href="https://www.99robots.com/" target="_blank">99 Robots</a>';
        $CreateForm .= '</div>';

        echo $CreateForm;
    }

}

function nnr_plugin_menu()
{
    add_options_page('jQuery Accordion Categories', 'jQuery Accordion Categories', 'manage_options', 'nnr-options', 'nnr_admin_update');
}

add_action('admin_menu', 'nnr_plugin_menu');

?>
