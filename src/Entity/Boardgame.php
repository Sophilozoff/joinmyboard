<?php

namespace App\Entity;

use App\Repository\BoardgameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoardgameRepository::class)
 */
class Boardgame
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPlayersMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPlayersMax;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $playingTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNbPlayersMin(): ?int
    {
        return $this->nbPlayersMin;
    }

    public function setNbPlayersMin(?int $nbPlayersMin): self
    {
        $this->nbPlayersMin = $nbPlayersMin;

        return $this;
    }

    public function getNbPlayersMax(): ?int
    {
        return $this->nbPlayersMax;
    }

    public function setNbPlayersMax(?int $nbPlayersMax): self
    {
        $this->nbPlayersMax = $nbPlayersMax;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPlayingTime(): ?int
    {
        return $this->playingTime;
    }

    public function setPlayingTime(?int $playingTime): self
    {
        $this->playingTime = $playingTime;

        return $this;
    }
}
