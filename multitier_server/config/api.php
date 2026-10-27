<?php

return [
    // Masa berlaku access token API dalam MENIT (sesuai spesifikasi: 1 menit)
    'token_ttl' => (int) env('API_TOKEN_TTL', 1),
];
