<?php

namespace Rennokki\QueryCache\Test;

use Cache;
use Rennokki\QueryCache\Test\Models\Post;

class PaginateTest extends TestCase
{
    public function test_paginate()
    {
        $posts = factory(Post::class, 30)->create();
        $storedPosts = Post::cacheFor(now()->addHours(1))->paginate(15);
        $postsCount = $posts->count();

        $totalCountCache = Cache::get('leqc:sqlitegetselect count(*) as aggregate from "posts"a:0:{}');
        $postsCache = Cache::get('leqc:sqlitegetselect * from "posts" limit 15 offset 0a:0:{}');

        $this->assertNotNull($totalCountCache);
        $this->assertNotNull($postsCache);

        $this->assertEquals(
            $totalCountCache->first()->aggregate,
            $postsCount
        );

        $this->assertEquals(15, $postsCache->count());
        $this->assertEquals(1, $postsCache->first()->id);
    }

    public function test_paginate_with_columns()
    {
        $posts = factory(Post::class, 30)->create();
        $storedPosts = Post::cacheFor(now()->addHours(1))->paginate(15, ['name']);
        $postsCount = $posts->count();

        $totalCountCache = Cache::get('leqc:sqlitegetselect count(*) as aggregate from "posts"a:0:{}');
        $postsCache = Cache::get('leqc:sqlitegetselect "name" from "posts" limit 15 offset 0a:0:{}');

        $this->assertNotNull($totalCountCache);
        $this->assertNotNull($postsCache);

        $this->assertEquals(
            $totalCountCache->first()->aggregate,
            $postsCount
        );

        $this->assertEquals(15, $postsCache->count());

        $this->assertEquals(
            $posts->first()->name,
            $postsCache->first()->name
        );
    }
}
