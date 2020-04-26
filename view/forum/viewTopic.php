<?php

    $topic = $result['data']['topic'];
    $posts = $result['data']['posts'];
    $postIdToEdit = (isset($result['data']['postIdToEdit'])) ? $result['data']['postIdToEdit'] : null;

?>
<header id="topic-header">
    <p><a href="/">Retour à la liste des sujets</a></p>
    <h1><?= ($topic->getClosed()) ? "(Verrouillé)&nbsp;" : "" ?><?= $topic->getTitle() ?></h1>
    <p>
        <em>
            Par 
            <a href="/security/viewProfile/<?= $topic->getUser()->getId() ?>.html">
                <?= $topic->getUser() ?>
            </a>, 
            le <?= $topic->getCreationdate("d/m/Y")?>
        </em>
        <div class="actions"> 
            <?php
                if(App\Session::getUser() == $topic->getUser() || App\Session::isAdmin()){
                    ?>
                        <a class="action-btn" href="/forum/lockTopic/<?= $topic->getId() ?>.html">
                            <?= ($topic->getClosed()) ? 
                                "<span class='fas fa-unlock'></span>&nbsp;Déverrouiller" : 
                                "<span class='fas fa-lock'></span>&nbsp;Verrouiller" 
                            ?>
                            
                        </a>
                        <a class="action-btn delete-btn" href="/forum/deleteTopic/<?= $topic->getId() ?>.html" title="Supprimer">
                            <span class="fas fa-times"></span>&nbsp;Supprimer
                        </a>
                    <?php
                }
            ?>
        </div>
    </p>
</header>

<table id="posts">
<?php
    
    if($posts != null){
        
        foreach($posts as $post){
            ?>
            <tr>
                <td class="post-author">
                
                    <p class="post-username">
                        <a href="/security/viewProfile/<?= $post->getUser()->getId() ?>.html">
                            <?= $post->getUser() ?>
                        </a>
                    </p>
                    <p class="post-date"><?= $post->getCreationdate()?></p>
                    
                </td>
                <td class="post-text">
                    <?php
                        if(App\Session::getUser() == $post->getUser() || App\Session::isAdmin()){
                    ?>
                    <div class="actions">
                        <a class="action-btn" href="/forum/editPost/<?= $post->getId()?>.html">
                            <span class="fas fa-edit"></span>
                        </a>
                        <a class="action-btn" href="">
                            <span class="fas fa-times"></span>
                        </a>
                    </div>
                    <?php
                    }
                ?>
                <?php
                    if($postIdToEdit === $post->getId()){
                        ?>
                        <form method='post' action="/forum/editPost/<?= $post->getId()?>.html">
                            <p><textarea class="post" name='newtext'><?= $post->getText()?></textarea></p>
                            <p>
                                <input type='submit' value='Modifier'>&nbsp;
                                <a href="/forum/viewTopic/<?= $topic->getId() ?>.html">Annuler</a>
                            </p>
                        </form>
                        <?php
                    }
                    else{
                        ?>
                        <article>
                            <?= $post->getText()?>
                        </article>
                        <?php
                    }
                ?>
                </td>
            </tr>
        <?php
        }
    }
    else{
        ?>
        <p>Aucun message...</p>
        <?php
    }
?>
</table>
<?php
    if($topic->getClosed()){
        ?>
        <p>Ce sujet est verrouillé !</p>
        <?php
    }
    else{
        ?>
        <section id="new-post">
            <h4>Répondre</h4>
            <form action="/forum/addPost/<?= $topic->getId()?>.html" method="post">
                <p><textarea class="post" name="post" placeholder="Votre message..." rows=4></textarea></p>
                <p><input type="submit" value="Valider"></p>
            </form>
        </section>
        <?php
    }
?>