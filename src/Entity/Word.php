<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WordRepository")
 */
class Word
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
    private $english;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $russian;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="words")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WordList", inversedBy="words")
     * @ORM\JoinColumn(nullable=false)
     */
    private $list;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnglish(): ?string
    {
        return $this->english;
    }

    public function setEnglish(string $english): self
    {
        $this->english = $english;

        return $this;
    }

    public function getRussian(): ?string
    {
        return $this->russian;
    }

    public function setRussian(string $russian): self
    {
        $this->russian = $russian;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getList(): ?WordList
    {
        return $this->list;
    }

    public function setList(?WordList $list): self
    {
        $this->list = $list;

        return $this;
    }
}
