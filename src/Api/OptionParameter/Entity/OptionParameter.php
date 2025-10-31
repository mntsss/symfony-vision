<?php

namespace App\Api\OptionParameter\Entity;

use App\Api\OptionParameter\Repository\OptionParameterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: OptionParameterRepository::class)]
#[ORM\Table(name: 'option_parameter')]
class OptionParameter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_option_parameter', type: 'integer')]
    private ?int $idOptionParameter = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'integer')]
    private ?int $level = null;

    /**
     * @var Collection<int, OptionValue>
     */
    #[ORM\OneToMany(targetEntity: OptionValue::class, mappedBy: 'parameter', orphanRemoval: true)]
    #[MaxDepth(1)]
    private Collection $optionValues;

    public function __construct()
    {
        $this->optionValues = new ArrayCollection();
    }

    public function getIdOptionParameter(): ?int
    {
        return $this->idOptionParameter;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return Collection<int, OptionValue>
     */
    public function getOptionValues(): Collection
    {
        return $this->optionValues;
    }

    public function addOptionValue(OptionValue $optionValue): static
    {
        if (!$this->optionValues->contains($optionValue)) {
            $this->optionValues->add($optionValue);
            $optionValue->setParameter($this);
        }

        return $this;
    }

    public function removeOptionValue(OptionValue $optionValue): static
    {
        if ($this->optionValues->removeElement($optionValue)) {
            if ($optionValue->getParameter() === $this) {
                $optionValue->setParameter(null);
            }
        }

        return $this;
    }
}
