<?php
    $topics = $result["data"]['topics'];

    if(!empty($topics)){
        ?>

        <table id="topic-list">
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Date</th>
                <th>Ouvert?</th>
                <th>Actions</th>
            </tr>
        <?php
        
        foreach($topics as $topic){
            $status = ($topic->getClosed()) ? "closed" : "open";
            ?>
            <tr class="topic-<?= $status ?>">
                <td><a href="/forum/viewTopic/<?= $topic->getId() ?>.html"><?= $topic->getTitle() ?></a></td>
                <td class="center"><?= $topic->getUser() ?></td>
                <td class="center"><?= $topic->getCreationdate() ?></td>
                <td class="center"><?= $topic->getClosed() ? "Non" : "Oui" ?></td>
                <td>
                    <div class="actions">
                    <?php
                        if(App\Session::getUser() == $topic->getUser() || App\Session::isAdmin()){
                            ?>
                                <a class="action-btn" href="/forum/lockTopic/<?= $topic->getId() ?>.html?source=list" title="Verrouiller"><span class="fas fa-lock"></span></a>
                                <a class="action-btn delete-btn" href="/forum/deleteTopic/<?= $topic->getId() ?>.html" title="Supprimer"><span class="fas fa-times"></span></a>
                            <?php
                        }
                    ?>
                    </div>
                </td>
            </tr>
            <?php
        }
        ?>
        </table>
        <?php
    }
    else echo "<p>Pas de sujets...</p>";
?>
<p><a href="/forum/addTopic.html">Nouveau sujet</a></p>

    