<?php

class ScheduleDayTest extends SapphireTest
{
    const DATE_FORMAT = 'Y-m-d';

    public function testCreateFromSchedule_OneDay_ScheduleHas1Day()
    {
        $date = '2017-03-01'; // A Wednesday
        $schedule = $this->createSchedule($date, $date);

        ScheduleDay::createFromSchedule($schedule);
        /** @var ScheduleDay $firstDay */
        $firstDay = $schedule->Days()->first();

        $this->assertEquals(1, $schedule->Days()->count());
        $this->assertSame('Wednesday', $firstDay->Day);
    }

    public function testCreateFromSchedule_NoEndDate_ScheduleHas7Days()
    {
        $date = '2017-03-01'; // A Wednesday
        $schedule = $this->createSchedule($date);

        ScheduleDay::createFromSchedule($schedule);

        $this->assertEquals(7, $schedule->Days()->count());
    }

    public function testCreateFromSchedule_ThreeDays_ReturnsDays()
    {
        $startDate = '2017-03-01'; // A Wednesday
        $endDate = '2017-03-03'; // A Friday
        $schedule = $this->createSchedule($startDate, $endDate);

        ScheduleDay::createFromSchedule($schedule);
        $daysIterator = $schedule->Days()->getIterator();

        $this->assertEquals(3, $schedule->Days()->count());

        $expectedDays = ['Wednesday', 'Thursday', 'Friday'];
        foreach ($expectedDays as $day) {
            $this->assertEquals($day, $daysIterator->current()->Day);
            $daysIterator->next();
        }
    }

    public function testCreateFromSchedule_ThreeDays_HappensOverWeekend_ReturnsDays()
    {
        $startDate = '2017-03-04'; // Saturday
        $endDate = '2017-03-06'; // Monday
        $schedule = $this->createSchedule($startDate, $endDate);

        ScheduleDay::createFromSchedule($schedule);
        $daysIterator = $schedule->Days()->getIterator();

        $this->assertEquals(3, $schedule->Days()->count());

        $expectedDays = ['Monday', 'Saturday', 'Sunday'];
        foreach ($expectedDays as $day) {
            $this->assertEquals($day, $daysIterator->current()->Day);
            $daysIterator->next();
        }
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