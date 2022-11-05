<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FabricantRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=FabricantRepository::class)
 */
class Fabricant
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
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Equipement::class, mappedBy="fabricant")
     */
    private $equipements;

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
            $equipement->setFabricant($this);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        if ($this->equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getFabricant() === $this) {
                $equipement->setFabricant(null);
            }
        }

        return $this;
    }
}
