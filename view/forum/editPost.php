<?php
 $post = $result["data"]['post']; 
 ?>

<h2>Modifier</h2>
            <br>
            <form action="index.php?ctrl=forum&action=updatePostById&id=<?= $post->getId() ?>" method="post">
                <input type="hidden" name="topic_id" value="<?= $post->getId() ?>">
                <textarea name="text" value="<?= $post->getText() ?>" rows="4" cols="50" required ></textarea><br>
                <button type="submit" name="submit">Envoyer</button>
            </form>
