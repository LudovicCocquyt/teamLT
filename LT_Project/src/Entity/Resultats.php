<?php

namespace App\Entity;

use App\Repository\ResultatsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResultatsRepository::class)
 */
class Resultats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CreatedBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mapOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mapTwo;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreOne;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $teamAdverse;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreTwo;

    /**
     * @ORM\ManyToOne(targetEntity=Lineup::class, inversedBy="resultats")
     */
    private $lineup;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, inversedBy="resultats")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Jeux::class, inversedBy="resultats")
     */
    private $jeu;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(string $CreatedBy): self
    {
        $this->CreatedBy = $CreatedBy;

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

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(string $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMapOne(): ?string
    {
        return $this->mapOne;
    }

    public function setMapOne(?string $mapOne): self
    {
        $this->mapOne = $mapOne;

        return $this;
    }

    public function getMapTwo(): ?string
    {
        return $this->mapTwo;
    }

    public function setMapTwo(?string $mapTwo): self
    {
        $this->mapTwo = $mapTwo;

        return $this;
    }

    public function getScoreOne(): ?int
    {
        return $this->scoreOne;
    }

    public function setScoreOne(int $scoreOne): self
    {
        $this->scoreOne = $scoreOne;

        return $this;
    }

    public function getTeamAdverse(): ?string
    {
        return $this->teamAdverse;
    }

    public function setTeamAdverse(string $teamAdverse): self
    {
        $this->teamAdverse = $teamAdverse;

        return $this;
    }

    public function getScoreTwo(): ?int
    {
        return $this->scoreTwo;
    }

    public function setScoreTwo(int $scoreTwo): self
    {
        $this->scoreTwo = $scoreTwo;

        return $this;
    }

    public function getLineup(): ?Lineup
    {
        return $this->lineup;
    }

    public function setLineup(?Lineup $lineup): self
    {
        $this->lineup = $lineup;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Users $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
        }

        return $this;
    }

    public function getJeu(): ?Jeux
    {
        return $this->jeu;
    }

    public function setJeu(?Jeux $jeu): self
    {
        $this->jeu = $jeu;

        return $this;
    }
}
