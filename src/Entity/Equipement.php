<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EquipementRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EquipementRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *           "get_equipement"={
 *               "path"="/equipements",
 *               "method"="GET",
 *               "security"="is_granted('ROLE_ADHERENT')",
 *               "security_message"="Vous n'avez pas droit de modifier",
 *               "normalization_context"={"groups"={"get_adherent"}}
 *            },
 *            "post_equipement"={
 *               "path"="/equipement/new",
 *               "method"="POST",
 *               "security"="is_granted('ROLE_MANAGER')",
 *               "security_message"="Vous n'avez pas droit d'ajouté",
 *            }
 *      },
 *     itemOperations={
 *         "get_equipement_item"={
 *         "path"="/equipement/{id}",
 *         "method"="GET",
 *         "normalization_context"={"groups"={"get_adherent"}}
 *         },
 *         "put_equipement"={
 *               "path"="/equipement/edit/{id}",
 *               "method"="PUT",
 *               "denormalization_context"={"groups"={"put_manager"}},
 *               "security"="is_granted('ROLE_MANAGER')",
 *               "security_message"="Vous n'avez pas droit de modifié"
 *           },
 *         "delete_equipement"={
 *               "path"="/equipement/delete/{id}",
 *               "method"="DELETE",
 *               "security"="is_granted('ROLE_ADMIN')",
 *               "security_message"="Vous n'avez pas droit de supprimé"
 *           }
 *    }
 * )
 */
class Equipement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_adherent", "put_manager"})
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get_adherent", "put_manager"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="float")
     * @Groups({"get_manager", "get_put_admin"})
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="equipements")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get_adherent", "put_manager"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Fabricant::class, inversedBy="equipements")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get_adherent", "put_manager"})
     */
    private $fabricant;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"get_adherent", "put_manager"})
     */
    private $annneeFabrication;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"get_adherent", "put_manager"})
     */
    private $disponibilite;

    /**
     * @ORM\OneToMany(targetEntity=Pret::class, mappedBy="equipement")
     */
    private $prets;

    public function __construct()
    {
        $this->prets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFabricant(): ?Fabricant
    {
        return $this->fabricant;
    }

    public function setFabricant(?Fabricant $fabricant): self
    {
        $this->fabricant = $fabricant;

        return $this;
    }

    public function getAnnneeFabrication(): ?\DateTimeInterface
    {
        return $this->annneeFabrication;
    }

    public function setAnnneeFabrication(?\DateTimeInterface $annneeFabrication): self
    {
        $this->annneeFabrication = $annneeFabrication;

        return $this;
    }

    public function isDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    /**
     * @return Collection<int, Pret>
     */
    public function getPrets(): Collection
    {
        return $this->prets;
    }

    public function addPret(Pret $pret): self
    {
        if (!$this->prets->contains($pret)) {
            $this->prets[] = $pret;
            $pret->setEquipement($this);
        }

        return $this;
    }

    public function removePret(Pret $pret): self
    {
        if ($this->prets->removeElement($pret)) {
            // set the owning side to null (unless already changed)
            if ($pret->getEquipement() === $this) {
                $pret->setEquipement(null);
            }
        }

        return $this;
    }
}
