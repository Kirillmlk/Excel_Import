<?php

namespace App\Jobs;

use App\Imports\ProjectImport;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportProjectExcelFileJob
{
    use Dispatchable, Queueable, SerializesModels;

    private $path;

    /**
     * Create a new job instance.
     */
    public function __construct($path)
    {
        $this->path = $path;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::import(new ProjectImport(), $this->path, 'public');
    }
}
