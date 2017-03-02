<?php

class Event extends Page implements Buyable
{
    private static $db = [
        'Price' => 'Currency(19,4)',
        'BookingFee' => 'Currency(19,4)',
    ];

    private static $has_many = [
        'Images' => Image::class,
        'Schedules' => Schedule::class
    ];

    private static $casting                = array(
        'Price' => 'Currency',
    );

    private static $singular_name          = "Event";

    private static $plural_name            = "Events";

    private static $default_sort           = '"EndDate" ASC';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        self::disableCMSFieldsExtensions();
        $fields = parent::getCMSFields();
        $fields->fieldByName('Root.Main.Title')
            ->setTitle('Event Title');

        // Dates & Pricing
        $fields->addFieldsToTab('Root.Details', [
            DateField::create('StartDate', 'Start Date'),
            TextField::create('Price', 'Price')
                ->setMaxLength(12),
            TextField::create('BookingFee', 'Booking Fee')
                ->setMaxLength(12),
        ]);

        if (!$fields->dataFieldByName('Image')) {
            $fields->addFieldToTab(
                'Root.Images',
                UploadField::create('Image', 'Event Images')
            );
        }
        self::enableCMSFieldsExtensions();
        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    /**
     * Create a new OrderItem to add to an order.
     *
     * @param int $quantity
     * @param array $filter
     * @return OrderItem new OrderItem object
     */
    public function createItem($quantity = 1, $filter = array())
    {
        $item = new TicketOrderItem();
        $item->ProductID = $this->ID;
        if ($filter) {
            //TODO: make this a bit safer, perhaps intersect with allowed fields
            $item->update($filter);
        }
        $item->Quantity = $quantity;
        return $item;
    }

    /**
     * Checks if the buyable can be purchased. If a buyable cannot be purchased
     * then the method should return false
     *
     * @param Member|null $member the Member that wants to purchase the buyable. Defaults to null
     * @param int $quantity the quantity to purchase. Defaults to 1
     * @return boolean true if the buyable can be purchased
     */
    public function canPurchase($member = null, $quantity = 1)
    {
        // TODO: Implement canPurchase() method.
    }

    /**
     * The price the customer gets this buyable for, with any additional
     * additions or subtractions.
     *
     * @return ShopCurrency
     */
    public function sellingPrice()
    {
        // TODO: Implement sellingPrice() method.
    }
}