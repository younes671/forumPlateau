<?php 

    $posts = $result["data"]['posts']; 
    $user = $result["data"]['user']; 
    
    ?>

    <h1> Profil de <?= $_SESSION["user"]->getUserName() ?></h1>
            

                <p>Pseudo : <?= $_SESSION["user"]->getUserName() ?></p>
                
                <p>Email : <?= $_SESSION["user"]->getEmail() ?></p>

                
          
    
        
            <h1>Liste de vos posts</h1>
          
                    <?php foreach($posts as $post){  ?>
                      <p> category : <?= $post->getTopic()?><p>
                      <?= $post->getText()?>
                     publié le : <?= $post->getDateCreation()?></li>
                    <?php }?>
     