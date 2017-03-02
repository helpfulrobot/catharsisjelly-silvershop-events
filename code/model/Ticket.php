<?php

/**
 * @property string Title
 * @property float Price
 */
class Ticket extends DataObject implements Buyable
{
    private static $db = [
        'Title' => Varchar::class,
        'Price' => 'Currency(19,4)'
    ];

    private static $has_one = [
        'Event' => Event::class
    ];

    /**
     * @param int $quantity
     * @param array $filter
     * @return OrderItem new OrderItem object
     */
    public function createItem($quantity = 1, $filter = null)
    {
        $item = new Ticket_OrderItem();
        $item->TicketID = $this->ID;
        if ($filter) {
            //TODO: make this a bit safer, perhaps intersect with allowed fields
            $item->update($filter);
        }
        $item->Quantity = $quantity;
        return $item;
    }

    /**
     * @param Member|null $member the Member that wants to purchase the buyable. Defaults to null
     * @param int $quantity the quantity to purchase. Defaults to 1
     * @return bool true if the buyable can be purchased
     */
    public function canPurchase($member = null, $quantity = 1)
    {
        // Standard mechanism for accepting permission changes from decorators
        $permissions = $this->extend('canPurchase', $member, $quantity);
        return min($permissions);
    }

    /**
     * @return ShopCurrency
     */
    public function sellingPrice()
    {
        // Stolen from Product
        $price = $this->Price;

        $this->extend("updateSellingPrice", $price);
        //prevent negative values
        $price = $price < 0 ? 0 : $price;

        return round($price, Order::config()->rounding_precision);
    }
}