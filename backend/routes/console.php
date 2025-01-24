<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:generate-daily-report')->daily();

Schedule::command('queue:work --stop-when-empty')
    ->everyMinute()
    ->withoutOverlapping();
