<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use App\Entity\User;


class UserRepositoryTest extends WebTestCase
{
    public function testUpgradePassword()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        
        $userRepository = $container->get(UserRepository::class);

        $user = $userRepository->findOneByEmail('admin@example.com');
        $this->assertInstanceOf(User::class, $user);

       
    }


    protected function setUp(): void
    {
        parent::setUp();
    }
}





