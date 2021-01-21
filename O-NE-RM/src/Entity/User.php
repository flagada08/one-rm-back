<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("test")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups("test")
     * @Groups("infos")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("test")
     * @Groups("infos")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups("test")
     * @Groups("infos")
     */
    private $lastname;

    /**
     * @ORM\Column(type="integer")
     * @Groups("test")
     * @Groups("infos")
     */
    private $age;

    /**
     * @ORM\Column(type="string")
     * @Groups("infos")
     * 
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     * @Groups("infos")
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity=FitnessRoom::class, inversedBy="users")
     * @Groups("test")
     * @Groups("infos")
     */
    private $fitnessRoom;

    /**
     * @ORM\OneToMany(targetEntity=Goal::class, mappedBy="user", orphanRemoval=true)
     */
    private $goals;

    /**
     * @ORM\OneToMany(targetEntity=Progress::class, mappedBy="user", orphanRemoval=true)
     */
    private $progress;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user", orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->goals = new ArrayCollection();
        $this->progress = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getFitnessRoom(): ?FitnessRoom
    {
        return $this->fitnessRoom;
    }

    public function setFitnessRoom(?FitnessRoom $fitnessRoom): self
    {
        $this->fitnessRoom = $fitnessRoom;

        return $this;
    }

    /**
     * @return Collection|Goal[]
     */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function addGoal(Goal $goal): self
    {
        if (!$this->goals->contains($goal)) {
            $this->goals[] = $goal;
            $goal->setUser($this);
        }

        return $this;
    }

    public function removeGoal(Goal $goal): self
    {
        if ($this->goals->removeElement($goal)) {
            // set the owning side to null (unless already changed)
            if ($goal->getUser() === $this) {
                $goal->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Progress[]
     */
    public function getProgress(): Collection
    {
        return $this->progress;
    }

    public function addProgress(Progress $progress): self
    {
        if (!$this->progress->contains($progress)) {
            $this->progress[] = $progress;
            $progress->setUser($this);
        }

        return $this;
    }

    public function removeProgress(Progress $progress): self
    {
        if ($this->progress->removeElement($progress)) {
            // set the owning side to null (unless already changed)
            if ($progress->getUser() === $this) {
                $progress->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }
}
