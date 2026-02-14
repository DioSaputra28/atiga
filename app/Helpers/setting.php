<?php

use App\Settings\SiteSetting;

if (! function_exists('site_setting')) {
    function site_setting(string $key, mixed $default = null): mixed
    {
        try {
            $settings = app(SiteSetting::class);

            return data_get($settings, $key, $default);
        } catch (Throwable) {
            return $default;
        }
    }
}

if (! function_exists('site_company_name')) {
    function site_company_name(?string $default = null): ?string
    {
        return site_setting('company_name', $default);
    }
}

if (! function_exists('site_company_logo')) {
    function site_company_logo(?string $default = null): ?string
    {
        return site_setting('company_logo', $default);
    }
}

if (! function_exists('site_company_favicon')) {
    function site_company_favicon(?string $default = null): ?string
    {
        return site_setting('company_favicon', $default);
    }
}

if (! function_exists('site_youtube_channel_name')) {
    function site_youtube_channel_name(?string $default = null): ?string
    {
        return site_setting('youtube_channel_name', $default);
    }
}

if (! function_exists('site_youtube_video_url_1')) {
    function site_youtube_video_url_1(?string $default = null): ?string
    {
        return site_setting('youtube_video_url_1', $default);
    }
}

if (! function_exists('site_youtube_video_url_2')) {
    function site_youtube_video_url_2(?string $default = null): ?string
    {
        return site_setting('youtube_video_url_2', $default);
    }
}

if (! function_exists('site_youtube_video_url_3')) {
    function site_youtube_video_url_3(?string $default = null): ?string
    {
        return site_setting('youtube_video_url_3', $default);
    }
}

if (! function_exists('site_youtube_video_url_4')) {
    function site_youtube_video_url_4(?string $default = null): ?string
    {
        return site_setting('youtube_video_url_4', $default);
    }
}

if (! function_exists('site_social_whatsapp')) {
    function site_social_whatsapp(?string $default = null): ?string
    {
        return site_setting('social_whatsapp', $default);
    }
}

if (! function_exists('site_social_tiktok')) {
    function site_social_tiktok(?string $default = null): ?string
    {
        return site_setting('social_tiktok', $default);
    }
}

if (! function_exists('site_social_facebook')) {
    function site_social_facebook(?string $default = null): ?string
    {
        return site_setting('social_facebook', $default);
    }
}

if (! function_exists('site_social_instagram')) {
    function site_social_instagram(?string $default = null): ?string
    {
        return site_setting('social_instagram', $default);
    }
}

if (! function_exists('site_social_threads')) {
    function site_social_threads(?string $default = null): ?string
    {
        return site_setting('social_threads', $default);
    }
}

if (! function_exists('site_social_youtube')) {
    function site_social_youtube(?string $default = null): ?string
    {
        return site_setting('social_youtube', $default);
    }
}

if (! function_exists('site_phone_number')) {
    function site_phone_number(?string $default = null): ?string
    {
        return site_setting('phone_number', $default);
    }
}

if (! function_exists('site_company_location')) {
    function site_company_location(?string $default = null): ?string
    {
        return site_setting('company_location', $default);
    }
}

if (! function_exists('site_operational_hours')) {
    function site_operational_hours(?string $default = null): ?string
    {
        return site_setting('operational_hours', $default);
    }
}

if (! function_exists('site_company_email')) {
    function site_company_email(?string $default = null): ?string
    {
        return site_setting('company_email', $default);
    }
}
