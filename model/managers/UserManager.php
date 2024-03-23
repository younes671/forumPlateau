<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct(){
        parent::connect();
    }

    // permet de récupérer la liste des utilisateurs par id
    public function findUserById($id) {

        $sql = "SELECT * 
                FROM ".$this->tableName."  
                WHERE id_user = :id";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id], false), 
            $this->className
        );
    }

    

    // méthode finduserbyemail retourne l'email de l'utilisateur

    // permet de récupérer la liste des utilisateurs par email
    public function findUserByEmail($email)
    {
        $sql = "SELECT * 
        FROM ".$this->tableName."  
        WHERE email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false), 
            $this->className
        );
    }

    // permet de récupérer le mot de passe utilisateur
    public function findUserPassword($pass)
    {
        $sql = "SELECT * 
        FROM ".$this->tableName."  
        WHERE email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $pass], false), 
            $this->className
        );
    }

    
}
