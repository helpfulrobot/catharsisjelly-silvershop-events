<?php

class EventAdmin extends ModelAdmin
{
    private static $url_segment     = 'event';

    private static $menu_title      = 'Event';

    private static $menu_priority   = 5;

    private static $managed_models = [
        Event::class,
    ];
}