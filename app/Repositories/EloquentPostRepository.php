<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;

class EloquentPostRepository implements PostRepositoryInterface
{
    public function create(array $data): Post
    {
        return Post::create($data);
    }

     public function all()
    {
        return Post::orderBy('created_at', 'desc')->get();
    }

    public function find(int $id): ?Post
    {
        return Post::find($id);
    }

     public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post;
    }

     public function delete(Post $post): bool
    {
        return $post->delete();
    }
}