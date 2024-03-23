<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class PostManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Post";
    protected $tableName = "post";

    public function __construct(){
        parent::connect();
    }

    // permet de récupérer la liste des posts par topic

    public function findPostsByTopic($id) {

        $sql = "SELECT *
                FROM ". $this->tableName . " p
                WHERE p.topic_id = :id
                ORDER BY dateCreation DESC";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    // permet de mettre à jour un post par l'id utilisateur
    public function updatePostsUserId($userId)
    {
        $sql = "UPDATE ".$this->tableName." SET user_id = NULL WHERE user_id = :userId";
        DAO::update($sql, ['userId' => $userId]);
    }

    // permet de supprimer un post

    public function deletePostByTopic($id)
    {
        $sql = "DELETE FROM ". $this->tableName . "
                WHERE topic_id = :topic_id";
        DAO::delete($sql, ['topic_id' => $id]);
    }

    // permet de mettre à jour un post
    public function updatePost($array)
    {
        $sql = "UPDATE ". $this->tableName . " 
                SET text = :text
                WHERE id_post = :id_post" ;
        return DAO::update($sql, 
        [  'id_post' => $array['id_post'], 
            'text' => $array['text'],
          ]);
    }

    // permet de récupérer la liste des post par utilisateur
    public function listPostsByUser($id) {

        $sql = "SELECT * 
        FROM ".$this->tableName." 
        WHERE user_id = :id";
       
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
        
    }
}