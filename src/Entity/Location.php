<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LocationRepository;
use App\Resolver\LocationMutationResolver;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass:LocationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Location']],
    graphql: [
        'item_query',
        'create' => [
            'denormalization_context' => ['groups' => ['create:Location']],
            'mutation' => LocationMutationResolver::class
        ],
        'delete' => [
            'normalization_context' => ['groups' => ['delete:Location']]
        ]
    ]
)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Location', 'delete:Location'])]
    private $id;

    #[ORM\Column(type:"string", length:50)]
    #[Groups(['read:Location', 'create:Location'])]
    private $name;

    #[ORM\ManyToOne(targetEntity:User::class, inversedBy:"locations")]
    #[ORM\JoinColumn(nullable:false)]
    private $person;

    #[ORM\OneToMany(targetEntity:Task::class, mappedBy:"location", orphanRemoval:true)]
    #[Groups(['read:Location'])]
    private $tasks;

    #[ORM\OneToMany(targetEntity:Purchase::class, mappedBy:"location", orphanRemoval:true)]
    #[Groups(['read:Location'])]
    private $purchases;

    #[ORM\OneToMany(targetEntity:Booking::class, mappedBy:"location", orphanRemoval:true)]
    #[Groups(['read:Location'])]
    private $bookings;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->purchases = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setLocation($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getLocation() === $this) {
                $task->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Purchase[]
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setLocation($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getLocation() === $this) {
                $purchase->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setLocation($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getLocation() === $this) {
                $booking->setLocation(null);
            }
        }

        return $this;
    }
}
