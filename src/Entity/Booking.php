<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookingRepository;
use App\Resolver\BookingMutationResolver;
use App\Validator\BookingPeriod;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass:BookingRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Booking']],
    graphql: [
        'collection_query',
        'item_query',
        'create' => [
            'denormalization_context' => ['groups' => ['create:Booking']],
            'mutation' => BookingMutationResolver::class
        ],
    ]
)]
#[BookingPeriod]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Booking','delete:Booking'])]
    private $id;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    #[Groups(['read:Booking','create:Booking'])]
    #[Assert\Length(max:"255")]
    private $title;

    #[ORM\Column(type:"datetime")]
    #[Groups(['read:Booking','create:Booking'])]
    private $start;

    #[ORM\Column(type:"datetime")]
    #[Groups(['read:Booking','create:Booking'])]
    #[Assert\GreaterThan(propertyPath:"start", message:"La date de départ doit être postérieur à la date d'arrivée ({{ compared_value }}).")]
    private $finish;

    #[ORM\ManyToOne(targetEntity:Location::class, inversedBy:"bookings")]
    #[ORM\JoinColumn(nullable:false)]
    #[Groups(['read:Booking','create:Booking'])]
    #[Assert\NotNull]
    private $location;

    #[ORM\ManyToOne(targetEntity:User::class, inversedBy:"bookings")]
    #[ORM\JoinColumn(nullable:false)]
    #[Groups(['read:Booking'])]
    #[Assert\NotNull]
    private $person;

    #[ORM\Column(type:"integer")]
    #[Groups(['read:Booking','create:Booking'])]
    #[Assert\GreaterThanOrEqual(1)]
    private $quantity = 1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getFinish(): ?\DateTimeInterface
    {
        return $this->finish;
    }

    public function setFinish(\DateTimeInterface $finish): self
    {
        $this->finish = $finish;

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

    public function getPerson(): ?User
    {
        return $this->person;
    }

    public function setPerson(?User $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
