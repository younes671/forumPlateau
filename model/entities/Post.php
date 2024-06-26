<?php
namespace Model\Entities;

use App\Entity;
use DateTime;

final class Post extends Entity
{
    private $id;
    private $text;
    private $dateCreation;
    private $topic;
    private $user;

    public function __construct($data){         
        $this->hydrate($data);        
    }

    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setId($idPost)
    {
        return $this->id = $idPost;
    }

    public function setTopic($topic)
    {
        return $this->topic = $topic;
    }

    public function setUser($user)
    {
        return $this->user = $user;
    }

    public function getDateCreation()
    {
        $date = $this->dateCreation->format("d-m-Y à H:i");
       return $date;
    }

    public function setText($text)
    {
        return $this->text = $text;
    }

    public function setDateCreation($dateCreation)
    {
        return $this->dateCreation = new DateTime($dateCreation);
    }

    public function __toString(){
        return $this->text;
    }
}