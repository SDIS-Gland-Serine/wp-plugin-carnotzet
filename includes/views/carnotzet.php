<div class="wrap stats">
    <?php
    if(str_contains($_SERVER['SERVER_NAME'],'local')) {
        $domain = 'http://'.$_SERVER['SERVER_NAME'];
    } else {
        $domain = 'https://'.$_SERVER['SERVER_NAME'];
    }
    ?>
	<h2>Resultats des sondages</h2>
    <table class="wp-list-table widefat sortable">
        <thead>
            <tr>
                <th style="text-align:center;">Rang</th> <!-- Nouvelle colonne pour le classement -->
                <th>Type</th>
                <th>Nom</th>   
                <th>Moyenne</th>    
                <th style="text-align:center;">Nb de votes</th>
                <th >date min</th>  
                <th >date max</th>   
             <!--   <th style="text-align:center;">Note 0</th>
				<th style="text-align:center;">Note 1</th>
				<th style="text-align:center;">Note 2</th>    
                <th style="text-align:center;">Note 3</th>    
                <th style="text-align:center;">Note 4</th>
                <th style="text-align:center;">Note 5</th>  -->
            </tr>
        </thead>
        <tbody>
            <?php
                // Trier le tableau par polls_average
                usort($carnotzets, function($a, $b) {
                    return $b->polls_average <=> $a->polls_average;
                });

                $numrow = 0;
                foreach ($carnotzets as $index => $carnotzet) {
                    // Désérialiser le meta_value
                    $meta_data = unserialize($carnotzet->meta_value);
					// Incrémenter le compteur à chaque itération
					$numrow++;

                    //Status du sondage
                    $status = ($carnotzet->polls_opening_status == '') ? '' : ' (sondage clos)';
                    $close = ($carnotzet->polls_opening_status == '') ? '' : 'old';

					// Déterminer la classe pour l'alternance des lignes
					$class = ($numrow % 2 == 1) ? $close.' alternate' : $close ;

					//echo '<tr class="'.$class.'">';
                    echo '<tr class="' .$class. '">';
					echo '<td style="text-align:center;">'.($index + 1).'</td>'; // Affiche le rang
					echo '<td class="nowrap">'.$carnotzet->polls_description.'</td>';
                    echo '<td class="nowrap">'.$carnotzet->formName.'<i>'.$status.'</i></td>';
					echo '<td >'.$carnotzet->polls_average.'</td>';
					echo '<td style="text-align:center;">'.$carnotzet->polls_entry_count.'</td>';
                    echo '<td class="nowrap">'.$carnotzet->polls_min.'</td>';
                    echo '<td class="nowrap">'.$carnotzet->polls_max.'</td>';
                   /* echo '<td style="text-align:center;">'.$carnotzet->answer_1.'</td>';
					echo '<td style="text-align:center;">'.$carnotzet->answer_2.'</td>';
					echo '<td style="text-align:center;">'.$carnotzet->answer_3.'</td>';
					echo '<td style="text-align:center;">'.$carnotzet->answer_4.'</td>';
					echo '<td style="text-align:center;">'.$carnotzet->answer_5.'</td>';
					echo '<td style="text-align:center;">'.$carnotzet->answer_6.'</td>'; */
					echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</div>
