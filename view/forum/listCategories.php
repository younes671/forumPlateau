<?php
    $categories = $result["data"]['categories']; 
?>

<h1 class="bienvenue">BIENVENUE SUR LE FORUM</h1>

<h2 class="bienvenue" >Liste des catégories</h2>

<?php
if(App\Session::getUser())
{
    foreach($categories as $category ){ ?>
        <p class="list"><a class="lien-list" href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><h3 class="bienvenue"><?= $category->getTitle() ?></h3></a></p>
    <?php }

}else
{
    header('location: index.php');
}
  
