<?php

/**
 * @property string Day
 * @method Schedule Schedule
 */
class ScheduleDay extends DataObject
{
    private static $db = [
        'Day' => "Enum('Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday')"
    ];

    private static $has_one  = [
        'Schedule' => Schedule::class
    ];

    private static $days = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
    ];

    public static function createFromSchedule(Schedule $schedule)
    {
        $days = $schedule->calculateDaysOn($schedule);
        foreach ($days as $day) {
            $schedule->Days()->add(static::create([
                'Day' => self::$days[$day-1]
            ]));
        }
    }


}
