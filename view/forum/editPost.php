<?php
 $post = $result["data"]['post']; 
 ?>

<h1 class="bienvenue">Modifier</h1>
            <br>
            <form class="form" action="index.php?ctrl=forum&action=updatePostById&id=<?= $post->getId() ?>" method="post">
                <input class="input" type="hidden" name="topic_id" value="<?= $post->getId() ?>">
                <textarea class="textarea" placeholder="Saisissez votre message" name="text" value="<?= $post->getText() ?>" rows="4" cols="50" required ></textarea><br>
                <button class="btn" type="submit" name="submit">Envoyer</button>
            </form>
