<?php

namespace App\Resolver;

use ApiPlatform\Core\GraphQl\Resolver\MutationResolverInterface;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

abstract class AbstractUserMutationResolver implements MutationResolverInterface
{
    public function __construct(
        private Security $security,
        private UserRepository $userRepository
    ){}
    
    public function __invoke($item, array $context)
    {
        return $item->setPerson($this->userRepository->find($this->security->getUser()->getId()));
    }
}