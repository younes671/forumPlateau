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

class PostController extends AbstractController implements ControllerInterface
{
    public function index()
    {
        
    }

    // permet de récupérer la liste des post par topic

    public function listPostsByTopic($id)
    {
        $topicManager = new TopicManager();
        $postManager = new PostManager();
        $topic = $topicManager->findOneById($id);
        $posts = $postManager->findPostsByTopic($id);
        return [
            "view" => VIEW_DIR . "forum/listPosts.php",
            "meta_description" => "Liste des posts par topic : " . $topic,
            "data" => [
                "topic" => $topic,
                "posts" => $posts
            ]
            ];
    }

    // ajouter post à la discussion

    public function addPost($id)
    {
        $postManager = new PostManager();

        // methode de requete pour savoir comment la page a été accédée === on s'assure que c'est bien une méthode post
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // récupère le post saisie
            $text = filter_input(INPUT_POST, 'text',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           
            if($text)
            {
                // utilisation méthode add de Manager.php pour rajouter le nouveau post saisie
                $postManager->add(["text" => $text, "topic_id" => $id, "user_id" => $_SESSION['user']->getId()]);
        
                // redirection vers la liste des posts
                $this->redirectTo("post", "listPostsByTopic", $id);
            }
        }
    }

    // permet de supprimer post par id

    public function deletePostById($id)
    {   
        if(Session::getUser()->getId() || Session::isAdmin())
        {
        $postManager = new PostManager();
        $post = $postManager->findOneById($id);
        $topic = $post->getTopic()->getId();
       
            if($post) // vérifie si post existe
            {
                // var_dump($topic); exit;
                $postManager->delete($id);
            }
            $this->redirectTo("post", "listPostsByTopic", $topic);        
    }
    }

    // permet de mettre à jour un post

    public function updatePostById($id)
    {
        if(Session::getUser()->getId() || Session::isAdmin())
        {
        $postManager = new PostManager();
        $post = $postManager->findOneById($id); // récupère un post par son id

        if(isset($_POST['submit']))
        {  
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
           

            if($text)      
            { 
                $postInfo = [  
                    'id_post' => $id,
                    'text' => $text,
                    'topic_id' => $post->getTopic()
                ];
                $postManager->updatePost($postInfo);
                // var_dump($postManager->updatePost($postInfo)); exit;
                $this->redirectTo("post", "listPostsByTopic", $post->getTopic()->getId());
            }

            }
            return [
                "view" => VIEW_DIR."forum/editPost.php",
                "meta_description" => "formulaire de modification : " . $post,
                "data" => [
                    "post" => $post,
                    
                ]
            ];

        }
    }
    
}
