<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use App\DAO;
use Model\Managers\CategoryManager;
use Model\Managers\PostManager;
use Model\Managers\TopicManager;
use Model\Managers\UserManager;

class UserController extends AbstractController implements ControllerInterface
{
    public function index()
    {
        
    }

    // supprime utilisateur
    public function deleteUserById($id)
    { 
        if(Session::isAdmin())
        {
        $userManager = new UserManager();
        $user = $userManager->findOneById($id);
    
        if($user) {
            $postManager = new PostManager();
            $topicManager = new TopicManager();
    
            // Mettre à jour les posts associés à l'utilisateur
            $postManager->updatePostsUserId($id);
    
            // Mettre à jour les topics associés à l'utilisateur
            $topicManager->updateTopicsUserId($id);
    
            // Enfin, supprimer l'utilisateur lui-même
            $userManager->delete($id);
            
            $this->redirectTo("user", "profil", $id);
        }
    }
    }

    // affiche profil utilisateur
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
