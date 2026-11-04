<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_login_page_returns_a_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
    }

    public function test_admin_can_publish_news_without_an_image(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->string('user_id')->primary();
            $table->string('role');
            $table->string('email')->nullable();
            $table->string('student_name')->nullable();
        });

        Schema::create('post', function (Blueprint $table) {
            $table->increments('post_id');
            $table->string('user_id');
            $table->string('title');
            $table->text('body')->nullable();
            $table->boolean('status');
            $table->string('slug');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });

        DB::table('user')->insert([
            'user_id' => 'admin-id',
            'role' => 'admin',
            'email' => 'admin@example.test',
            'student_name' => 'Admin',
        ]);

        Storage::fake('public');

        $response = $this->withSession([
            'user_id' => 'admin-id',
            'role' => 'admin',
        ])->post(route('admin.news.store'), [
            'title' => 'News without an image',
            'content' => 'Article body',
        ]);

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('post', [
            'title' => 'News without an image',
            'image_path' => null,
        ]);
    }
}
