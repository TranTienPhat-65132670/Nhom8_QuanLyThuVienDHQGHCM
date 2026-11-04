<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_login_page_returns_a_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
    }

    public function test_admin_can_publish_text_only_news_without_sending_email(): void
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
            $table->timestamps();
        });

        DB::table('user')->insert([
            'user_id' => 'admin-id',
            'role' => 'admin',
            'email' => 'admin@example.test',
            'student_name' => 'Admin',
        ]);

        Mail::fake();

        $invalidResponse = $this->withSession([
            'user_id' => 'admin-id',
            'role' => 'admin',
        ])->post(route('admin.news.store'), [
            'title' => '   ',
            'content' => '',
        ]);

        $invalidResponse->assertSessionHasErrors(['title', 'content']);

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
            'body' => 'Article body',
            'status' => 1,
        ]);

        $postId = DB::table('post')->where('title', 'News without an image')->value('post_id');
        $invalidUpdateResponse = $this->withSession([
            'user_id' => 'admin-id',
            'role' => 'admin',
        ])->put(route('admin.news.update', $postId), [
            'title' => '',
            'content' => '   ',
        ]);

        $invalidUpdateResponse->assertSessionHasErrors(['title', 'content']);
        Mail::assertNothingOutgoing();
    }

    public function test_latest_posts_are_shown_in_the_member_homepage_notice_panel(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->string('user_id')->primary();
            $table->string('role');
            $table->string('student_code')->nullable();
            $table->string('student_name')->nullable();
        });

        Schema::create('book', function (Blueprint $table) {
            $table->increments('book_id');
            $table->integer('category_id')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('post', function (Blueprint $table) {
            $table->increments('post_id');
            $table->string('user_id');
            $table->string('title');
            $table->text('body')->nullable();
            $table->boolean('status');
            $table->string('slug');
            $table->timestamps();
        });

        DB::table('user')->insert([
            'user_id' => 'member-id',
            'role' => 'member',
            'student_code' => '12345678',
        ]);
        DB::table('post')->insert([
            [
                'user_id' => 'member-id',
                'title' => 'Latest library notice',
                'body' => 'Notice content appears on the homepage.',
                'status' => 1,
                'slug' => 'latest-library-notice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 'member-id',
                'title' => 'Unpublished draft',
                'body' => 'This draft should remain hidden.',
                'status' => 0,
                'slug' => 'unpublished-draft',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->withSession([
            'user_id' => 'member-id',
            'role' => 'member',
        ])->get('/');

        $response->assertOk()
            ->assertSee('Latest library notice')
            ->assertSee('Notice content appears on the homepage.')
            ->assertSee('data-news-title="Latest library notice"', false)
            ->assertSee('id="news-detail-modal"', false)
            ->assertDontSee('Unpublished draft');
    }

    public function test_public_news_can_be_filtered_by_date_and_is_paginated_ten_per_page(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->string('user_id')->primary();
            $table->string('student_name')->nullable();
        });

        Schema::create('post', function (Blueprint $table) {
            $table->increments('post_id');
            $table->string('user_id');
            $table->string('title');
            $table->text('body')->nullable();
            $table->boolean('status');
            $table->string('slug');
            $table->timestamps();
        });

        DB::table('user')->insert([
            'user_id' => 'admin-id',
            'student_name' => 'Admin',
        ]);

        $today = now()->startOfDay();
        $posts = [];

        for ($number = 1; $number <= 12; $number++) {
            $createdAt = $today->copy()->addMinutes($number);
            $posts[] = [
                'user_id' => 'admin-id',
                'title' => "Notice {$number}",
                'body' => "Content {$number}",
                'status' => 1,
                'slug' => "notice-{$number}",
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        $yesterday = $today->copy()->subDay();
        $posts[] = [
            'user_id' => 'admin-id',
            'title' => 'Yesterday notice',
            'body' => 'Outside selected date range',
            'status' => 1,
            'slug' => 'yesterday-notice',
            'created_at' => $yesterday,
            'updated_at' => $yesterday,
        ];
        DB::table('post')->insert($posts);

        $date = $today->toDateString();
        $firstPage = $this->get(route('news.index', [
            'date_from' => $date,
            'date_to' => $date,
        ]));

        $firstPage->assertOk()
            ->assertSee('Notice 12')
            ->assertSee('Notice 3')
            ->assertDontSee('Notice 2')
            ->assertDontSee('Yesterday notice')
            ->assertSee('page=2', false);

        $secondPage = $this->get(route('news.index', [
            'date_from' => $date,
            'date_to' => $date,
            'page' => 2,
        ]));

        $secondPage->assertOk()
            ->assertSee('Notice 2')
            ->assertSee('Notice 1')
            ->assertDontSee('Notice 12')
            ->assertDontSee('Yesterday notice');
    }
}
