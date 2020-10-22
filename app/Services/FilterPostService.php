<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;

class FilterPostService
{
    protected $postQuery;

    public function __construct()
    {
        $this->postQuery = Post::query();
    }

    public function execute($filters)
    {
        if ($filters->user_id) {
            $this->postQuery->where('user_id', $filters->user_id);
        }

        if ($filters->category_id) {
            $this->postQuery->where('category_id', $filters->category_id);
        }

        if ($filters->text) {
            $this->postQuery->where(
                'body', 'like', '%' . $filters->text . '%'
            );
        }

        return $this->postQuery;
    }
}
