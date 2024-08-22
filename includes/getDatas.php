<?php
 


 function getCarnotzet() {
    global $wpdb;

    $table_name1 = $wpdb->prefix . "frmt_form_entry_meta";  // fem
    $table_name2 = $wpdb->prefix . "frmt_form_entry";       // fe
    $table_name3 = $wpdb->prefix . "posts";                 // wp
    $table_name4 = $wpdb->prefix . "postmeta";              // pm

    // Exécution de la requête SQL
    $lines = $wpdb->get_results(
        "
        SELECT 
            fe.form_id, 
            wp.post_title AS polls_name,
            AVG(
                CASE fem.meta_key
                    WHEN 'answer-2' THEN 1
                    WHEN 'answer-3' THEN 2
                    WHEN 'answer-4' THEN 3
                    WHEN 'answer-5' THEN 4
                    WHEN 'answer-6' THEN 5
                    ELSE NULL
                END
            ) AS polls_average,
            COUNT(DISTINCT fe.entry_id) AS polls_entry_count,
            pm.meta_value,
            SUM(CASE WHEN fem.meta_key = 'answer-1' THEN 1 ELSE 0 END) AS answer_1,
            SUM(CASE WHEN fem.meta_key = 'answer-2' THEN 1 ELSE 0 END) AS answer_2,
            SUM(CASE WHEN fem.meta_key = 'answer-3' THEN 1 ELSE 0 END) AS answer_3,
            SUM(CASE WHEN fem.meta_key = 'answer-4' THEN 1 ELSE 0 END) AS answer_4,
            SUM(CASE WHEN fem.meta_key = 'answer-5' THEN 1 ELSE 0 END) AS answer_5,
            SUM(CASE WHEN fem.meta_key = 'answer-6' THEN 1 ELSE 0 END) AS answer_6,
            MAX(fem.date_created) AS polls_max,
            MIN(fem.date_created) AS polls_min
        FROM $table_name1 as fem
        JOIN $table_name2 as fe ON fem.entry_id = fe.entry_id
        JOIN $table_name3 as wp ON fe.form_id = wp.ID
        JOIN $table_name4 as pm ON wp.ID = pm.post_id
        WHERE wp.post_type = 'forminator_polls'
        GROUP BY fe.form_id, wp.post_title, pm.meta_value
		"
    );
    
    // Traiter les données pour extraire formName de meta_value
    foreach ($lines as $line) {
        // Désérialiser le meta_value pour obtenir les paramètres du sondage
        $meta_data = unserialize($line->meta_value);
        
        // Extraire formName
        $line->formName = isset($meta_data['settings']['formName']) ? $meta_data['settings']['formName'] : '';
        $line->polls_description = isset($meta_data['settings']['poll-description']) ? $meta_data['settings']['poll-description'] : '';
        $line->polls_opening_status = isset($meta_data['settings']['opening_status']) ? $meta_data['settings']['opening_status'] : '';
    }

    return $lines;
}

/*
function getCarnotzetReponse() {
    global $wpdb;

    // Définir les noms des tables
    $table_name1 = $wpdb->prefix . "frmt_form_entry_meta"; //fem
    $table_name2 = $wpdb->prefix . "frmt_form_entry"; // fe

    // Exécuter la requête SQL avec jointure explicite
    $lines = $wpdb->get_results(
            "
            SELECT 
                fem.*, fe.form_id
            FROM $table_name1 fem, $table_name2 fe
            WHERE fem.entry_id = fe.entry_id
            AND fem.meta_key LIKE 'answer%'
            "
        );

    return $lines;
}*/

function getFormIds() {
    global $wpdb;

    // Définir les noms des tables
    $table_name1 = $wpdb->prefix . "posts"; //wp
    
    // Exécuter la requête SQL avec jointure explicite
    $lines = $wpdb->get_results(
            "
            SELECT id, post_title
            FROM $table_name1
            WHERE post_type = 'forminator_polls''
            "
            
        );

        
    return $lines;
    }



function getCarnotzetReponse($form_id) {
    global $wpdb;

    // Définir les noms des tables
    $table_name1 = $wpdb->prefix . "frmt_form_entry_meta";
    $table_name2 = $wpdb->prefix . "frmt_form_entry";

    // Exécuter la requête SQL avec jointure explicite
    $lines = $wpdb->get_results(
        $wpdb->prepare(
            "
            SELECT 
                fem.*, fe.form_id
            FROM $table_name1 fem, $table_name2 fe
            WHERE fem.entry_id = fe.entry_id
            AND fem.meta_key LIKE 'answer%'",
            
            $form_id
        )
    );

    return $lines;
}

?>
