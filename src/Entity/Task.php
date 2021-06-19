<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskRepository;
use App\Resolver\TaskMutationResolver;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass:TaskRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Task']],
    graphql: [
        'item_query',
        'create' => [
            'denormalization_context' => ['groups' => ['create:Task']],
            'mutation' => TaskMutationResolver::class
        ],
        'delete' => [
            'normalization_context' => ['groups' => ['delete:Task']]
        ]
    ]
)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Task','delete:Task'])]
    private $id;

    #[ORM\Column(type:"string", length:255)]
    #[Groups(['read:Task','create:Task'])]
    private $name;

    #[ORM\Column(type:"boolean")]
    #[Groups(['read:Task'])]
    private $completed = false;

    #[ORM\ManyToOne(targetEntity:User::class)]
    #[ORM\JoinColumn(nullable:false)]
    private $person;

    #[ORM\ManyToOne(targetEntity:Location::class, inversedBy:"tasks")]
    #[ORM\JoinColumn(nullable:false)]
    #[Groups(['create:Task'])]
    private $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getPerson(): ?User
    {
        return $this->person;
    }

    public function setPerson(?User $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }
}
