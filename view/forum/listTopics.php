<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics</h1>

<?php
foreach($topics as $topic ){ ?>
        <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?php echo $topic->getId() ?>"><?php echo $topic ?></a> publié par <?php echo $topic->getUser() ?> le <?php echo $topic->getDateCreation()?></p>
       
<?php if($topic->getUser()->getId() === App\Session::getUser()->getId() || $_SESSION["user"]->hasRole('ROLE_ADMIN') === APP\Session::isAdmin())
        { ?>
            <p><a href="index.php?ctrl=forum&action=deleteTopicById&id=<?= $topic->getId() ?>">Supprimer</a></p>
            <p><a href="index.php?ctrl=forum&action=updateTopicById&id=<?= $topic->getId() ?>">Modifier</a></p>
            <!-- si getClosed = 1 alors affiche déverrouiller sinon verrouiller  -->
<?php if($topic->getClosed())
      { ?>
            <a href="index.php?ctrl=security&action=unlockTopic&id=<?= $topic->getId() ?>">Déverrouiller</a>
<?php } else
      { ?>
            <a href="index.php?ctrl=security&action=lockTopic&id=<?= $topic->getId() ?>">Verrouiller</a>
<?php } ?>        
<?php  } } ?>

<h1>Ajouter un topic</h1>
        <form action="index.php?ctrl=forum&action=addTopic&id=<?= $category->getId() ?>" method="post">
        
            <label for="title">Titre</label><br>
            <input type="text" id="title" name="title" required><br>
            <textarea placeholder="Saisissez votre premier post" name="text" rows="4" cols="50" required style="text-align: center;"></textarea><br>
                <button type="submit" name="submit">Créer le topic</button>
        </form>

