<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notification.{userId}', function ($user) {
    return true;
});