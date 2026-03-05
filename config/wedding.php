<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Down Payment Percentage
    |--------------------------------------------------------------------------
    | Percentage of total price charged as DP (e.g. 0.30 = 30%).
    | Change here without touching business logic code.
    */
    'dp_percentage' => env('WEDDING_DP_PERCENTAGE', 0.30),

    /*
    |--------------------------------------------------------------------------
    | DP Due Days
    |--------------------------------------------------------------------------
    | Number of days from wedding creation until DP invoice is due.
    */
    'dp_due_days' => env('WEDDING_DP_DUE_DAYS', 7),

    /*
    |--------------------------------------------------------------------------
    | Default Checklist Tasks
    |--------------------------------------------------------------------------
    */
    'default_checklist' => [
        ['category' => 'Persiapan', 'task_name' => 'Konfirmasi paket pernikahan'],
        ['category' => 'Persiapan', 'task_name' => 'Tentukan tanggal & venue'],
        ['category' => 'Vendor',    'task_name' => 'Konfirmasi vendor catering'],
        ['category' => 'Vendor',    'task_name' => 'Konfirmasi vendor dekorasi'],
        ['category' => 'Vendor',    'task_name' => 'Booking MUA (Make Up Artist)'],
        ['category' => 'Vendor',    'task_name' => 'Booking fotografer & videografer'],
        ['category' => 'Dokumen',   'task_name' => 'Urus surat nikah (KUA/Catatan Sipil)'],
        ['category' => 'Pakaian',   'task_name' => 'Fitting baju pengantin'],
        ['category' => 'Undangan',  'task_name' => 'Desain & cetak undangan'],
        ['category' => 'Undangan',  'task_name' => 'Kirim undangan tamu'],
        ['category' => 'H-7',       'task_name' => 'Final briefing semua vendor'],
        ['category' => 'H-1',       'task_name' => 'Gladi resik'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Milestones (days before wedding date)
    |--------------------------------------------------------------------------
    */
    'default_milestones' => [
        ['type' => 'dp_payment',       'title' => 'Pembayaran DP',          'days_before' => 90],
        ['type' => 'fitting',           'title' => 'Fitting Baju Pengantin', 'days_before' => 60],
        ['type' => 'technical_meeting', 'title' => 'Technical Meeting',      'days_before' => 30],
        ['type' => 'final_briefing',    'title' => 'Final Briefing Vendor',  'days_before' => 7],
        ['type' => 'rehearsal',         'title' => 'Gladi Resik',            'days_before' => 1],
        ['type' => 'wedding_day',       'title' => 'Hari Pernikahan',        'days_before' => 0],
    ],
];
