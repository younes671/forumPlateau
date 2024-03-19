<?php
namespace Model\Managers;

use Model\Entities\Topic;
use App\Manager;
use App\DAO;

class TopicManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findTopicsByCategory($id) {

        $sql = "SELECT * 
                FROM ".$this->tableName." t 
                WHERE t.category_id = :id
                ORDER BY dateCreation DESC";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    public function updateTopicsUserId($userId)
    {
        $sql = "UPDATE ".$this->tableName." SET user_id = NULL WHERE user_id = :userId";
        DAO::update($sql, ['userId' => $userId]);
    }

    public function anonymizeTopic($topicId)
    {
    $sql = "UPDATE ".$this->tableName." SET author = 'Anonyme' WHERE id = :topicId";
    DAO::update($sql, ['topicId' => $topicId]);
    }
    

    public function updateTopic($array)
    {
        $sql = "UPDATE ". $this->tableName . " 
                SET title = :title,
                category_id = :category_id
                WHERE id_topic = :id_topic" ;
        return DAO::update($sql, [
            'id_topic' => $array['id_topic'], 
            'title' => $array['title'],
            'category_id' => $array['category']
        ]);
       
    }

    public function reqLockTopic($id) {
        $sql = "UPDATE ".$this->tableName." SET closed = 1 WHERE id_topic = :id";
       
        DAO::update($sql, ['id' => $id]);

    }
    
    public function reqUnlockTopic($id) {
        $sql = "UPDATE ".$this->tableName." SET closed = 0 WHERE id_topic = :id";
        DAO::update($sql, ['id' => $id]);
    }
}