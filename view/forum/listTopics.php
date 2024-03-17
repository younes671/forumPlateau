<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1 class="bienvenue" >Liste des topics</h1>

<?php
if($topics)
{
    foreach($topics as $topic ){ ?>
            <div class="topic"><i class="fa-solid fa-arrow-right"></i><p class="lien-topic"><a class="lien-list lien-nav" href="index.php?ctrl=forum&action=listPostsByTopic&id=<?php echo $topic->getId() ?>"><h2 class="bienvenue"><?php echo $topic ?></h2></a></p><p class="auteur-topic">publié par <?php echo $topic->getUser() ?> le <?php echo $topic->getDateCreation()?></p></div>
           
        <!-- donne droit à l'admin de tout faire sur le site et donne droit à l'auteur de manipuler ses publications -->
    <div class="lien-topic">
    <?php if($topic->getUser()->getId() === App\Session::getUser()->getId() || $_SESSION["user"]->hasRole('ROLE_ADMIN') === APP\Session::isAdmin())
            { ?> <div class="l1">
                <p class="lien"><a class="lien-gestion1" href="index.php?ctrl=forum&action=deleteTopicById&id=<?= $topic->getId() ?>">Supprimer</a></p>
                <p class="lien"><a class="lien-gestion2" href="index.php?ctrl=forum&action=updateTopicById&id=<?= $topic->getId() ?>">Modifier</a></p>
                <!-- si getClosed = 1 alors affiche déverrouiller sinon verrouiller  -->
    <?php if($topic->getClosed())
          { ?>
                <p class="lien"><a class="lien-gestion3" href="index.php?ctrl=security&action=unlockTopic&id=<?= $topic->getId() ?>">Déverrouiller<i class="fa-solid fa-lock-open"></i></a></p>
    <?php } else
          { ?>
                <p class="lien"><a class="lien-gestion3" href="index.php?ctrl=security&action=lockTopic&id=<?= $topic->getId() ?>">Verrouiller<i class="fa-solid fa-lock"></i></a></p>
    <?php } ?>  
    </div> 
    </div>     
    <?php  }
    }  
}else
{
    echo "<p class='bienvenue'>Il n'y a aucun topic dans cette catégorie ! </p>";
} ?>

<h1 class="bienvenue" >Ajouter un topic</h1>
        <form class="form" action="index.php?ctrl=forum&action=addTopic&id=<?= $category->getId() ?>" method="post">
        
            
            <input placeholder="Titre" class="input-titre" type="text" id="title" name="title" required>
            <textarea class="textarea" placeholder="Saisissez votre premier post" name="text" rows="4" cols="50" required style="text-align: center" oninput="this.value = this.value.slice(0, this.getAttribute('maxlength'))" maxlength="500"></textarea>
            <p>Caractères max : <span id="caracteres-restants">500</span></p>
                <button class="btn" type="submit" name="submit">Créer le topic</button>
        </form>

