<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name'           => 'Paket Silver',
                'slug'           => 'silver',
                'tier'           => 'silver',
                'price'          => 45_000_000,
                'description'    => 'Paket elegan untuk pernikahan intim yang berkesan. Sempurna untuk 100-150 tamu dengan pelayanan profesional.',
                'guest_capacity' => 150,
                'sort_order'     => 1,
                'items' => [
                    ['item_name' => 'Wedding Planner Dedicated', 'category' => 'Tim', 'quantity' => 1],
                    ['item_name' => 'Dekorasi Pelaminan & Altar', 'category' => 'Dekorasi', 'quantity' => 1],
                    ['item_name' => 'Catering Premium (100 pax)', 'category' => 'Catering', 'quantity' => 100],
                    ['item_name' => 'Fotografer Profesional', 'category' => 'Dokumentasi', 'quantity' => 1],
                    ['item_name' => 'Videografer (Highlight 3 menit)', 'category' => 'Dokumentasi', 'quantity' => 1],
                    ['item_name' => 'MUA Pengantin & Sesi Akad', 'category' => 'MUA', 'quantity' => 1],
                    ['item_name' => 'Bunga & Floral Arrangement', 'category' => 'Dekorasi', 'quantity' => 1],
                    ['item_name' => 'MC Profesional', 'category' => 'Entertainment', 'quantity' => 1],
                ],
            ],
            [
                'name'           => 'Paket Gold',
                'slug'           => 'gold',
                'tier'           => 'gold',
                'price'          => 85_000_000,
                'description'    => 'Pengalaman pernikahan mewah yang komprehensif. Ideal untuk 200-300 tamu dengan vendor premium pilihan.',
                'guest_capacity' => 300,
                'sort_order'     => 2,
                'items' => [
                    ['item_name' => 'Senior Wedding Planner + Asisten', 'category' => 'Tim', 'quantity' => 2],
                    ['item_name' => 'Dekorasi Full Venue (Indoor/Outdoor)', 'category' => 'Dekorasi', 'quantity' => 1],
                    ['item_name' => 'Catering Premium (200 pax)', 'category' => 'Catering', 'quantity' => 200],
                    ['item_name' => '2 Fotografer + Drone Shot', 'category' => 'Dokumentasi', 'quantity' => 2],
                    ['item_name' => 'Videografer Full Day (Film Cinematic)', 'category' => 'Dokumentasi', 'quantity' => 1],
                    ['item_name' => 'MUA Premium (Pengantin + Ibu)', 'category' => 'MUA', 'quantity' => 2],
                    ['item_name' => 'Live Music / Band 4 jam', 'category' => 'Entertainment', 'quantity' => 1],
                    ['item_name' => 'Buket & Corsage Pengantin', 'category' => 'Dekorasi', 'quantity' => 1],
                    ['item_name' => 'Souvenir Tamu Eksklusif', 'category' => 'Lainnya', 'quantity' => 200],
                    ['item_name' => 'Wedding Cake 3 Tier', 'category' => 'Catering', 'quantity' => 1],
                ],
            ],
            [
                'name'           => 'Paket Royal',
                'slug'           => 'royal',
                'tier'           => 'royal',
                'price'          => 175_000_000,
                'description'    => 'Pengalaman pernikahan paling prestisius. Tidak ada kompromi — setiap detail dirancang untuk kesempurnaan.',
                'guest_capacity' => 500,
                'sort_order'     => 3,
                'items' => [
                    ['item_name' => 'Royal Wedding Director + Tim 5 orang', 'category' => 'Tim', 'quantity' => 5],
                    ['item_name' => 'Dekorasi Royal Full Venue + Backdrop Custom', 'category' => 'Dekorasi', 'quantity' => 1],
                    ['item_name' => 'Catering Fine Dining (300 pax)', 'category' => 'Catering', 'quantity' => 300],
                    ['item_name' => 'Tim Fotografer Premium (3 orang + Drone 4K)', 'category' => 'Dokumentasi', 'quantity' => 3],
                    ['item_name' => 'Videografer Cinematic Full Day + Teaser', 'category' => 'Dokumentasi', 'quantity' => 1],
                    ['item_name' => 'MUA Celebrity Grade (seluruh keluarga inti)', 'category' => 'MUA', 'quantity' => 5],
                    ['item_name' => 'Live Band Premium + String Quartet', 'category' => 'Entertainment', 'quantity' => 1],
                    ['item_name' => 'Florist Premium dengan Bunga Import', 'category' => 'Dekorasi', 'quantity' => 1],
                    ['item_name' => 'Souvenir Mewah Custom Branding', 'category' => 'Lainnya', 'quantity' => 300],
                    ['item_name' => 'Wedding Cake Custom 5 Tier', 'category' => 'Catering', 'quantity' => 1],
                    ['item_name' => 'Honeymoon Package (2 malam hotel bintang 5)', 'category' => 'Lainnya', 'quantity' => 1],
                    ['item_name' => 'Koordinasi Hari-H penuh (10 jam)', 'category' => 'Tim', 'quantity' => 1],
                ],
            ],
        ];

        foreach ($packages as $data) {
            $items = $data['items'];
            unset($data['items']);

            $package = Package::create($data);

            foreach ($items as $i => $item) {
                PackageItem::create(array_merge($item, [
                    'package_id' => $package->id,
                    'sort_order' => $i,
                ]));
            }
        }
    }
}
