<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\Location;
use App\Entity\Purchase;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $users = $this->usersFixtures($manager);
        $locations = $this->locationsFixtures($manager, $users);
        $this->bookingsFixtures($manager, $users, $locations);
        $this->tasksFixtures($manager, $users, $locations);
        $this->purchasesFixtures($manager, $users, $locations);
        
        $manager->flush();
    }

    private function usersFixtures(ObjectManager $manager): array
    {
        $usersData= [
            [
                'firstname' => 'Jean',
                'lastname' => 'Durand',
                'email' => 'jdurand@bookhome.com',
                'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
                'password' => 'admin',
            ],
            [
                'firstname' => 'Marcel',
                'lastname' => 'Patoulatchi',
                'email' => 'mpatoulatchi@bookhome.com',
                'roles' => ['ROLE_USER'],
                'password' => 'user',
            ],
        ];

        $users = [];
        foreach($usersData as $userData) {
            $user = (new User())
                ->setFirstname($userData['firstname'])
                ->setLastname($userData['lastname'])
                ->setEmail($userData['email'])
                ->setRoles($userData['roles'])
            ;

            $user->setPassword($this->passwordHasher->hashPassword($user, $userData['password']));

            $manager->persist($user);
            $users[] = $user;
        }

        return $users;
    }

    private function locationsFixtures(ObjectManager $manager, array $users): array
    {
        $locations = [];
        $locationsData = [
            [
                'name' => 'Villa',
                'user' => $users[0],
            ],
            [
                'name' => 'Mobile-Home',
                'user' => $users[0],
            ],
            [
                'name' => 'Tente',
                'user' => $users[1],
            ],
        ];

        foreach ($locationsData as $locationData) {
            $location = (new Location())
                ->setName($locationData['name'])
                ->setPerson($locationData['user'])
            ;

            $manager->persist($location);
            $locations[] = $location;
        }

        return $locations;
    }

    private function bookingsFixtures(ObjectManager $manager, array $users, array $locations): void
    {
        $bookingsData = [
            [
                'title' => 'Séminaire',
                'start' => 'back of 15',
                'finish' => 'tomorrow',
                'location' => $locations[0],
                'user' => $users[0],
                'quantity' => 10,
            ],
            [
                'title' => 'Vacances',
                'start' => 'yesterday',
                'finish' => 'front of 23',
                'location' => $locations[1],
                'user' => $users[1],
                'quantity' => 4,
            ],
            [
                'start' => 'yesterday',
                'finish' => 'front of 23',
                'location' => $locations[2],
                'user' => $users[0],
                'quantity' => 2,
            ],
        ];

        foreach ($bookingsData as $bookingData) {
            $booking = (new Booking)
                ->setTitle($bookingData['title'] ?? null)
                ->setStart(new \DateTime($bookingData['start']))
                ->setFinish(new \DateTime($bookingData['finish']))
                ->setLocation($bookingData['location'])
                ->setPerson($bookingData['user'])
                ->setQuantity($bookingData['quantity'])
            ;

            $manager->persist($booking);
        }
    }

    private function tasksFixtures(ObjectManager $manager, array $users, array $locations): void
    {
        $tasksData = [
            [
                'name' => 'Ménage',
                'location' => $locations[0],
                'user' => $users[0],
            ],
            [
                'name' => 'Vaisselle',
                'location' => $locations[1],
                'user' => $users[1],
            ],
            [
                'name' => 'Course',
                'location' => $locations[1],
                'user' => $users[0],
            ],
        ];

        foreach ($tasksData as $taskData) {
            $task = (new Task)
                ->setName($taskData['name'])
                ->setLocation($taskData['location'])
                ->setPerson($taskData['user'])
            ;

            $manager->persist($task);
        }
    }

    private function purchasesFixtures(ObjectManager $manager, array $users, array $locations): void
    {
        $purchasesData = [
            [
                'name' => 'Carotte',
                'location' => $locations[2],
                'user' => $users[1],
            ],
            [
                'name' => 'Chocolat',
                'location' => $locations[0],
                'user' => $users[1],
            ],
            [
                'name' => 'Légume',
                'location' => $locations[2],
                'user' => $users[0],
            ],
        ];

        foreach ($purchasesData as $purchaseData) {
            $purchase = (new Purchase)
                ->setName($purchaseData['name'])
                ->setLocation($purchaseData['location'])
                ->setPerson($purchaseData['user'])
            ;

            $manager->persist($purchase);
        }
    }
}
