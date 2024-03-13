<?php
    $posts = $result["data"]['posts'];
    $topic = $result["data"]['topic'];
    
    ?>

<h1>Liste des postes</h1>

<?php if($posts){
    foreach($posts as $post){ 
    ?>
    <h2><?= $post->getTopic() ?></h2>
    <p><?php echo $post->getText() . " posté par " . $post->getUser() . " le : " . $post->getDateCreation()?></a></p>
    <p><a href="index.php?ctrl=forum&action=deletePostById&id=<?= $post->getId() ?>">Supprimer</a></p>
    <p><a href="index.php?ctrl=forum&action=updatePostById&id=<?= $post->getId() ?>">Modifier</a></p>
    <?php } }else
            {
                echo "Il n'y a aucun post sur le sujet ! ";
            } ?>

            <h2>Répondre</h2>
            <br>
            <form action="index.php?ctrl=forum&action=addPost" method="post">
                <textarea placeholder="Saisissez votre réponse" name="text" rows="4" cols="50" required style="text-align: center;"></textarea><br>
                <button type="submit" name="submit">Envoyer</button>
            </form>