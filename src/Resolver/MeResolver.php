<?php

namespace App\Resolver;

use ApiPlatform\Core\GraphQl\Resolver\QueryItemResolverInterface;
use Symfony\Component\Security\Core\Security;

class MeResolver implements QueryItemResolverInterface
{
    public function __construct(private Security $security){}

    public function __invoke($item, array $context)
    {
        return $this->security->getUser();
    }
}