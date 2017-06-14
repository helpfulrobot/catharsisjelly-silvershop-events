# Silverstripe Events Module

I wanted to build a module for Silverstripe that uses [silvershop](https://github.com/silvershop/silvershop-core)
to supply an event and ticketing system. This is very early days for the module
and in heavy development, expect breakages.

## Installation

    composer require catharsisjelly/silvershop-events

## Models

### Event

An event is the actual thing that is happening. For example a long running
show in a theatre. This model only contains information about the event itself.

### Schedule

The Schedule is the start date and time and the end date and time. These would
be the dates that the event is running. If no StartTime is supplied then the
event is assumed to be happening all day (e.g. an exhibition in a museum). An
event can have multiple Schedules so that an Even could be on for a period of
time, take a break and then come back

### ScheduleDay

These are the days that the Schedule applies to. For instance your event might
be running for a week but only showing Monday, Wednesday and Friday

### Ticket

A Ticket belongs to an event, you can have multiple tickets available at
various prices (to cater for different seating). This may change in time
because a ticket could be for a certain day.
