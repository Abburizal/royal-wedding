<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $portfolios = [
            ['title' => 'A Night of Eternal Gold', 'couple_names' => 'Rania & Farhan', 'wedding_date' => '2024-11-15', 'location' => 'The Ritz-Carlton, Jakarta', 'description' => 'Pernikahan mewah bertema gold & ivory dengan sentuhan bunga peonies putih dan chandelier kristal yang memukau.', 'is_featured' => true, 'cover_image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&q=80', 'sort_order' => 1],
            ['title' => 'Garden of Eden', 'couple_names' => 'Nadira & Rizky', 'wedding_date' => '2024-09-20', 'location' => 'Ayana Resort, Bali', 'description' => 'Pernikahan outdoor di tepi tebing Bali dengan dekorasi greenery, bunga tropis, dan matahari terbenam yang romantis.', 'is_featured' => true, 'cover_image' => 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=800&q=80', 'sort_order' => 2],
            ['title' => 'Timeless Elegance', 'couple_names' => 'Syafira & Daffa', 'wedding_date' => '2024-07-08', 'location' => 'Shangri-La, Surabaya', 'description' => 'Nuansa putih bersih dengan aksen rose gold, floral arrangement mawar merah, dan pencahayaan warm yang dramatis.', 'is_featured' => true, 'cover_image' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800&q=80', 'sort_order' => 3],
            ['title' => 'Royal Palace Wedding', 'couple_names' => 'Amira & Hafizh', 'wedding_date' => '2024-05-12', 'location' => 'Grand Hyatt, Jakarta', 'description' => 'Tema kerajaan klasik dengan mahkota floral, karpet merah, dan dekorasi baroque yang mewah dan megah.', 'is_featured' => false, 'cover_image' => 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=800&q=80', 'sort_order' => 4],
            ['title' => 'Midnight in Paris', 'couple_names' => 'Celeste & Andi', 'wedding_date' => '2024-03-30', 'location' => 'Hotel Indonesia Kempinski', 'description' => 'Inspirasi romantisme Paris — bunga lavender, lilin-lilin berkelip, dan nuansa twilight blue yang menawan.', 'is_featured' => false, 'cover_image' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800&q=80', 'sort_order' => 5],
            ['title' => 'Whispers of Jasmine', 'couple_names' => 'Hana & Raditya', 'wedding_date' => '2024-01-20', 'location' => 'Villa Padi, Bandung', 'description' => 'Pernikahan intimate dengan nuansa rustic-chic, bunga melati segar, dan cahaya golden hour yang hangat.', 'is_featured' => false, 'cover_image' => 'https://images.unsplash.com/photo-1529636444744-adffc9135a5e?w=800&q=80', 'sort_order' => 6],
        ];

        foreach ($portfolios as $data) {
            Portfolio::create($data);
        }

        $testimonials = [
            ['client_name' => 'Rania Putri', 'couple_names' => 'Rania & Farhan', 'wedding_date' => '2024-11-15', 'content' => 'Tidak ada kata yang cukup untuk menggambarkan betapa indahnya hari pernikahan kami. Kak Ully dan tim benar-benar memahami visi kami dan mewujudkannya melampaui ekspektasi. Setiap detail sempurna, setiap momen ajaib. Terima kasih sudah membuat hari terbaik kami jadi semakin tak terlupakan.', 'rating' => 5, 'is_published' => true, 'sort_order' => 1],
            ['client_name' => 'Nadira Salsabila', 'couple_names' => 'Nadira & Rizky', 'wedding_date' => '2024-09-20', 'content' => 'The Royal Wedding adalah pilihan terbaik yang pernah kami buat. Profesional, responsif, dan sangat kreatif. Dekorasi Bali kami persis seperti yang kami impikan, bahkan lebih cantik. Wedding di tebing Ayana terasa seperti dongeng.', 'rating' => 5, 'is_published' => true, 'sort_order' => 2],
            ['client_name' => 'Syafira Ananda', 'couple_names' => 'Syafira & Daffa', 'wedding_date' => '2024-07-08', 'content' => 'Saya sangat terkesan dengan sistem manajemen yang sangat terorganisir. Dari awal hingga hari H, segalanya berjalan mulus. Ully Sjah benar-benar seorang profesional yang berdedikasi. Vendor-vendor yang direkomendasikan juga luar biasa kualitasnya.', 'rating' => 5, 'is_published' => true, 'sort_order' => 3],
            ['client_name' => 'Amira Khairunnisa', 'couple_names' => 'Amira & Hafizh', 'wedding_date' => '2024-05-12', 'content' => 'Tim Royal Wedding sangat tanggap dan penuh perhatian. Mereka benar-benar mendengarkan semua keinginan kami, bahkan hal-hal kecil pun tidak terlewat. Hasil akhirnya? Sempurna. Tamu undangan kami masih membicarakan betapa indahnya resepsi kami.', 'rating' => 5, 'is_published' => true, 'sort_order' => 4],
            ['client_name' => 'Hana Maharani', 'couple_names' => 'Hana & Raditya', 'wedding_date' => '2024-01-20', 'content' => 'Kami memilih paket Silver namun hasilnya terasa setara dengan pernikahan kelas premium. Kak Ully benar-benar mengoptimalkan setiap detail dengan budget yang ada. Sangat merekomendasikan untuk pasangan yang ingin pernikahan elegan tanpa drama.', 'rating' => 5, 'is_published' => true, 'sort_order' => 5],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create($data);
        }
    }
}
