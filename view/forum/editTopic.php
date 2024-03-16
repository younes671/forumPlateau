<?php
 $categories = $result["data"]['categories']; 
 $topics = $result["data"]['topics']; 
 ?>

<h1 class="bienvenue">Modifier</h1>
            
            <form class="form" action="index.php?ctrl=forum&action=updateTopicById&id=<?= $topics->getId() ?>" method="post">
                <input type="hidden" name="topic_id" value="<?= $topics->getId() ?>">
                <input class="input" name="title" value="<?= $topics->getTitle() ?>">
                <select class="input" name="category" id="category">
                    <?php foreach($categories as $category) { ;?>
                        <option value="<?= $category->getId() ?>">
                        <?= $category->getTitle() ?>
                    </option>
                    <?php } ?>
                </select>
                <button class="btn" type="submit" name="submit">Envoyer</button>
            </form>
