<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
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

    public function addPost()
    {
        $postManager = new PostManager();

        // methode de requete pour savoir comment la page a été accédée === on s'assure que c'est bien une méthode post
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // var_dump($_POST); exit;

            $text = filter_input(INPUT_POST, 'text',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $topic = $_POST['topic_id']; // récupère l'id du topic qui vient du formulaire

            // utilisation méthode add de Manager.php pour rajouter le nouveau post saisie
            $postManager->add(["text" => $text, "topic_id" => $topic, "user_id" => $_SESSION['user']->getId()]);

            // redirection vers la liste des posts
            $this->redirectTo("forum", "listPostsByTopic", $topic);

        }
    }

    public function addTopic()
    {
        $topicManager = new TopicManager();

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $category = $_POST['category_id'];

            $topicManager->add(["title" => $title, "category_id" => $category, "user_id" => $_SESSION['user']->getId()]);

            $this->redirectTo("forum", "listTopicsByCategory", $category);
        }
    }

    public function deletePost()
    {
        $postManager = new PostManager();
        $postManager->deleteById($id)
    }

}