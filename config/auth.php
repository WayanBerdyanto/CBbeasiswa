<?php

return [

    'defaults' => [
        'guard' => 'mahasiswa', // ganti dari 'web'
        'passwords' => 'users',
    ],


    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

        // Tambahan untuk mahasiswa
        'mahasiswa' => [
            'driver' => 'session',
            'provider' => 'mahasiswa',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // Tambahan provider mahasiswa
        'mahasiswa' => [
            'driver' => 'eloquent',
            'model' => App\Models\Mahasiswa::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        // Kalau kamu ingin reset password khusus mahasiswa, bisa tambahkan ini juga:
        // 'mahasiswa' => [
        //     'provider' => 'mahasiswa',
        //     'table' => 'password_resets',
        //     'expire' => 60,
        //     'throttle' => 60,
        // ],
    ],

    'password_timeout' => 10800,

];
