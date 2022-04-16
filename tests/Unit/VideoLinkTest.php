<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Product;
use App\Models\VideoLink;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoLinkTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_videoLink()
    {
        $video = $this->post('/video', [
            'video' => 'https://www.youtube.com/watch?v=K4TOrB7at0Y',
        ]);

        $video->assertStatus($video->status(), 302);
    }
}
