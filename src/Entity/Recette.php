<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecetteRepository")
 * @Vich\Uploadable
 */
class Recette
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $img;

    /**
     * @Vich\UploadableField(mapping="imgs", fileNameProperty="img")
     *@var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img360;

    /**
     * @ORM\Column(type="text")
     */
    private $note;

    /**
     * @ORM\Column(type="integer")
     */
    private $tpsRepos;

    /**
     * @ORM\Column(type="integer")
     */
    private $tpsPrepa;

    /**
     * @ORM\Column(type="integer")
     */
    private $tpsCuisson;

    /**
     * @ORM\Column(type="integer")
     */
    private $tpsCongel;

    /**
     * @var \DateTime $ created_at
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @var \DateTime $ updated_at
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="text")
     */
    private $process;

    /**
     * @ORM\Column(type="text")
     */
    private $ingredients;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NbPers", inversedBy="Recette")
     */
    private $nbPers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Difficulte", inversedBy="Recette")
     */
    private $difficulte;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", mappedBy="Recette")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Gout", mappedBy="Recette")
     */
    private $gouts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaires", mappedBy="recette")
     */
    private $Commentaire;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->gouts = new ArrayCollection();
        $this->Commentaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image){
            $this->updated_at = new \DateTime('now');
        }

    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getImg360(): ?string
    {
        return $this->img360;
    }

    public function setImg360(string $img360): self
    {
        $this->img360 = $img360;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getTpsRepos(): ?int
    {
        return $this->tpsRepos;
    }

    public function setTpsRepos(int $tpsRepos): self
    {
        $this->tpsRepos = $tpsRepos;

        return $this;
    }

    public function getTpsPrepa(): ?int
    {
        return $this->tpsPrepa;
    }

    public function setTpsPrepa(int $tpsPrepa): self
    {
        $this->tpsPrepa = $tpsPrepa;

        return $this;
    }

    public function getTpsCuisson(): ?int
    {
        return $this->tpsCuisson;
    }

    public function setTpsCuisson(int $tpsCuisson): self
    {
        $this->tpsCuisson = $tpsCuisson;

        return $this;
    }

    public function getTpsCongel(): ?int
    {
        return $this->tpsCongel;
    }

    public function setTpsCongel(int $tpsCongel): self
    {
        $this->tpsCongel = $tpsCongel;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function getProcess(): ?string
    {
        return $this->process;
    }

    public function setProcess(string $process): self
    {
        $this->process = $process;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getNbPers(): ?NbPers
    {
        return $this->nbPers;
    }

    public function setNbPers(?NbPers $nbPers): self
    {
        $this->nbPers = $nbPers;

        return $this;
    }

    public function getDifficulte(): ?Difficulte
    {
        return $this->difficulte;
    }

    public function setDifficulte(?Difficulte $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }
    
    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addRecette($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeRecette($this);
        }

        return $this;
    }

    /**
     * @return Collection|Gout[]
     */
    public function getGouts(): Collection
    {
        return $this->gouts;
    }

    public function addGout(Gout $gout): self
    {
        if (!$this->gouts->contains($gout)) {
            $this->gouts[] = $gout;
            $gout->addRecette($this);
        }

        return $this;
    }

    public function removeGout(Gout $gout): self
    {
        if ($this->gouts->contains($gout)) {
            $this->gouts->removeElement($gout);
            $gout->removeRecette($this);
        }

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaire(): Collection
    {
        return $this->Commentaire;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->Commentaire->contains($commentaire)) {
            $this->Commentaire[] = $commentaire;
            $commentaire->setRecette($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->Commentaire->contains($commentaire)) {
            $this->Commentaire->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getRecette() === $this) {
                $commentaire->setRecette(null);
            }
        }

        return $this;
    }
}
