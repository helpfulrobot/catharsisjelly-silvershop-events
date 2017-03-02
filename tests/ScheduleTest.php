<?php

class ScheduleTest extends SapphireTest
{
    const DATE_FORMAT = 'Y-m-d';

    public function testDaysOn_OneDay_ReturnsWednesday()
    {
        $date = '2017-03-01'; // A Wednesday
        $schedule = $this->createSchedule($date, $date);

        $expected = [3];
        $actual = $schedule->calculateDaysOn();
        $this->assertSame($expected, $actual);
    }

    public function testDaysOn_NoEndDate_ReturnsWholeWeek()
    {
        $date = '2017-03-01'; // A Wednesday
        $schedule = $this->createSchedule($date);

        $expected = [1,2,3,4,5,6,7];
        $actual = $schedule->calculateDaysOn();
        $this->assertSame($expected, $actual);
    }

    public function testDaysOn_ThreeDays_ReturnsDays()
    {
        $startDate = '2017-03-01'; // A Wednesday
        $endDate = '2017-03-03'; // A Friday
        $schedule = $this->createSchedule($startDate, $endDate);

        $expected = [3,4,5];
        $actual = $schedule->calculateDaysOn();
        $this->assertSame($expected, $actual);
    }

    public function testDaysOn_ThreeDays_HappensOverWeekend_ReturnsDays()
    {
        $startDate = '2017-03-04'; // Saturday
        $endDate = '2017-03-06'; // Monday
        $schedule = $this->createSchedule($startDate, $endDate);

        $expected = [1,6,7];
        $actual = $schedule->calculateDaysOn();
        $this->assertSame($expected, $actual);
    }

    /**
     * @return Schedule
     */
    public function createSchedule($startDate, $endDate = null)
    {
        $schedule = Schedule::create();

        $startDate = new DateTimeImmutable($startDate);
        $schedule->StartDate = $startDate->format(self::DATE_FORMAT);

        if ($endDate !== null) {
            $endDate = new DateTimeImmutable($endDate);
            $schedule->EndDate = $endDate->format(self::DATE_FORMAT);
        }
        return $schedule;
    }
}