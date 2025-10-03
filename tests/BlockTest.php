<?php

namespace stevecreekmore\LaravelLike\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use stevecreekmore\LaravelLike\Models\User;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_like_another_user()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user1->like($user2);

        $this->assertDatabaseHas('likes', [
            'user_id' => 1,
            'liking_id' => 2,
        ]);
    }

    /** @test */
    public function a_user_can_like_another_user_by_id()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user1->like($user2->id);

        $this->assertDatabaseHas('likes', [
            'user_id' => 1,
            'liking_id' => 2,
        ]);
    }

    /** @test */
    public function a_user_can_unlike_another_user()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user1->like($user2);
        $user1->unlike($user2);

        $this->assertDatabaseMissing('likes', [
            'user_id' => 1,
            'liking_id' => 2,
        ]);
    }

    /** @test */
    public function a_user_can_unlike_another_user_by_id()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user1->like($user2->id);
        $user1->unlike($user2->id);

        $this->assertDatabaseMissing('likes', [
            'user_id' => 1,
            'liking_id' => 2,
        ]);
    }

    /** @test */
    public function is_a_user_liking_another_user()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user1->like($user2);

        if ($user1->isliking($user2)) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    /** @test */
    public function is_a_user_liking_another_user_in_cache()
    {
        $user1 = User::create();
        $user2 = User::create();

        $this->actingAs($user1);

        $user1->like($user2);
        $user1->cacheliking();

        if ($user1->isliking($user2)) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    /** @test */
    public function is_a_user_liking_another_user_by_id()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user1->like($user2->id);

        if ($user1->isliking($user2->id)) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    /** @test */
    public function is_a_user_liked_by_another_user()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user1->like($user2);

        if ($user2->islikedBy($user1)) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    /** @test */
    public function is_a_user_liked_by_another_user_in_cache()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user2->like($user1);

        $this->actingAs($user1);

        auth()->user()->cachelikers();

        if (auth()->user()->islikedBy($user2)) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    /** @test */
    public function is_a_user_liked_by_another_user_by_id()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user1->like($user2->id);

        if ($user2->islikedBy($user1->id)) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    /** @test */
    public function it_gets_the_users_a_user_is_liking()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user1->like($user2);

        $liking = $user1->getliking();

        foreach ($liking as $item) {
            if ($item->liking->id === 2) {
                $this->assertTrue(true);
            } else {
                $this->fail();
            }
        }
    }

    /** @test */
    public function it_gets_the_ids_of_users_a_user_is_liking()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user1->like($user2);

        $likingIds = $user1->getlikingIds();

        $this->assertContains(2, $likingIds);
    }

    /** @test */
    public function it_gets_the_users_who_are_liking_a_user()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user2->like($user1);

        $likedBy = $user1->getlikers();

        foreach ($likedBy as $item) {
            if ($item->liking->id === 1) {
                $this->assertTrue(true);
            } else {
                $this->fail();
            }
        }
    }

    /** @test */
    public function it_gets_the_ids_of_users_who_are_liking_a_user()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user2->like($user1);

        $likedByIds = $user1->getlikersIds();

        $this->assertContains(2, $likedByIds);
    }

    /** @test */
    public function it_caches_the_ids_of_users_a_user_is_liking()
    {
        $user1 = User::create();
        $user2 = User::create();

        $this->actingAs($user1);

        auth()->user()->like($user2);
        auth()->user()->cacheliking();

        $this->assertContains(2, cache('liking.' . auth()->id()));
    }

    /** @test */
    public function it_gets_the_cached_ids_of_users_a_user_is_liking()
    {
        $user1 = User::create();
        $user2 = User::create();

        $this->actingAs($user1);

        auth()->user()->like($user2);
        auth()->user()->cacheliking();

        $this->assertContains(2, auth()->user()->getlikingCache());
    }

    /** @test */
    public function it_caches_the_ids_of_users_who_are_liking_a_user()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user2->like($user1);

        $this->actingAs($user1);

        auth()->user()->cachelikers();

        $this->assertContains(2, cache('likers.' . auth()->id()));
    }

    /** @test */
    public function it_gets_the_cached_ids_of_users_who_are_liking_a_user()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user2->like($user1);

        $this->actingAs($user1);

        auth()->user()->cachelikers();

        $this->assertContains(2, auth()->user()->getlikersCache());
    }

    /** @test */
    public function it_clears_the_cached_ids_of_users_who_are_liked_by_a_user()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user2->like($user1);

        $this->actingAs($user1);

        auth()->user()->cacheliking();

        auth()->user()->clearlikingCache();

        $cache = auth()->user()->getlikingCache();

        if (empty($cache)) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    /** @test */
    public function it_clears_the_cached_ids_of_users_who_are_liking_a_user()
    {
        $user1 = User::create();
        $user2 = User::create();

        $user2->like($user1);

        $this->actingAs($user1);

        auth()->user()->cachelikers();

        auth()->user()->clearlikersCache();

        $cache = auth()->user()->getlikersCache();

        if (empty($cache)) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }
}
