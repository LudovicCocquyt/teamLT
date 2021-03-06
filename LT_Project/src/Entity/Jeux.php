<?php

namespace App\Entity;

use App\Repository\JeuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JeuxRepository::class)
 */
class Jeux
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
    private $createdBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=800, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="jeux")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=Lineup::class, mappedBy="jeux")
     */
    private $lineups;

    /**
     * @ORM\OneToMany(targetEntity=Resultats::class, mappedBy="jeu")
     */
    private $resultats;

    /**
     * @ORM\OneToMany(targetEntity=Palmares::class, mappedBy="jeux")
     */
    private $palmares;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Images", mappedBy="users",cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    public function __construct()
    {
        $this->users     = new ArrayCollection();
        $this->lineups   = new ArrayCollection();
        $this->resultats = new ArrayCollection();
        $this->palmares  = new ArrayCollection();
        $this->images    = new ArrayCollection();
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
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addJeux($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeJeux($this);
        }

        return $this;
    }

    /**
     * @return Collection|Lineup[]
     */
    public function getLineups(): Collection
    {
        return $this->lineups;
    }

    public function addLineup(Lineup $lineup): self
    {
        if (!$this->lineups->contains($lineup)) {
            $this->lineups[] = $lineup;
            $lineup->addJeux($this);
        }

        return $this;
    }

    public function removeLineup(Lineup $lineup): self
    {
        if ($this->lineups->contains($lineup)) {
            $this->lineups->removeElement($lineup);
            $lineup->removeJeux($this);
        }

        return $this;
    }

    /**
     * @return Collection|Resultats[]
     */
    public function getResultats(): Collection
    {
        return $this->resultats;
    }

    public function addResultat(Resultats $resultat): self
    {
        if (!$this->resultats->contains($resultat)) {
            $this->resultats[] = $resultat;
            $resultat->setJeu($this);
        }

        return $this;
    }

    public function removeResultat(Resultats $resultat): self
    {
        if ($this->resultats->contains($resultat)) {
            $this->resultats->removeElement($resultat);
            // set the owning side to null (unless already changed)
            if ($resultat->getJeu() === $this) {
                $resultat->setJeu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Palmares[]
     */
    public function getPalmares(): Collection
    {
        return $this->palmares;
    }

    public function addPalmare(Palmares $palmare): self
    {
        if (!$this->palmares->contains($palmare)) {
            $this->palmares[] = $palmare;
            $palmare->setJeux($this);
        }

        return $this;
    }

    public function removePalmare(Palmares $palmare): self
    {
        if ($this->palmares->contains($palmare)) {
            $this->palmares->removeElement($palmare);
            // set the owning side to null (unless already changed)
            if ($palmare->getJeux() === $this) {
                $palmare->setJeux(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setJeux($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getRealisations() === $this) {
                $image->setRealisations(null);
            }
        }

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }
}
