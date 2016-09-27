<?php

namespace Tests\Msr;

use Msr\Client;
use Msr\Service;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    public $service;
    public $client;
    
    public function setUp()
    {
        $this->client = $this->getMockBuilder('Msr\Client')
                            ->disableOriginalConstructor()
                            ->getMock();
        $this->service = new Service($this->client);
    }
    
    public function testGetOrgCalendar()
    {
        $orgId = "123abc456";
        
        $this->client->expects($this->once())
            ->method('get')
            ->with('/calendars/organization/' . $orgId . '.json')
            ->willReturn(file_get_contents(MOCK_DATA_DIR . '/org_calendar_response.json'));
        
        $res = $this->service->getOrgCalendar($orgId);
        
        $this->assertEquals(1, $res->total);
        $this->assertEquals(1, count($res->content));
        
        $event = $res->content[0];
        $this->assertEquals('Tidewater Sports Car Club', $event->orgName);
    }
}