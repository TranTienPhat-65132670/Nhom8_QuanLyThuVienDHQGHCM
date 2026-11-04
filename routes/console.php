<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// tự động chạy mỗi ngày để kiểm tra các phiếu mượn có còn hạn không
Schedule::call(function () {
    DB::table('borrow')
        ->where('status', 'borrowing')
        ->where('due_date', '<', now())
        ->update(['status' => 'overdue']);
})->daily();
