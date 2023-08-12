<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testContactFormSubmission()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');

        $form = $crawler->selectButton('Submit')->form();
        $form['name'] = 'John Doe';
        $form['email'] = 'john@example.com';
        $form['message'] = 'This is a test message';

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());

        $client->followRedirect();

        $this->assertSame('http://localhost/', $client->getRequest()->getUri());
    }
}
