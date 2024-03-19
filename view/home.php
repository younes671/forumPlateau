<?php
    $categories = []; 
?>

<h1 class="bienvenue">BIENVENUE SUR LE FORUM</h1>

<h2 class="bienvenue" >Page d'accueil</h2>

<?php
if($categories)
{
foreach($categories as $category ){ ?>
    <p class="list"><a class="lien-list lien-nav" href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getTitle() ?></a></p>
    <?php }
}else
{
    echo "<h4 class='bienvenue msg'>Pour acceder au contenu, veuillez vous connecter ou vous inscrire ! </h4>";
}

 


