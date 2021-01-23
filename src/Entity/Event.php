<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $datePicked;

    /**
     * @ORM\Column(type="string")
     */
    private $timePicked;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbMaxPlayers;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="events")
     */
    private $participant;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="organizedEvents")
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function __construct()
    {
        $this->participant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDatePicked():?string
    {
        return $this->datePicked;
    }

    public function setDatePicked(string $datePicked): self
    {
        $this->datePicked = $datePicked;

        return $this;
    }

    public function getTimePicked(): ?string
    {
        return $this->timePicked;
    }

    public function setTimePicked(string $timePicked): self
    {
        $this->timePicked = $timePicked;

        return $this;
    }

    public function getNbMaxPlayers(): ?int
    {
        return $this->nbMaxPlayers;
    }

    public function setNbMaxPlayers(int $nbMaxPlayers): self
    {
        $this->nbMaxPlayers = $nbMaxPlayers;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getParticipant(): Collection
    {
        return $this->participant;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->participant->contains($participant)) {
            $this->participant[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        $this->participant->removeElement($participant);

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
