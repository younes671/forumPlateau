<?php
    $categories = []; 
?>

<h1 class="bienvenue">REGLEMENT DU FORUM</h1>

<h2 class="bienvenue" >PREAMBULE</h2>

<?php
if($categories)
{
foreach($categories as $category ){ ?>
    <p class="list"><a class="lien-list lien-nav" href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getTitle() ?></a></p>
    <?php }
}else
{
    
}


