<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PurchaseRepository;
use App\Resolver\TodoMutationResolver;
use App\Resolver\ToggleMutationResolver;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:PurchaseRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
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
class Purchase extends Todo
{
}
