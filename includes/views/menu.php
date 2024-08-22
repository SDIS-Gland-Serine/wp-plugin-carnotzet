<div class="wrap stats">
    <?php
    // Déterminer le domaine
    if (str_contains($_SERVER['SERVER_NAME'], 'local')) {
        $domain = 'http://' . $_SERVER['SERVER_NAME'];
    } else {
        $domain = 'https://' . $_SERVER['SERVER_NAME'];
    }
    ?>

    <h2>Résultats des sondages</h2>
    <?php    echo '<pre>';
        print_r($reponses);
        echo '</pre>';
              
            ?>
