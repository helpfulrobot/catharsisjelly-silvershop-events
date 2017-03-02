<?php

/**
 * @method ArrayList|Ticket[] Tickets
 * @method ArrayList|Image[] Images
 * @method ArrayList|Schedule[] Schedules
 */
class Event extends SiteTree
{
    private static $has_many = [
        'Tickets' => Ticket::class,
        'Images' => Image::class,
        'Schedules' => Schedule::class,
    ];

    private static $singular_name          = "Event";

    private static $plural_name            = "Events";

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->fieldByName('Root.Main.Title')
            ->setTitle('Event Title');

        if ($this->isInDB()) {
            $fields->addFieldsToTab('Root.Schedules', $this->buildSchedulesGrid());
            $fields->addFieldsToTab('Root.Tickets', $this->buildTicketsGrid());
        }

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
     * @return GridField
     */
    private function buildSchedulesGrid()
    {
        /** @var GridField $scheduleGrid */
        $scheduleGrid = GridField::create("ScheduleGrid", "Schedules", $this->Schedules())
            ->setModelClass(Schedule::class);

        $config = GridFieldConfig_RecordEditor::create();

        /** @var GridFieldDataColumns $dataColumns */
        $dataColumns = $config->getComponentByType(GridFieldDataColumns::class);
        $dataColumns->setDisplayFields([
            'StartDate' => 'Start Date',
            'StartTime' => 'Start Time',
            'EndDate' => 'End Date',
            'EndTime' => 'End Time',
        ]);

        $scheduleGrid->setConfig($config);
        return $scheduleGrid;
    }

    private function buildTicketsGrid()
    {
        /** @var GridField $ticketsGrid */
        $ticketsGrid = GridField::create("TicketsGrid", "Tickets", $this->Tickets())
            ->setModelClass(Ticket::class);

        $config = GridFieldConfig_RecordEditor::create();

        /** @var GridFieldDataColumns $dataColumns */
        $dataColumns = $config->getComponentByType(GridFieldDataColumns::class);
        $dataColumns->setDisplayFields([
            'Title' => 'Title',
            'Price' => 'Price'
        ]);

        $ticketsGrid->setConfig($config);
        return $ticketsGrid;
    }

}
