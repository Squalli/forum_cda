<?php

    $users = $result['data']['users'];
    
?>
<h1>Liste des utilisateurs</h1>
<ul>
<?php
    foreach($users as $user){
        echo "<li>", $user->getUsername(), ", inscrit depuis le ", $user->getRegisterdate(), "</li>";
    }
    
?>
</ul>