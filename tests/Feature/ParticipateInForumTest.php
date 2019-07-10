<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    public function testUnAuthUserMayNotAddreplies()
    {
        $this->withExceptionHandling()
            ->post($this->thread->getPath() . '/replies', [])
            ->assertRedirect('/login');
    }

    public function testAuthUserMayParticipateInForum()
    {
        $this->signIn();

        $reply = make('App\Reply');

        $this->post($this->thread->getPath() . '/replies', $reply->toArray());

        $this->get($this->thread->getPath())
            ->assertSee($reply->body);
    }
}
