<?php

namespace App\Observers;

use App\Models\Attendee;

class AttendeeObserver
{
    /**
     * Handle the Attendee "created" event.
     */
    public function created(Attendee $attendee): void
    {
        //
    }

    /**
     * Handle the Attendee "updated" event.
     */
    public function updated(Attendee $attendee): void
    {
        //
    }

    /**
     * Handle the Attendee "deleted" event.
     */
    public function deleted(Attendee $attendee): void
    {
        //
    }

    /**
     * Handle the Attendee "restored" event.
     */
    public function restored(Attendee $attendee): void
    {
        //
    }

    /**
     * Handle the Attendee "force deleted" event.
     */
    public function forceDeleted(Attendee $attendee): void
    {
        //
    }

    public function creating (Attendee $attendee): void
    {
        $attendee->created_by= auth()->id();
        $attendee->updated_by= auth()->id();
    }

    public function updating (Attendee $attendee): void {
        $attendee->updated_by= auth()->id();
    }
}
