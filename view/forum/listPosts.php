<?php
    $posts = $result["data"]['posts'];
    $topic = $result["data"]['topic'];
    
    ?>

<!-- <h1>Fil de discussion : <? // $topic->getTitle() ?></h1> -->

<?php if($posts){
    foreach($posts as $post){ 
    ?>
    
    <p><?php echo $post->getText() . " posté par " . $post->getUser() . " le : " . $post->getDateCreation()?></a></p>
    <?php if($post->getUser()->getId() === App\Session::getUser()->getId()){ ?>
    <p><a href="index.php?ctrl=forum&action=deletePostById&id=<?= $post->getId() ?>">Supprimer</a></p>
    <p><a href="index.php?ctrl=forum&action=updatePostById&id=<?= $post->getId() ?>">Modifier</a></p>
    <?php } ?>
    <?php } }else
            {
                echo "Il n'y a aucun post sur le sujet ! ";
            } ?>

            <h2>Répondre</h2>
            <?php if(!$topic->getClosed()){ ?>
            <form action="index.php?ctrl=forum&action=addPost" method="post">
            <input type="hidden" name="topic_id" value="<?= $topic->getId()?>">
                <textarea placeholder="Saisissez votre réponse" name="text" rows="4" cols="50" required style="text-align: center;"></textarea><br>
                <button type="submit" name="submit">Envoyer</button>
            </form>
            <?php }else
            {
                echo "Le sujet est clos !";
            }