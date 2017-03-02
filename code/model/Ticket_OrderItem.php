<?php

/**
 * @method Ticket Ticket
 * @property int TicketID
 */
class Ticket_OrderItem extends OrderItem
{
    private static $has_one = [
        'Ticket' => Event::class,
    ];

    /**
     * the has_one join field to identify the buyable
     */
    private static $buyable_relationship = Ticket::class;

    public function TableTitle()
    {
        $ticket = $this->Ticket();
        $tableTitle = ($ticket) ? $ticket->Title : $this->i18n_singular_name();
        $this->extend('updateTableTitle', $tableTitle);
        return $tableTitle;
    }

    public function Link()
    {
        if ($ticket = $this->Ticket()) {
            return $ticket->Link();
        }
    }
}
