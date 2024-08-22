<div class="wrap stats">
    <?php
    // Déterminer le domaine (non utilisé ici mais inclus pour votre contexte)
    if (str_contains($_SERVER['SERVER_NAME'], 'local')) {
        $domain = 'http://' . $_SERVER['SERVER_NAME'];
    } else {
        $domain = 'https://' . $_SERVER['SERVER_NAME'];
    }

    // Récupérer les form_id pour le menu déroulant
    $form_ids = getFormIds();

    // Obtenir le form_id sélectionné depuis l'URL
    $selected_form_id = isset($_GET['form_id']) ? intval($_GET['form_id']) : '';

    // Récupérer les réponses en fonction du form_id sélectionné
    $reponses = $selected_form_id ? getCarnotzetReponse($selected_form_id) : [];

    ?>

    <h2>Résultats des sondages</h2>

    <!-- Menu déroulant pour sélectionner le form_id -->
    <form method="get" action="">
        <input type="hidden" name="page" value="<?php echo esc_attr($_GET['page']); ?>" />
        <label for="form_id">Sélectionner un sondage :</label>
        <select name="form_id" id="form_id" onchange="this.form.submit()">
            <option value="">Tous les sondages</option>
            <?php foreach ($form_ids as $form_id): ?>
                <option value="<?php echo esc_attr($form_id->ID); ?>" <?php selected($selected_form_id, $form_id->ID); ?>>
                    <?php echo esc_html($form_id->post_title); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Inclure le fichier d'affichage des résultats -->
    <?php
    $file_path = CARNOTZET_DIR . 'includes/views/carnotzetreponse.php';
    if (file_exists($file_path)) {
        include($file_path);
    } else {
        echo '<p>Le fichier d\'affichage des résultats est introuvable.</p>';
    }
    ?>
</div>
