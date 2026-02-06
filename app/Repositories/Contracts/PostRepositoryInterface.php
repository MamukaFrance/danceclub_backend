<?php

namespace App\Repositories\Contracts;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function create(array $data): Post;

    public function all();

    public function find(int $id): ?Post;

    public function update(Post $post, array $data): Post;

    public function delete(Post $post): bool;
}