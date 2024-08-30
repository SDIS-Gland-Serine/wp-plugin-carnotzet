<?php
/*
Plugin Name: Carnotzet
Description: -
Version: 1.0
Author: Nicolas Barbay
Author URI: http://
Plugin URI: http://
*/

define('CARNOTZET_DIR', plugin_dir_path(__FILE__));
define('CARNOTZET_URL', plugin_dir_url(__FILE__));

function carnotzet_load(){
    require_once(CARNOTZET_DIR . 'includes/getDatas.php');
    // require_once(CARNOTZET_DIR . 'includes/process.php'); // Décommentez si nécessaire
}

function carnotzet_activation() {
    // Actions à effectuer lors de l'activation du plugin
    register_uninstall_hook(__FILE__, 'carnotzet_uninstall');
}

function carnotzet_deactivation() {
    // Actions à effectuer lors de la désactivation du plugin
}

function carnotzet_uninstall() {
    // Actions à effectuer lors de la désinstallation du plugin
}

function carnotzet_admin_menu() {
    // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    add_menu_page(
        'Carnotzet',          // Page title
        'Carnotzet',          // Menu title
        'read',     // Capability
        'carnotzet',          // Menu slug
        'displayCarnotzet',   // Function to display the page content
        'dashicons-coffee',   // Icon URL
        20                    // Position
    );
  
    // add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
    add_submenu_page(
        'carnotzet',          // Parent slug
        'Résultat sondage',          // Page title
        'Sondage',          // Menu title
        'read',     // Capability
        'carnotzet-menu1',          // Menu slug
        'displayMenu1'    // Function to display the page content
    );

    add_submenu_page(
        'carnotzet',          // Parent slug
        'Menu2',              // Page title
        'Menu2',              // Menu title
        'EM_HVI',     // Capability
        'carnotzet-menu2',    // Menu slug
        'displayMenu2'        // Function to display the page content
    );

    add_submenu_page(
        'carnotzet',          // Parent slug
        'Menu3',              // Page title
        'Menu3',              // Menu title
        'EM_HVI',     // Capability
        'carnotzet-menu3',    // Menu slug
        'displayMenu3'        // Function to display the page content
    );

    add_submenu_page(
        'carnotzet',          // Parent slug
        'Menu4',              // Page title
        'Menu4',              // Menu title
        'EM_HVI',     // Capability
        'carnotzet-menu4',    // Menu slug
        'displayMenu4'        // Function to display the page content
    );

    // Supprime le menu redondant si nécessaire
    remove_submenu_page('carnotzet', 'carnotzet');
}

function displayMenu1() {
    $carnotzets = getCarnotzet();
    include(CARNOTZET_DIR . 'includes/views/menu1.php');
}

function displayMenu2() {
    $reponses = getCarnotzetReponse();
    include(CARNOTZET_DIR . 'includes/views/menu2.php');

}

function displayMenu3() {
    $carnotzets = getCarnotzet();
    include(CARNOTZET_DIR . 'includes/views/menu3.php');
}

function displayMenu4() {
    $reponses = getCarnotzetReponse();

    // Vérifiez si $reponse contient des données
    if (empty($reponses)) {
        echo '<p>Aucune réponse trouvée.</p>';
    } else {
        include(CARNOTZET_DIR . 'includes/views/menu4.php');
    }
}

// RUN
carnotzet_load();

register_activation_hook(__FILE__, 'carnotzet_activation');
register_deactivation_hook(__FILE__, 'carnotzet_deactivation');

add_action('admin_menu', 'carnotzet_admin_menu');

?>
