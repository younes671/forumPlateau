<?php 

    $posts = $result["data"]['posts']; 
    $user = $result["data"]['user']; 
    
    

        if(App\Session::getUser())
        { ?>

    <h1 class="bienvenue" > Profil de <?= $_SESSION["user"]->getUserName() ?></h1>
            

                <p class="home-connect">Pseudo : <?= $_SESSION["user"]->getUserName() ?></p>
                
                <p class="home-connect">Email : <?= $_SESSION["user"]->getEmail() ?></p>

                
          
    
        
            <h2 class="bienvenue">Liste de vos posts</h2>
          
                    <?php
                    if($posts)
                    {
                        foreach($posts as $post)
                        {  ?>
                          <p class="home-connect">categorie : <a class="lien-list" href="index.php?ctrl=post&action=listPostsByTopic&id=<?= $post->getTopic()->getId()?>"><?= $post->getTopic()?></a></p>
                        <div class="l2">
                          <p class="home-connect">Message : </p><p class="home-connect"><?= $post->getText()?></p><p class="home-connect"> publié le : <?= $post->getDateCreation()?></p>
                        </div>
                        <?php }
                    }else

                    {
                      echo "<p class='home-connect'>Vous n'avez participé à aucun Topic ! </p>";
                    }
                  
        }else
        {
            header('location: index.php');
        }

     