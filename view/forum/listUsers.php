<?php
    $users = $result["data"]['users'];
    
?>

<h1 class="bienvenue">Liste des utilisateurs</h1>

<?php if($users){
foreach($users as $user){  ?>
    <p class="home-connect style"><?= $user->getUserName() . " inscrit le : <p class='date'>" . $user->getDateRegistration()?></a></p></p>
    <?php if($_SESSION["user"]->hasRole('ROLE_ADMIN') === APP\Session::isAdmin())
        { ?> 
            <p class="lien1"><a class="lien-gestion1" href="index.php?ctrl=forum&action=deleteUserById&id=<?= $user->getId() ?>">Supprimer</a></p>
<?php } 
} 
}else
    {
        echo "Il n'y a aucun utilisateur ! ";
    } 