<?php

namespace Msr\Mapper;

use Msr\Model\Event;

class EventMapper
{
    public static function map(\stdClass $json)
    {
        $event = new Event();
        $event->id = $json->id;
        $event->name = $json->name;
        $event->orgName = $json->organization->name;
        $event->orgUrl = $json->organization->uri;
        $event->venueName = $json->venue->name;
        $event->venueCity = $json->venue->city;
        $event->venueRegion = $json->venue->region;
        $event->description = $json->description;
        $event->detailUrl = $json->detailuri;
        $event->geoPoint = $json->venue->geo;
        $event->startDate = $json->start;
        $event->endDate = $json->end;
        $event->regStartDate = $json->registration->start;
        $event->regEndDate = $json->registration->end;
        $event->type = $json->type;
        $event->url = $json->uri;
        return $event;
    }
}