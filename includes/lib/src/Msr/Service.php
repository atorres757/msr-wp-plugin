<?php

namespace Msr;

use Msr\Client;
use Msr\Response\OrgCalendarResponse;
use Msr\Model\Event;
use Msr\Mapper\EventMapper;

class Service
{
    private $client;
    
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    /**
     * 
     * @param string $orgId
     * 
     * @return Msr\Response\OrgCalendarResponse
     */
    public function getOrgCalendar($orgId)
    {
        $res = $this->client->get('/calendars/organization/' . $orgId . '.json');
        $parsedResp = $this->prepOrgCalendarResponse($res);
        return $parsedResp;
    }
    
    private function prepOrgCalendarResponse($res)
    {
        $orgRes = new OrgCalendarResponse();
        
        $jsonRes = json_decode($res);
        if ($jsonRes) {
            $orgRes->total = $jsonRes->response->recordset->total;
            $orgRes->page = $jsonRes->response->recordset->page;
            
            foreach ($jsonRes->response->events as $msrEvent) {
                $orgRes->content[] = EventMapper::map($msrEvent);
            }
        }
        
        return $orgRes;
    }
}