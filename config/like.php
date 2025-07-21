<?php

// config for stevecreekmore/LaravelLike
return [
    'uuid' => false,
    'user_foreign_key' => 'user_id',
    'likes_table' => 'likes',
    'like_model' => \stevecreekmore\LaravelLike\LaravelLike::class,
    'user_model' => class_exists(\App\Models\User::class) ? \App\Models\User::class : null,
];
