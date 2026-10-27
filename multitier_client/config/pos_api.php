<?php

return [
    // Alamat API multitier_server
    'base_url' => rtrim(env('API_BASE_URL', 'http://127.0.0.1:8000/api'), '/'),
    'timeout' => (int) env('API_TIMEOUT', 10),
];
