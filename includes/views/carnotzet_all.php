<div class="wrap stats">
    <?php
    date_default_timezone_set('Europe/Zurich'); // Définir le fuseau horaire
    foreach ($carnotzets as $carnotzet) {
    // Désérialiser le meta_value
    $meta_data = unserialize($carnotzet->meta_value);




    // Affiche tous les champs
        echo '<pre>';
        print_r($carnotzet);
        print_r($meta_data);
        echo '</pre>';
}

    ?>
</div>