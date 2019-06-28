<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{

    use DatabaseMigrations;

    protected $thread;

    public function setUp() :void {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {   
        $response = $this->get('/threads')  
                       ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_a_thread()
    { 
       $response = $this->get('/threads/'.$this->thread->id)  
                       ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_may_see_a_replies_associated_with_the_threads()
    {
        $reply = factory('App\Reply')->create(["thread_id" => $this->thread->id]);
        $response = $this->get('/threads/'.$this->thread->id)  
                       ->assertSee($reply->body);
    }
}
 