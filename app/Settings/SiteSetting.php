<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSetting extends Settings
{
    public string $company_name;

    public ?string $company_logo;

    public ?string $company_favicon;

    public ?string $youtube_channel_name;

    public ?string $youtube_video_url_1;

    public ?string $youtube_video_url_2;

    public ?string $youtube_video_url_3;

    public ?string $youtube_video_url_4;

    public ?string $social_whatsapp;

    public ?string $social_tiktok;

    public ?string $social_facebook;

    public ?string $social_instagram;

    public ?string $social_threads;

    public ?string $social_youtube;

    public ?string $phone_number;

    public ?string $company_location;

    public ?string $operational_hours;

    public ?string $company_email;

    public static function group(): string
    {
        return 'general';
    }
}
