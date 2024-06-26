<?php
    $posts = $result["data"]['posts'];
    $topic = $result["data"]['topic'];
    
   if($topic){ ?>
    
<h1 class="bienvenue" >Fil de discussion : <?= $topic->getTitle() ?></h1>

<?php  

if(!App\Session::getUser())
{ 
    header('location: index.php');

}else
    {   
       
        if($posts){ 
                foreach($posts as $post){ 
                ?>
                    <div class="block-post"><p class="text-post" ><?php echo $post->getText() . "</p><p class='auteur-post'>posté par " . $post->getUser() . " le : " . $post->getDateCreation()?></a></p></div>
    
                <!-- donne droit à l'admin de tout faire sur le site et donne droit à l'auteur de manipuler ses publications -->
            <div class="lien-topic">
            <?php   if($post->getUser()->getId() === App\Session::getUser()->getId() || $topic->getUser()->getId() === APP\Session::isAdmin()){ ?>
                <div class="l1">
                        <p class="lien"><a class="lien-gestion1" href="index.php?ctrl=post&action=deletePostById&id=<?= $post->getId() ?>">Supprimer</a></p>
                        <p class="lien"><a class="lien-gestion2" href="index.php?ctrl=post&action=updatePostById&id=<?= $post->getId() ?>">Modifier</a></p>
            <?php } ?>
            </div> 
            </div> 
    
            <?php } }else
                        {
                            echo "<p class='bienvenue'>Il n'y a aucun post sur le sujet ! </p>";
                        } ?>
                        <div class="l1">
                            <p class="lien"><a class="lien-gestion2" href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?= $topic->getCategory()->getId() ?>">Revenir à la liste</a></p>
                        </div>

                        <h2 class="bienvenue" >Envoyer un message</h2>
                    <?php if(!$topic->getClosed()){ ?>
                        <form class="form" action="index.php?ctrl=post&action=addPost&id=<?= $topic->getId()?>" method="post">
                            <textarea class="textarea" placeholder="Saisissez votre réponse" name="text" rows="4" cols="50" required style="text-align: center;"></textarea><br>
                            <button class="btn" type="submit" name="submit">Envoyer</button>
                        </form>
                    <?php }else
                        {
                            echo "Le sujet est clos !";
                        }
        }     
    }else
    {
        echo "<h1 class='bienvenue'>Le post spécifié n'existe pas ! </h1>";
    }


