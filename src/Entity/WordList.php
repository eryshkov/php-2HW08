<?php

namespace App\Entity;

use App\Repository\WordListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Word", mappedBy="list", fetch="EXTRA_LAZY", orphanRemoval=true)
     */
    private $words;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="wordLists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    public function __construct()
    {
        $this->words = new ArrayCollection();
    }
    
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
    
    /**
     * @return Collection|Word[]
     */
    public function getWords(): Collection
    {
        return $this->words;
    }
    
    /**
     * @param int|null $limit
     * @param bool $randomized
     * @return Word[]
     */
    public function getWordsForTraining(int $limit = null, bool $randomized = false): array
    {
        $allWords = $this->getWords()->getValues();
    
        if ($randomized) {
            shuffle($allWords);
        }
    
        if (isset($limit)) {
            return array_slice($allWords, 0, $limit);
        } else {
            return $allWords;
        }
    }
    
    public function addWord(Word $word): self
    {
        if (!$this->words->contains($word)) {
            $this->words[] = $word;
            $word->setList($this);
        }
        
        return $this;
    }
    
    public function removeWord(Word $word): self
    {
        if ($this->words->contains($word)) {
            $this->words->removeElement($word);
            // set the owning side to null (unless already changed)
            if ($word->getList() === $this) {
                $word->setList(null);
            }
        }
        
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
    
    public function isGrantedFor(User $user): bool
    {
        return $this->getUser() === $user;
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
