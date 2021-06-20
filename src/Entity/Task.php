<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskRepository;
use App\Resolver\TodoMutationResolver;
use App\Resolver\ToggleMutationResolver;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:TaskRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Todo']],
    graphql: [
        'item_query',
        'create' => [
            'denormalization_context' => ['groups' => ['create:Todo']],
            'mutation' => TodoMutationResolver::class
        ],
        'delete' => [
            'normalization_context' => ['groups' => ['delete:Todo']]
        ],
        'toggle' => [
            'denormalization_context' => ['groups' => ['toggle:Todo']],
            'mutation' => ToggleMutationResolver::class
        ]
    ]
)]
class Task extends Todo
{
}
