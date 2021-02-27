<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "Le pseudo doit contenir au minimum {{ limit }} caractères",
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Le mot de passe doit contenir au minimum {{ limit }} caractères",
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string")
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
    * @Vich\UploadableField(mapping="avatar", fileNameProperty="avatar")
    *
    */
    private $avatarFile;

    /**
    * @ORM\Column(type="datetime")
    *
    * @var \DateTimeInterface|null
    */
    private $updatedAt;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\Email(
     *     message = "L'adresse email'{{ value }}' n'est pas correcte."
     * )
     * Assert\NotBlank
     * @Assert\Length(
     *      min = 50,
     *      max = 50,
     *      minMessage = "La description doit contenir au minimum 50 caractères",
     *      maxMessage = "La description ne peiut pas contenir plus de 500 caractères"
     * )
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="subscriber")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="author")
     */
    private $organizedEvents;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sex;

    /**
     * @ORM\OneToOne(targetEntity=BoardgamesList::class, mappedBy="author", cascade={"persist", "remove"})
     */
    private $boardgamesList;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="friendsWithMe")
     * @ORM\JoinTable(name="friends",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_user_id", referencedColumnName="id")}
     *      )
     */
    private $friends;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="friends")
     */
    private $friendsWithMe;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->organizedEvents = new ArrayCollection();
        $this->friendsWithMe = new ArrayCollection();
        $this->friends = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->username;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?string $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    public function setAvatarFile(?File $file): self
    {
        $this->avatarFile = $file;
        if($file !==null){
            $this->updatedAt = new \DateTimeImmutable;
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addSubscriber($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeSubscriber($this);
        }
        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getOrganizedEvents(): Collection
    {
        return $this->organizedEvents;
    }

    public function addOrganizedEvent(Event $organizedEvent): self
    {
        if (!$this->organizedEvents->contains($organizedEvent)) {
            $this->organizedEvents[] = $organizedEvent;
            $organizedEvent->setAuthor($this);
        }
        return $this;
    }

    public function removeOrganizedEvent(Event $organizedEvent): self
    {
        if ($this->organizedEvents->removeElement($organizedEvent)) {
            // set the owning side to null (unless already changed)
            if ($organizedEvent->getAuthor() === $this) {
                $organizedEvent->setAuthor(null);
            }
        }

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getBoardgamesList(): ?BoardgamesList
    {
        return $this->boardgamesList;
    }

    public function setBoardgamesList(?BoardgamesList $boardgamesList): self
    {
        // unset the owning side of the relation if necessary
        if ($boardgamesList === null && $this->boardgamesList !== null) {
            $this->boardgamesList->setAuthor(null);
        }

        // set the owning side of the relation if necessary
        if ($boardgamesList !== null && $boardgamesList->getAuthor() !== $this) {
            $boardgamesList->setAuthor($this);
        }

        $this->boardgamesList = $boardgamesList;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFriends(): Collection
    {
        return $this->friends;
    }

    public function addFriend(self $friend): self
    {
        if (!$this->friends->contains($friend)) {
            $this->friends[] = $friend;
        }

        return $this;
    }

    public function removeFriend(self $friend): self
    {
        $this->friends->removeElement($friend);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFriendsWithMe(): Collection
    {
        return $this->friendsWithMe;
    }

    public function addFriendsWithMe(self $friendsWithMe): self
    {
        if (!$this->friendsWithMe->contains($friendsWithMe)) {
            $this->friendsWithMe[] = $friendsWithMe;
            $friendsWithMe->addFriend($this);
        }

        return $this;
    }

    public function removeFriendsWithMe(self $friendsWithMe): self
    {
        if ($this->friendsWithMe->removeElement($friendsWithMe)) {
            $friendsWithMe->removeFriend($this);
        }

        return $this;
    }


}
