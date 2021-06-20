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

    public function findOverlap(Booking $booking)
    {
        $qb = $this->createQueryBuilder('b')
            ->where('b.location = :location')
            ->andWhere('b.start <= :finish')
            ->andWhere('b.finish >= :start')
            
            ->setParameters([
                'location' => $booking->getLocation(),
                'start' => $booking->getStart(),
                'finish' => $booking->getFinish(),
            ])
        ;

        if (null !== $booking->getId()) {
            $qb->andWhere('b.id != :booking')->setParameter('booking', $booking->getId());
        }

        return $qb->getQuery()->getResult();
    }
}
