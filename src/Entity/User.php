<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;
    
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $regDate;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleName;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Word", mappedBy="user")
     */
    private $words;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WordList", mappedBy="user")
     */
    private $wordLists;
    
    public function __construct()
    {
        $this->words = new ArrayCollection();
        $this->wordLists = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
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
        return (string)$this->password;
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
    
    public function getRegDate(): ?\DateTimeInterface
    {
        return $this->regDate;
    }
    
    public function setRegDate(\DateTimeInterface $regDate): self
    {
        $this->regDate = $regDate;
        
        return $this;
    }
    
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        
        return $this;
    }
    
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }
    
    public function setMiddleName(?string $middleName): self
    {
        $this->middleName = $middleName;
        
        return $this;
    }
    
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        
        return $this;
    }
    
    /**
     * @return Collection|Word[]
     */
    public function getWords(): Collection
    {
        return $this->words;
    }
    
    public function addWord(Word $word): self
    {
        if (!$this->words->contains($word)) {
            $this->words[] = $word;
            $word->setUser($this);
        }
        
        return $this;
    }
    
    public function removeWord(Word $word): self
    {
        if ($this->words->contains($word)) {
            $this->words->removeElement($word);
            // set the owning side to null (unless already changed)
            if ($word->getUser() === $this) {
                $word->setUser(null);
            }
        }
        
        return $this;
    }
    
    /**
     * @return Collection|WordList[]
     */
    public function getWordLists(): Collection
    {
        return $this->wordLists;
    }
    
    public function addWordList(WordList $wordList): self
    {
        if (!$this->wordLists->contains($wordList)) {
            $this->wordLists[] = $wordList;
            $wordList->setUser($this);
        }
        
        return $this;
    }
    
    public function removeWordList(WordList $wordList): self
    {
        if ($this->wordLists->contains($wordList)) {
            $this->wordLists->removeElement($wordList);
            // set the owning side to null (unless already changed)
            if ($wordList->getUser() === $this) {
                $wordList->setUser(null);
            }
        }
        
        return $this;
    }
}
