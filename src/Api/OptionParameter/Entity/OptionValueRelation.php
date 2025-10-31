<?php

namespace App\Api\OptionParameter\Entity;

use App\Api\OptionParameter\Repository\OptionValueRelationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionValueRelationRepository::class)]
#[ORM\Table(name: 'option_value_relation')]
class OptionValueRelation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_option_value_relation', type: 'integer')]
    private ?int $idOptionValueRelation = null;

    #[ORM\ManyToOne(targetEntity: OptionValue::class)]
    #[ORM\JoinColumn(name: 'id_option_value_parent', referencedColumnName: 'id_option_value', nullable: false)]
    private ?OptionValue $parent = null;

    #[ORM\Column(name: 'id_option_value_parent', type: 'integer', insertable: false, updatable: false)]
    private ?int $parentId = null;

    #[ORM\ManyToOne(targetEntity: OptionValue::class)]
    #[ORM\JoinColumn(name: 'id_option_value_child', referencedColumnName: 'id_option_value', nullable: false)]
    private ?OptionValue $child = null;

    #[ORM\Column(name: 'id_option_value_child', type: 'integer', insertable: false, updatable: false)]
    private ?int $childId = null;

    public function getIdOptionValueRelation(): ?int
    {
        return $this->idOptionValueRelation;
    }

    public function getParent(): ?OptionValue
    {
        return $this->parent;
    }

    public function setParent(?OptionValue $parent): static
    {
        $this->parent = $parent;
        return $this;
    }

    public function getChild(): ?OptionValue
    {
        return $this->child;
    }

    public function setChild(?OptionValue $child): static
    {
        $this->child = $child;
        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function getChildId(): ?int
    {
        return $this->childId;
    }
}
