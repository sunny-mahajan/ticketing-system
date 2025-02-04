<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Allow API and Sanctum CSRF route
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5173'], // Frontend URL (DO NOT use '*')
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,  // Must be true for cookies/sessions
];
