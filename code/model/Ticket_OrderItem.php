<?php

/**
 * @method Event Ticket
 */
class Ticket_OrderItem extends OrderItem
{
    private static $has_one = [
        'Ticket' => Event::class,
    ];

    /**
     * the has_one join field to identify the buyable
     */
    private static $buyable_relationship = Event::class;

    public function TableTitle()
    {
        $ticket = $this->Ticket();
        $tabletitle = ($ticket) ? $ticket->Title : $this->i18n_singular_name();
        $this->extend('updateTableTitle', $tabletitle);
        return $tabletitle;
    }

    public function Link()
    {
        if ($ticket = $this->Ticket()) {
            return $ticket->Link();
        }
    }
}
