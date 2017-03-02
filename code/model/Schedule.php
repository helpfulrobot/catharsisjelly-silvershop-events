<?php

/**
 * Class Schedule
 * @property string StartDate
 * @property string StartTime
 * @property string EndDate
 * @property string EndTime
 * @method Event Event
 * @method ArrayList|ScheduleDay[] Days
 */
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

    private static $has_many = [
        'Days' => ScheduleDay::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Root.Days');
        $fields->addFieldsToTab('Root.Days', $this->buildDaysGrid());
        return $fields;
    }

    /**
     * @return array
     */
    public function calculateDaysOn()
    {
        // Get the day of the start date
        $startDate = $this->dateToImmutable($this->StartDate);

        // no end date, assume it's on every day
        if (!$this->EndDate) {
            return [1, 2, 3, 4, 5, 6, 7];
        }

        $days = [];
        // Find the number of days different
        $endDate = $this->dateToImmutable($this->EndDate);
        $timeDiff = $startDate->diff($endDate);

        // Same day, return the day it's on
        if ($timeDiff->days === 0) {
            $days = [intval($startDate->format('N'))];
        } elseif ($timeDiff->days < 7) {
            for ($i = 0; $i <= $timeDiff->days; $i++) {
                $nextDay = $startDate->add(new DateInterval('P' . $i . 'D'));
                $days[] = intval($nextDay->format('N'));
            }
        }

        sort($days);
        return $days;
    }

    /**
     * @param string $dateString
     * @return DateTimeImmutable
     */
    private function dateToImmutable($dateString)
    {
        return new DateTimeImmutable($dateString);
    }

    /**
     * @return GridField
     */
    private function buildDaysGrid()
    {
        /** @var GridField $daysGrid */
        $daysGrid = GridField::create("DaysGrid", "Days", $this->Days())
            ->setModelClass(ScheduleDay::class);

        $config = GridFieldConfig_RecordEditor::create();

        /** @var GridFieldDataColumns $dataColumns */
        $dataColumns = $config->getComponentByType(GridFieldDataColumns::class);
        $dataColumns->setDisplayFields([
            'Day' => 'Day',
        ]);

        $daysGrid->setConfig($config);
        return $daysGrid;
    }
}