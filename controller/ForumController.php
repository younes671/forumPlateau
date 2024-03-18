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

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["title", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    public function listAccueil() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["title", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Liste des catégories du forum pour l'accueil",
            "data" => [
                "categorys" => $categories
            ]
        ];
    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        
        return [ 
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }


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
           
         

            // utilisation méthode add de Manager.php pour rajouter le nouveau post saisie
            $postManager->add(["text" => $text, "topic_id" => $id, "user_id" => $_SESSION['user']->getId()]);

            // redirection vers la liste des posts
            $this->redirectTo("forum", "listPostsByTopic", $id);

        }
    }

    public function addTopic($id)
    {
        $topicManager = new TopicManager();

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $text = filter_input(INPUT_POST, 'text',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($title && $text)
            {
                $topic = $topicManager->add(["title" => $title, "category_id" => $id, "closed" => 0, "user_id" => $_SESSION['user']->getId()]);
    
    
                $postManager = new PostManager();
    
                // utilisation méthode add de Manager.php pour rajouter le nouveau post saisie
                $postManager->add(["text" => $text, "topic_id" => $topic, "user_id" => $_SESSION['user']->getId()]);
    
                
                $this->redirectTo("forum", "listTopicsByCategory", $id);

            }
        }
    }

    public function deletePostById($id)
    {   
        $postManager = new PostManager();
        $post = $postManager->findOneById($id);
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
       
       

            if($post) // vérifie si post existe
            {
                
                
               
                var_dump($topic); exit;
                $postManager->delete($id);
            }
            $this->redirectTo("forum", "listPostsByTopic", $post);
            
    }

    public function deleteTopicById($id)
    { 
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
            if($topic) // vérifie si topic existe
            {
                $postManager = new PostManager();
                $postManager->deletePostByTopic($id);
                $topicManager = new TopicManager();
                $topicManager->delete($id);
                $this->redirectTo("forum", "listTopicsByCategory", $category);
            }
    }

    public function deleteUserById($id)
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

            $postManager->anonymizePost($id);
            // Anonymiser les topics associés à l'utilisateur
            $topicManager->anonymizeTopic($id);
    
            // Enfin, supprimer l'utilisateur lui-même
            $userManager->delete($id);
            
            $this->redirectTo("forum", "index");
        }
    }

    public function updateTopicById($id)
    {
        
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->findAll();
        $topic = $topicManager->findOneById($id);

        if(isset($_POST['submit']))
        {  
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           

            if($title && $category)
            {
                $topicInfo = [  
                    'id_topic' => $id,
                    'title' => $title, 
                    'category' => $category
                ];

                $topicManager->updateTopic($topicInfo);
                $this->redirectTo("forum", "listTopicsByCategory", $topic->getCategory()->getId());
            }

        }
        return [
            "view" => VIEW_DIR."forum/editTopic.php",
            "meta_description" => "formulaire de modification : " . $topic,
            "data" => [
                "topics" => $topic,
                "categories" => $categories
                
            ]
        ];

    }

    public function updatePostById($id)
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
                $this->redirectTo("forum", "listTopicByCategory", $post->getId());
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

    public function reglement()
    {
        return [
            "view" => VIEW_DIR."forum/reglement.php",
            "meta_description" => "règlement du site"
        ];
    }

    public function mention()
    {
        return [
            "view" => VIEW_DIR."forum/mentionLegale.php",
            "meta_description" => "règlement du site"
        ];
    }

}