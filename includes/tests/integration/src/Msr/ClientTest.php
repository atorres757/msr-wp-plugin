<?php

namespace Tests\Integration\Msr;

use PHPUnit\Framework\TestCase;
use Msr\Client;

class ClientTest extends TestCase
{
    public function testGet()
    {
        $client = new Client();
        $res = $client->get('/calendars/organization/' . TEST_ORGANIZATION_ID . '.json');
        
        $json = json_decode($res);
        
        $this->assertFalse($json === false);
    }
}