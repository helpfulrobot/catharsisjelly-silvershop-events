<?php

class Schedule extends DataObject
{
    private static $db = [
        'StartDate' => Date::class,
        'StartTime' => Time::class,
        'EndDate' => Date::class,
        'EndTime' => Time::class,
    ];

    private static $has_one = [
        'Event' => Event::class
    ];
}