<?php

namespace App\Entity;

use App\Repository\ContentStaticRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContentStaticRepository::class)
 */
class ContentStatic
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
    private $createdBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=800, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $contact;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContact(): ?bool
    {
        return $this->contact;
    }

    public function setContact(?bool $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
