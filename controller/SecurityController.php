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

    // méthode pour l'inscription

    public function register ($id) {
        if(isset($_POST['submit']))
        {
            DAO::connect();

            // filtre les données saisie 
            $userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $pass1 = filter_input(INPUT_POST, 'pass1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, 'pass2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // preg_match permet de rechercher des caractères dans une chaine longueur etc... regex
            if (!preg_match("/^(?=.*[!@#$%^&*()\[\]{};:<>|.\/?])(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{12,}$/", $pass1)){
                echo "Le mot de passe doit contenir au moins un caractère spécial, une majuscule, une minuscule, un chiffre et avoir une longueur d'au moins 12 caractères.";
                $this->redirectTo("security","register");
             }

             // vérification données reçu via formulaire si filtre ok
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

    // méthode pour la connexion
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
                        $this->redirectTo("category", "index"); exit;

                    }
                }
            }
        }
        return [
            "view" => VIEW_DIR."forum/login.php",
            "meta_description" => "formulaire d'inscription",
        ];
    }

    // méthode pour la deconnexion

    public function logout () 
    {
        unset($_SESSION["user"]);

        $this->redirectTo("security", "login");

    }

    // affiche reglement du forum
    
    public function reglement()
    {
        return [
            "view" => VIEW_DIR."forum/reglement.php",
            "meta_description" => "règlement du site"
        ];
    }

    // affiche les mentions légale

    public function mention()
    {
        return [
            "view" => VIEW_DIR."forum/mentionLegale.php",
            "meta_description" => "règlement du site"
        ];
    }
}