<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public function getViewData(): array
    {
        return Event::all()->toArray();
    }

    public function createEvent(array $data): void
    {
        Event::create($data);

        $this->refreshEvents();
    }

    public function editEvent(array $data): void
    {
        $this->event->update($data);

        $this->refreshEvents();
    }

    public function resolveEventRecord(array $data): Model
    {
        return Event::find($data['id']);
    }
}
