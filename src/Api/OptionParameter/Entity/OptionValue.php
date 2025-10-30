<?php

namespace App\Api\OptionParameter\Entity;

use App\Api\OptionParameter\Repository\OptionValueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionValueRepository::class)]
#[ORM\Table(name: 'option_value')]
class OptionValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_option_value', type: 'integer')]
    private ?int $idOptionValue = null;

    #[ORM\ManyToOne(targetEntity: OptionParameter::class, inversedBy: 'optionValues')]
    #[ORM\JoinColumn(name: 'id_option_parameter', referencedColumnName: 'id_option_parameter', nullable: false)]
    private ?OptionParameter $parameter = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\Column(type: Types::GUID, nullable: true)]
    private ?string $uuid = null;

    public function getIdOptionValue(): ?int
    {
        return $this->idOptionValue;
    }

    public function getParameter(): ?OptionParameter
    {
        return $this->parameter;
    }

    public function setParameter(?OptionParameter $parameter): static
    {
        $this->parameter = $parameter;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;
        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): static
    {
        $this->uuid = $uuid;
        return $this;
    }
}
