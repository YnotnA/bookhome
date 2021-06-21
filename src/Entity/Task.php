<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskRepository;
use App\Resolver\TodoMutationResolver;
use App\Resolver\ToggleMutationResolver;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:TaskRepository::class)]
#[ApiResource(
    attributes: ['security' => "is_granted('ROLE_USER')"],
    normalizationContext: ['groups' => ['read']],
    graphql: [
        'item_query',
        'create' => [
            'denormalization_context' => ['groups' => ['create:Todo']],
            'mutation' => TodoMutationResolver::class
        ],
        'delete',
        'toggle' => [
            'denormalization_context' => ['groups' => ['toggle:Todo']],
            'mutation' => ToggleMutationResolver::class
        ]
    ]
)]
class Task extends Todo
{
}
