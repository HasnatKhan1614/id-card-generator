<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Organization
    |--------------------------------------------------------------------------
    |
    | Shown on printed ID cards. Campuses and classes are managed in the
    | database (Campuses / Classes modules).
    |
    */

    'organization' => env('IDCARD_ORG', 'Demo Academy'),
    'tagline' => env('IDCARD_TAGLINE', 'Student Identity Card'),

];
