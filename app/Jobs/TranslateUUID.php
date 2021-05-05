<?php

namespace App\Jobs;

use App\Models\ShortId;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateUUID implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ShortId::create([
            'file_id' => $this->data["file_id"],
            'model_id' => $this->data["model_id"],
            'group' => $this->data["group"],
            'type' => $this->data["type"],
            'short_id' => sprintf("%s_%d", $this->data["group"], $this->data["position"]),
        ]);
    }
}
