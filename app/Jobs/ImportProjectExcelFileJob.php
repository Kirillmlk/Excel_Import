<?php

namespace App\Jobs;

use App\Imports\ProjectImport;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportProjectExcelFileJob
{
    use Dispatchable, Queueable, SerializesModels;

    private $path;
    private $task;

    /**
     * Create a new job instance.
     * @param $path
     * @param $task
     */
    public function __construct($path, $task)
    {
        $this->path = $path;
        $this->task = $task;
    }


    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->task->update(['status' => Task::STATUS_SUCCESS]);
        Excel::import(new ProjectImport($this->task), $this->path, 'public');
    }
}
