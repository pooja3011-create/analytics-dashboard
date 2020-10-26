<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="review") 
     * @ORM\JoinColumn(nullable=false) 
     */
    private $hotel;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $score;
    /**
     * @ORM\Column(type="string", length=500)
     */
    private $comment;
    
    /**
     * @ORM\Column(type="string")
     */
    private $created_date;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getScore() 
    {
        return $this->score;
    }
   
    public function getComment() 
    {
        return $this->comment;
    }
    
    public function setScore($score): void 
    {
        $this->score = $score;
    }
    
    public function setComment($comment): void 
    {
        $this->comment = $comment;
    }
    
    public function getHotel() 
    {
        return $this->hotel;
    }
 
    public function setHotel($hotel): void 
    {
        $this->hotel = $hotel;
    }
    
    public function getCreated_date() 
    {
        return $this->created_date;
    }
    
    public function setCreated_date($created_date): void 
    {
        $this->created_date = $created_date;
    }

}
