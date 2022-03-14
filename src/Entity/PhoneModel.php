<?php

namespace App\Entity;

use App\Repository\PhoneModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PhoneModelRepository::class)]
class PhoneModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $brand;

    #[ORM\Column(type: 'string', length: 30)]
    private $model;

    #[ORM\Column(type: 'string', length: 4, nullable: true)]

    private $year;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $stockLimit;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updated_at;

    #[ORM\Column(type: 'boolean')]
    private $active;

    #[ORM\OneToMany(mappedBy: 'phone', targetEntity: IdNumber::class)]
    private $idNumbers;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $stock;

    public function __construct()
    {
        $this->idNumbers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStockLimit(): ?int
    {
        return $this->stockLimit;
    }

    public function setStockLimit(int $stockLimit): self
    {
        $this->stockLimit = $stockLimit;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, IdNumber>
     */
    public function getIdNumbers(): Collection
    {
        return $this->idNumbers;
    }

    public function addIdNumber(IdNumber $idNumber): self
    {
        if (!$this->idNumbers->contains($idNumber)) {
            $this->idNumbers[] = $idNumber;
            $idNumber->setPhone($this);
        }

        return $this;
    }

    public function removeIdNumber(IdNumber $idNumber): self
    {
        if ($this->idNumbers->removeElement($idNumber)) {
            // set the owning side to null (unless already changed)
            if ($idNumber->getPhone() === $this) {
                $idNumber->setPhone(null);
            }
        }

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}
