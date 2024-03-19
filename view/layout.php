<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= $meta_description ?>">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
        <title>FORUM</title>
    </head>
    <body>
        <div id="wrapper"> 
            <div id="mainpage">
                <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
                <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
                <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
                <header class="header">
                    <nav class="nav">
                        <div id="nav-left">
                        <?php
                        if(App\Session::getUser()){
                            ?>
                            <p class="lien-nav"><a class="navbar" href="index.php?ctrl=forum&action=index">Accueil</a></p>
                            <?php }else{ ?>
                                <p class="lien-nav"><a class="navbar" href="index.php">Accueil</a></p>
                           <?php } ?>
                            <?php
                            if(App\Session::isAdmin()) : 
                                ?>
                                <p class="lien-nav"><a class="navbar" href="index.php?ctrl=home&action=users">Liste users</a></p>
                            <?php endif; ?>
                        </div>
                        <div id="nav-right">
                        <?php
                            // si l'utilisateur est connecté 
                            if(App\Session::getUser()){
                                ?>
                                <p class="lien-nav"><a class="navbar" href="index.php?ctrl=security&action=profil"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser()?></a></p>
                                <p class="lien-nav"><a class="navbar" href="index.php?ctrl=security&action=logout">Déconnexion</a></p>                            
                                <?php
                            }
                            else{
                                ?>
                                <p class="lien-nav"><a class="navbar" href="index.php?ctrl=security&action=register">Inscription</a></p>
                                <p class="lien-nav"><a class="navbar" href="index.php?ctrl=security&action=login">Connexion</a></p>
                            <?php
                            }
                        ?>
                        </div>
                    </nav>
                </header>
                
                <main id="forum">
                    <?= $page ?>
                </main>
            </div>
              
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>
        <script>
            $(document).ready(function(){
                $(".message").each(function(){
                    if($(this).text().length > 0){
                        $(this).slideDown(500, function(){
                            $(this).delay(3000).slideUp(500)
                        })
                    }
                })
                $(".delete-btn").on("click", function(){
                    return confirm("Etes-vous sûr de vouloir supprimer?")
                })
                tinymce.init({
                    selector: '.post',
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                    content_css: '//www.tiny.cloud/css/codepen.min.css'
                });
            })
        </script>
        <script src="<?= PUBLIC_DIR ?>/js/script.js"></script>
        <footer>
                    <p class="reg1">&copy; <?= date_create("now")->format("Y") ?></p>   <p class="footer"><a class="reg" href="index.php?ctrl=forum&action=reglement">Règlement du forum</a></p>   <p class="footer"><a class="reg" href="index.php?ctrl=forum&action=mention">Mentions légales</a></p>
                </footer>
        </div>
    </body>
</html>