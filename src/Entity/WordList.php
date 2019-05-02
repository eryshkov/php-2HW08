<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WordListRepository")
 */
class WordList
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastAccessDate;

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

    public function getLastAccessDate(): ?\DateTimeInterface
    {
        return $this->lastAccessDate;
    }

    public function setLastAccessDate(?\DateTimeInterface $lastAccessDate): self
    {
        $this->lastAccessDate = $lastAccessDate;

        return $this;
    }
}
