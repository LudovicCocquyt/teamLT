<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImagesRepository")
 */
class Images
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="images")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jeux", inversedBy="images")
     */
    private $jeux;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lineup", inversedBy="images")
     */
    private $lineup;

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

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getJeux(): ?Jeux
    {
        return $this->jeux;
    }

    public function setJeux(?Jeux $jeux): self
    {
        $this->jeux = $jeux;

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
}
