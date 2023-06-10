<?php

namespace App\Jobs;

use App\Models\MoviePicture;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeleteMoviePictureFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $dateTime;

    /**
     * Create a new job instance.
     */
    public function __construct($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $moviePictures = MoviePicture::withTrashed()
            ->where('deleted_at', '<=', $this->dateTime)
            ->whereNotNull('deleted_at')
            ->get();

        foreach ($moviePictures as $moviePicture) {
            Storage::delete($moviePicture['path'] ?? '');
            $moviePicture->forceDelete();
        }
    }
}
