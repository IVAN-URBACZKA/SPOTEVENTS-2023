<?php

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;



class EventControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/event');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testSingleEvent()
    {
        $client = static::createClient();

        $client->request('GET', '/event/1');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testNewEventPageForAdmin()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        $userRepository = $container->get(UserRepository::class);

        $testAdmin = $userRepository->findOneByEmail('admin@example.com');

        $client->loginUser($testAdmin);


        $client->request('GET', '/create');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

}
