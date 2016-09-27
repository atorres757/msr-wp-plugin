<?php

namespace Test\Integration\Msr;

use Msr\Service;
use Msr\Client;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    public function testGetOrgCalender()
    {
        $client = new Client();
        $service = new Service($client);
        
        $res = $service->getOrgCalendar(TEST_ORGANIZATION_ID);
        
        $this->assertTrue(count($res->content) > 0);
    }
}