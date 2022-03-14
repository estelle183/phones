<?php

namespace App\Entity;

use App\Repository\IdNumberRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IdNumberRepository::class)]

class IdNumber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 13)]
    /**
     * @Assert\Length(
     *      min = 13,
     *      max = 13,
     *      minMessage = "L'IMEI doit contenir {{ limit }} chiffres ",
     *      maxMessage = "L'IMEI doit contenir {{ limit }} chiffres"
     * )
     *
     * @Assert\Unique
     */
    private $imei;

    #[ORM\Column(type: 'boolean')]
    private $active;

    #[ORM\ManyToOne(targetEntity: PhoneModel::class, inversedBy: 'idNumbers')]
    private $phone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImei(): ?string
    {
        return $this->imei;
    }

    public function setImei(string $imei): self
    {
        $this->imei = $imei;

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

    public function getPhone(): ?PhoneModel
    {
        return $this->phone;
    }

    public function setPhone(?PhoneModel $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
