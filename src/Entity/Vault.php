<?php

namespace App\Entity;

use App\Repository\VaultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VaultRepository::class)
 */
class Vault
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="vaults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Login::class, mappedBy="vault")
     */
    private $logins;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="vault")
     */
    private $notes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $data;

    public function __construct()
    {
        $this->logins = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return Collection|Login[]
     */
    public function getLogins(): Collection
    {
        return $this->logins;
    }

    public function addLogin(Login $login): self
    {
        if (!$this->logins->contains($login)) {
            $this->logins[] = $login;
            $login->setVault($this);
        }

        return $this;
    }

    public function removeLogin(Login $login): self
    {
        if ($this->logins->removeElement($login)) {
            // set the owning side to null (unless already changed)
            if ($login->getVault() === $this) {
                $login->setVault(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setVault($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getVault() === $this) {
                $note->setVault(null);
            }
        }

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }
}
