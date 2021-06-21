<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookingRepository;
use App\Resolver\BookingMutationResolver;
use App\Security\Voter\BookingVoter;
use App\Validator\BookingPeriod;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass:BookingRepository::class)]
#[ApiResource(
    attributes: ['security' => "is_granted('ROLE_USER')"],
    normalizationContext: ['groups' => ['read']],
    graphql: [
        'collection_query',
        'item_query',
        'create' => [
            'denormalization_context' => ['groups' => ['create:Booking']],
            'mutation' => BookingMutationResolver::class,
            'args' => [
                'title' => ['type' => 'String'],
                'start' => ['type' => 'DateTime'],
                'finish' => ['type' => 'DateTime'],
                'location' => ['type' => 'String!'],
                'quantity' => ['type' => 'Int'],
            ]
        ],
        'update' => [
            'denormalization_context' => ['groups' => ['update:Booking']],
            'access_control' => "is_granted('".BookingVoter::EDIT."', previous_object)"
        ],
        'delete'
    ]
)]
#[BookingPeriod]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read'])]
    private $id;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    #[Groups(['read', 'create:Booking', 'update:Booking'])]
    #[Assert\Length(max:"255")]
    private $title;

    #[ORM\Column(type:"datetime")]
    #[Groups(['read', 'create:Booking', 'update:Booking'])]
    private $start;

    #[ORM\Column(type:"datetime")]
    #[Groups(['read', 'create:Booking', 'update:Booking'])]
    #[Assert\GreaterThan(propertyPath:"start", message:"La date de départ doit être postérieur à la date d'arrivée ({{ compared_value }}).")]
    private $finish;

    #[ORM\ManyToOne(targetEntity:Location::class, inversedBy:"bookings")]
    #[ORM\JoinColumn(nullable:false)]
    #[Groups(['read', 'create:Booking'])]
    #[Assert\NotNull]
    private $location;

    #[ORM\ManyToOne(targetEntity:User::class, inversedBy:"bookings")]
    #[ORM\JoinColumn(nullable:false)]
    #[Groups(['read'])]
    #[Assert\NotNull]
    private $person;

    #[ORM\Column(type:"integer")]
    #[Groups(['read', 'create:Booking', 'update:Booking'])]
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
