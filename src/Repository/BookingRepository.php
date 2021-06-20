<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function findOverlap(Location $location, \DateTimeInterface $start, \DateTimeInterface $finish)
    {
        return $this->createQueryBuilder('b')
            ->where('b.location = :location')
            ->andWhere('b.start <= :finish')
            ->andWhere('b.finish >= :start')
            ->setParameters([
                'location' => $location,
                'start' => $start,
                'finish' => $finish,
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
