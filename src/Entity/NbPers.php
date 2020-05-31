<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NbPersRepository")
 */
class NbPers
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $nb;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Recette", mappedBy="nbPers")
     */
    private $Recette;

    public function __construct()
    {
        $this->Recette = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNb(): ?string
    {
        return $this->nb;
    }

    public function setNb(string $nb): self
    {
        $this->nb = $nb;

        return $this;
    }

    /**
     * @return Collection|Recette[]
     */
    public function getRecette(): Collection
    {
        return $this->Recette;
    }

    public function addRecette(Recette $recette): self
    {
        if (!$this->Recette->contains($recette)) {
            $this->Recette[] = $recette;
            $recette->setNbPers($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): self
    {
        if ($this->Recette->contains($recette)) {
            $this->Recette->removeElement($recette);
            // set the owning side to null (unless already changed)
            if ($recette->getNbPers() === $this) {
                $recette->setNbPers(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nb;
    }
}
