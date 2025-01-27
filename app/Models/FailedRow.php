<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedRow extends Model
{
    protected $quarded = false;
    protected $table = 'failed_rows';

    private static function insertFailedRows($items, $task)
    {
        foreach ($items as $item) {
            FailedRow::create($item);
        }
        $task->update(['status' => Task::STATUS_ERROR]);
    }
}
