<?php

    $user = $result['data']['user'];
    
?>

<article>
    <h1>Profil de <?= $user ?></h1>
    <p>
        Membre depuis le <?= $user->getRegisterdate("d/m/Y") ?>
    </p>
    <p>
        Informations :
        <ul>
            <li>Adresse mail : <?= $user->getEmail() ?></li>
            <li>Statut : 
                <ul>
                <?php 
                    foreach($user->getRoles() as $role){
                    ?>
                    <li><?= $role ?></li>
                    <?php 
                    } 
                ?>
                </ul>
            </li>
        </ul>
    </p>
</article>