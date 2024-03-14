<?php
namespace Controller;


use App\AbstractController;
use App\DAO;
use Model\Managers\UserManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use App\Session;
use App\ControllerInterface;

class SecurityController extends AbstractController implements ControllerInterface{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function index() {}

    public function register ($id) {
        if(isset($_POST['submit']))
        {
            DAO::connect();

            $userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $pass1 = filter_input(INPUT_POST, 'pass1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, 'pass2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // preg_match permet de rechercher des caractères dans une chaine longueur etc... regex
            if (!preg_match("/^.{12,}$/", $pass1)) {
                echo "Le mot de passe doit contenir au moins 12 caractères.";
                $this->redirectTo("home","index");
             }

            if($userName && $email && $pass1 && $pass2)
            {
                $userManager = new UserManager;
                $user = $userManager->findUserByEmail($email);
               
                if($user)
                {
                   $this->redirectTo("security", "login"); exit;
                }else
                {
                    if($pass1 == $pass2)
                    {
                        
                        $hash = password_hash($pass1, PASSWORD_DEFAULT);
                        $new = ['userName' => $userName, 'motDePasse' => $hash, 'email' => $email, 'role' => 'ROLE_USER'];
                        $userManager = new UserManager;
                        $newUser = $userManager->add($new);
                        $this->redirectTo("security", "login"); exit;
                    }else
                    {
                        echo "Une erreur est survenue ! ";
                    }
                }
            }else
            {
                echo "Veuillez ressaisir vos informations";
            }
        }

        return [
            "view" => VIEW_DIR."forum/register.php",
            "meta_description" => "formulaire d'inscription",
        ];
    }
    public function login () 
    {
        if(isset($_POST['submit']))
        {
            DAO::connect();

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($email && $password)
            {
                $userManager = new UserManager;
                $user = $userManager->findUserByEmail($email);
                
                
                
                if($user)
                {
                    $hash = $user->getMotDePasse();
                    // vérification correspondance mot de passe   
                    if(password_verify($password, $hash))
                    {

                        $session = new Session;
                        $user = $session->setUser($user);
                        // var_dump($user); exit;
                        return [
                            "view" => VIEW_DIR."home.php",
                            "meta_description" => "page d'accueil",
                        ];

                    }
                }
            }
        }
        return [
            "view" => VIEW_DIR."forum/login.php",
            "meta_description" => "formulaire d'inscription",
        ];
    }



    public function logout () 
    {
        unset($_SESSION["user"]);

        return [
            "view" => VIEW_DIR."forum/login.php",
            "meta_description" => "formulaire d'inscription",
        ];

    }

    public function lockTopic($id) {
        //var_dump($id);die;
        $topicManager = new TopicManager();
        $topicManager->reqLockTopic($id);
        $this->redirectTo("view", "home");
    }

    public function unlockTopic($id) {
        $topicManager = new TopicManager();
        $topicManager->reqUnlockTopic($id);
        $this->redirectTo("view", "home");

    }

    public function profil($id){
        $userManager = new UserManager();
        $postManager = new PostManager();
        $posts = $postManager->listPostsByUser($id);
        $user = $userManager->findOneById($id);

        return [
            "view" => VIEW_DIR . "forum/profile.php",
            "meta_description" => "page profil",
            "data" => [
                "user" => $user,
                "posts" => $posts
                ]];
    }
}