<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class LogControllerTest
 *
 * @author Damien Lagae <damien.lagae@enabel.be>
 * @group functional
 * @group main
 */
class LogControllerTest extends WebTestCase
{
    public function testHomepageIsAlive(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString(
            "Last job execution time",
            $crawler->filter('main h1')->text()
        );
    }
}
