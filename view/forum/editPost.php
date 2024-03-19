<?php
 $post = $result["data"]['post']; 
 ?>

<h1 class="bienvenue">Modifier</h1>
<?php
        if(App\Session::getUser())
        { ?>
            <form class="form" action="index.php?ctrl=post&action=updatePostById&id=<?= $post->getId() ?>" method="post">
                <input class="input" type="hidden" name="topic_id" value="<?= $post->getId() ?>">
                <textarea class="textarea" name="text" value="<?= $post->getText() ?>" rows="4" cols="50" required ><?= $post->getText() ?></textarea>
                <button class="btn" type="submit" name="submit">Envoyer</button>
            </form>
            <?php    
        }else
        {
            header('location: index.php');
        }