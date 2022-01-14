<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterTest extends WebTestCase
{
    public function testGetRegister(): void
    {
        $client = static::createClient();
        $crawler = $client->request(
            'GET',
            '/register'
        );

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h4', 'Sign-up!');

        // testing an id
        $this->assertCount(1, $crawler->filter('#registration_form_register') );
        // testing a class
        $this->assertCount(1, $crawler->filter('.form-check-input') );

    }

    public function testPostRegister(): void
    {
        $client = static::createClient();
        $crawler = $client->request(
            'POST',
            '/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "registration_form[username]": "testUser",
                "registration_form[plainPassword]": "testPassword",
                "registration_form[agreeTerms]": "1",
                "registration_form[register]": "",
            }'
             
        );

        //$this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(302);
        //$this->assertResponseRedirects('/');
        $this->assertSelectorTextContains('div', 'There is already an account with this username');
    }
}
