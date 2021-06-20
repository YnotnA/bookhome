<?php

namespace App\Resolver;

use ApiPlatform\Core\GraphQl\Resolver\MutationResolverInterface;
use App\Entity\Todo;

class ToggleMutationResolver implements MutationResolverInterface
{
    public function __invoke($item, array $context)
    {
        /** @var Todo $item */
        return $item->setCompleted(!$item->isCompleted());
    }
}