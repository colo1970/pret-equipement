<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PretRepository;
use App\Controller\AdherentController;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PretRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *         "post_pret"={
 *              "method"="POST",
 *              "path"="/pret/equipement/new",
 *         }
 *     },
 *     itemOperations={
 *         "get_item_pret"={
 *              "method"="GET",
 *              "path"="/pret/equipement/{id}",
 *              "security"="(is_granted('ROLE_ADHERENT') and object.getAdherent()==user) or is_granted('ROLE_MANAGER')",
 *              "security_message"="Vous ne pouvez pas consulter"
 *         },
 *       
 *     }
 * )
 */
class Pret
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get_col_pret"})
     */
    private $datePret;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRetourPrevu;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRetourReelle;

    /**
     * @ORM\ManyToOne(targetEntity=Adherent::class, inversedBy="prets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    /**
     * @ORM\ManyToOne(targetEntity=Equipement::class, inversedBy="prets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipement;

    public function __construct()
    {
        $this->datePret = new \DateTimeImmutable();
        $this->dateRetourPrevu = $this->datePret->modify('+21 day');
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePret(): ?\DateTimeInterface
    {
        return $this->datePret;
    }

    public function setDatePret(\DateTimeInterface $datePret): self
    {
        $this->datePret = $datePret;

        return $this;
    }

    public function getDateRetourPrevu(): ?\DateTimeInterface
    {
        return $this->dateRetourPrevu;
    }

    public function setDateRetourPrevu(\DateTimeInterface $dateRetourPrevu): self
    {
        $this->dateRetourPrevu = $dateRetourPrevu;

        return $this;
    }

    public function getDateRetourReelle(): ?\DateTimeInterface
    {
        return $this->dateRetourReelle;
    }

    public function setDateRetourReelle(?\DateTimeInterface $dateRetourReelle): self
    {
        $this->dateRetourReelle = $dateRetourReelle;

        return $this;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherent $adherent): self
    {
        $this->adherent = $adherent;

        return $this;
    }

    public function getEquipement(): ?Equipement
    {
        return $this->equipement;
    }

    public function setEquipement(?Equipement $equipement): self
    {
        $this->equipement = $equipement;

        return $this;
    }
}
