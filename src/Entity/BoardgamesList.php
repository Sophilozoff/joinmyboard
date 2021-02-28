<?php

namespace App\Entity;

use App\Repository\BoardgamesListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoardgamesListRepository::class)
 */
class BoardgamesList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="boardgamesList", cascade={"persist", "remove"})
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=Boardgame::class, inversedBy="boardgamesLists")
     */
    private $boardgames;

    public function __construct()
    {
        $this->boardgames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Boardgame[]
     */
    public function getBoardgames(): Collection
    {
        return $this->boardgames;
    }

    public function addBoardgame(Boardgame $boardgame): self
    {
        if (!$this->boardgames->contains($boardgame)) {
            $this->boardgames[] = $boardgame;
        }

        return $this;
    }

    public function removeBoardgame(Boardgame $boardgame): self
    {
        $this->boardgames->removeElement($boardgame);

        return $this;
    }
}
