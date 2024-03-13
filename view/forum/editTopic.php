<?php
 $categories = $result["data"]['categories']; 
 $topics = $result["data"]['topics']; 
 ?>

<h2>Modifier</h2>
            <br>
            <form action="index.php?ctrl=forum&action=updateTopicById&id=<?= $topics->getId() ?>" method="post">
                <input type="hidden" name="topic_id" value="<?= $topics->getId() ?>">
                <input name="title" value="<?= $topics->getTitle() ?>"><br>
                <select name="category" id="category">
                    <?php foreach($categories as $category) { ;?>
                        <option value="<?= $category->getId() ?>">
                        <?= $category->getTitle() ?>
                    </option>
                    <?php } ?>
                </select>
                <button type="submit" name="submit">Envoyer</button>
            </form>
