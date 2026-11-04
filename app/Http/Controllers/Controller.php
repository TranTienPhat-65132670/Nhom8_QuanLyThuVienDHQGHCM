<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

abstract class Controller
{
    // kiểm tra phiếu mượn có quá hạn không
    public static function syncOverdueBorrows()
    {
        DB::table('borrow')
            ->where('status', 'borrowing')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);
    }
}
