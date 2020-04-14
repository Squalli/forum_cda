<?php
    $topics = $result["data"]['topics'];
    
?>
<table>
    <tr>
        <th>Titre</th>
        <th>Auteur</th>
        <th>Date</th>
        <th>Ouvert?</th>
    </tr>
    <?php
    foreach($topics as $topic){
        ?>
        <tr>
            <td><a href="?ctrl=home&action=voirTopic&id=<?= $topic->getId() ?>"><?= $topic->getTitle() ?></a></td>
            <td><?= $topic->getUser() ?></td>
            <td><?= $topic->getCreationdate() ?></td>
            <td><?= $topic->getClosed() ? "Non" : "Oui" ?></td>
        </tr>
        <?php
    }
    ?>
</table>
    