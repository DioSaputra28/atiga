<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('general', function ($group): void {
            $group->add('company_name', 'Atiga');
            $group->add('company_logo', null);
            $group->add('company_favicon', null);

            $group->add('youtube_channel_name', null);
            $group->add('youtube_video_url_1', null);
            $group->add('youtube_video_url_2', null);
            $group->add('youtube_video_url_3', null);
            $group->add('youtube_video_url_4', null);

            $group->add('social_whatsapp', null);
            $group->add('social_tiktok', null);
            $group->add('social_facebook', null);
            $group->add('social_instagram', null);
            $group->add('social_threads', null);
            $group->add('social_youtube', null);

            $group->add('phone_number', null);
            $group->add('company_location', null);
            $group->add('operational_hours', null);
            $group->add('company_email', null);
        });
    }
};
