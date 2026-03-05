<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'company_name',    'value' => 'The Royal Wedding by Ully Sjah', 'type' => 'text',     'group' => 'general',      'label' => 'Nama Perusahaan'],
            ['key' => 'company_tagline', 'value' => 'Luxury Wedding Organizer',        'type' => 'text',     'group' => 'general',      'label' => 'Tagline'],
            ['key' => 'company_email',   'value' => 'hello@royalwedding.id',            'type' => 'email',    'group' => 'general',      'label' => 'Email Perusahaan'],
            ['key' => 'company_phone',   'value' => '6281234567890',                   'type' => 'phone',    'group' => 'general',      'label' => 'Nomor WhatsApp'],
            ['key' => 'company_address', 'value' => 'Jakarta Selatan, Indonesia',       'type' => 'text',     'group' => 'general',      'label' => 'Alamat'],
            // Social
            ['key' => 'instagram',       'value' => 'https://instagram.com/royalweddingullysjah', 'type' => 'url', 'group' => 'social', 'label' => 'Instagram'],
            ['key' => 'facebook',        'value' => '',                                'type' => 'url',      'group' => 'social',       'label' => 'Facebook'],
            ['key' => 'tiktok',          'value' => '',                                'type' => 'url',      'group' => 'social',       'label' => 'TikTok'],
            ['key' => 'youtube',         'value' => '',                                'type' => 'url',      'group' => 'social',       'label' => 'YouTube'],
            // Branding
            ['key' => 'hero_headline',   'value' => 'Pernikahan Impian Anda,\nDiwujudkan dengan Keanggunan', 'type' => 'textarea', 'group' => 'branding', 'label' => 'Hero Headline'],
            ['key' => 'hero_sub',        'value' => 'Kami merancang setiap detail dengan penuh cinta dan presisi untuk hari terpenting dalam hidup Anda.', 'type' => 'textarea', 'group' => 'branding', 'label' => 'Hero Subtext'],
            // Notification
            ['key' => 'notif_email_enabled', 'value' => '1', 'type' => 'text', 'group' => 'notification', 'label' => 'Email Notifikasi Aktif (1/0)'],
            ['key' => 'notif_wa_enabled',    'value' => '0', 'type' => 'text', 'group' => 'notification', 'label' => 'WhatsApp Notifikasi Aktif (1/0)'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
