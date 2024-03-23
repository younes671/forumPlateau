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

class TopicController extends AbstractController implements ControllerInterface
{
        public function index()
        {
            
        }

    // permet de récupérer la liste des topics par categories
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

        // ajoute topic
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
        
                    
                    $this->redirectTo("topic", "listTopicsByCategory", $id);
    
                }
            }
        }

        // supprime topic
        public function deleteTopicById($id)
        { 
           
                $topicManager = new TopicManager();
                $topic = $topicManager->findOneById($id);
                $categoryId = $topic->getCategory()->getId();
                $categoryManager = new CategoryManager();
                $category = $categoryManager->findOneById($id);
                if(Session::getUser()->getId() || Session::isAdmin())
                {
                    if($topic) // vérifie si topic existe
                    {
                        $postManager = new PostManager();
                        $postManager->deletePostByTopic($id);
                        $topicManager = new TopicManager();
                        $topicManager->delete($id);
                        $this->redirectTo("topic", "listTopicsByCategory", $categoryId);
                    }
                }else
                {
                    echo "Vous n'etes pas autorisé à y accéder ! ";
                }
            }

            // met à jour topic
            public function updateTopicById($id)
            {
                if(Session::getUser()->getId() || Session::isAdmin())
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
                        $this->redirectTo("topic", "listTopicsByCategory", $topic->getCategory()->getId());
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
        }

        // verrouille topic
        public function lockTopic($id) {
            //var_dump($id);die;
            $topicManager = new TopicManager();
            $topic = $topicManager->findOneById($id);
            $topicId = $topic->getCategory()->getId();
            $topicManager->reqLockTopic($id);
            $this->redirectTo("topic", "listTopicsByCategory", $topicId);
        }
    
        // déverrouille topic
        public function unlockTopic($id) {
            $topicManager = new TopicManager();
            $topic = $topicManager->findOneById($id);
            $topicId = $topic->getCategory()->getId();
            $topicManager->reqUnlockTopic($id);
            $this->redirectTo("topic", "listTopicsByCategory", $topicId);
    
        }
    
        
    
        
}