<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            
        
[
    'code' => '13234567418',
    'name' => 'NEUROSANBE 5000',
    'expiration_date' => '2026-01-30',
    'category_id' => 2,
    'stock' => 100,
    'price' => 35000,
    'unit' => 'TABLET',
    'description' => "Neurosanbe 5000 bermanfaat untuk mencegah dan mengatasi kekurangan vitamin B. Suplemen ini juga bisa digunakan untuk mengatasi gangguan saraf tepi atau neuropati perifer. Neurosanbe 5000 mengandung vitamin B1, B6, dan B12. Kombinasi ketiga jenis vitamin B ini baik untuk menjaga kesehatan saraf, serta meningkatkan stamina dan daya tahan tubuh.",
    'dosage' => "1 tablet per hari.",
    'weight' => 60,
],
[
    'code' => '13234567419',
    'name' => 'OSKADON OBAT SAKIT KEPALA',
    'expiration_date' => '2025-05-01',
    'category_id' => 2,
    'stock' => 64,
    'price' => 3000,
    'unit' => 'TABLET',
    'description' => "Oskadon mengandung paracetamol obat yang memiliki efek sebagai antipiretik sekaligus analgesik, selain paracetamol kandungan oskadon terdiri dari caffeine yaitu obat stimulan sistem saraf pusat berguna mencegah kantuk. Mengurangi sakit kepala, pusing, menghilangkan segala macam rasa nyeri, dan menghilangkan demam.",
    'dosage' => "Dewasa : 3-4 x sehari 1-2 tablet. Anak-anak : 3-4 x sehari 1/2-1 tablet.",
    'weight' => 60,
],
[
    'code' => '13234567420',
    'name' => 'PYREXIN',
    'expiration_date' => '2024-10-01',
    'category_id' => 2,
    'stock' => 140,
    'price' => 4000,
    'unit' => 'TABLET',
    'description' => "Pyrexin berisikan paracetmol 500mg dan diproduksi oleh PT. Meprofarm-Indonesia. Pyrexin telah terdaftar pada BPOM dengan no.registrasi DBL7615612610A1. Pyrexin dapat digunakan untuk pereda rasa nyeri dan pereda demam. Pyrexin dapat mengobati berbagai kondisi seperti sakit kepala, nyeri otot, arthritis, sakit punggung, sakit gigi, pilek, dan demam serta nyeri haid.",
    'dosage' => "3 kali sehari 1-2 tablet. maks. 8 tablet tiap hari.",
    'weight' => 60,
],
[
    'code' => '13234567421',
    'name' => 'PROMAG TABLET KUNYAH',
    'expiration_date' => '2026-09-01',
    'category_id' => 2,
    'stock' => 4,
    'price' => 17000,
    'unit' => 'TABLET',
    'description' => "PROMAG CHEW TAB 10S STRIP 3S merupakan obat kombinasi antara antasida dengan simetikon yang digunakan untuk terapi dyspepsia (maag) dengan mengurangi gejala maag seperti kembung, mual, dan bersendawa. Promag mengandung antasida Magnesium (Mg(OH)) dan Hydrotalcite dengan Simetikon yang dapat menetralkan asam lambung dan mengurangi gas yang berlebihan di saluran pencernaan (antiflatulen).",
    'dosage' => "Dewasa: 3-4 x sehari 1-2 tablet. Anak-anak 6-12 tahun: 3-4 x sehari 1/2-1 tablet.",
    'weight' => 60,
],
[
    'code' => '12334567422',
    'name' => 'PLANTACID FORTE',
    'expiration_date' => '2025-12-01',
    'category_id' => 2,
    'stock' => 20,
    'price' => 10000,
    'unit' => 'TABLET',
    'description' => "Plantacid Forte adalah obat maag untuk mengatasi gejala akibat kelebihan asam lambung. Keluhan yang bisa diatasi obat ini antara lain nyeri ulu hati atau rasa panas di dada, perut kembung atau begah, mual, dan muntah. Plantacid Forte mengandung aluminium hidroksida dan magnesium hidroksida sebagai antasida, serta simethicone sebagai pereda kembung. Kombinasi bahan ini bekerja dengan menetralkan asam lambung, serta mengurangi gas berlebih di saluran cerna. Alhasil, gejala asam lambung naik, termasuk perut kembung, bisa mereda.",
    'dosage' => "Dewasa: 1–2 tablet kunyah, 3–4 kali sehari. Anak usia 6–12 tahun: ½–1 tablet kunyah, 3–4 kali sehari.",
    'weight' => 60,
],
[
    'code' => '13234567423',
    'name' => 'POLYSILANE',
    'expiration_date' => '2027-05-01',
    'category_id' => 2,
    'stock' => 136,
    'price' => 10000,
    'unit' => 'TABLET',
    'description' => "Polysilane adalah obat untuk meredakan gejala sakit maag dan perut kembung akibat kelebihan asam lambung. Dokter juga dapat menggunakan polysilane dalam penanganan tukak lambung, ulkus duodenum, atau asam lambung naik (GERD). Polysilane mengandung bahan utama antasida, seperti aluminium hidroksida, magnesium hidroksida, dan kalsium karbonat. Antasida bekerja dengan cara menetralkan asam lambung sehingga bisa meredakan keluhan akibat peningkatan asam lambung, seperti nyeri ulu hati.",
    'dosage' => "Dewasa dan anak usia >12 tahun: 1–2 tablet, 3–4 kali sehari. Anak usia 6–12 tahun: ½–1 tablet atau kaplet, 3–4 kali sehari.",
    'weight' => 60,
],
[
    'code' => '13234567424',
    'name' => 'SAMTACID',
    'expiration_date' => '2026-02-01',
    'category_id' => 2,
    'stock' => 70,
    'price' => 4000,
    'unit' => 'TABLET',
    'description' => "Samtacid adalah obat yang digunakan untuk mengatasi penyakit-penyakit yang disebabkan oleh kelebihan produksi asam lambung, seperti sakit maag dan tukak lambung.",
    'dosage' => "Dewasa: 1-2 sdt (sendok takar) 3-4 kali/hari. Anak (6-12 tahun): 1/2 - 1 sdt 3-4 kali/hari.",
    'weight' => 60,
],
[
    'code' => '13234567425',
    'name' => 'SANMOL',
    'expiration_date' => '2026-03-16',
    'category_id' => 2,
    'stock' => 100,
    'price' => 3000,
    'unit' => 'TABLET',
    'description' => "Sanmol Tablet 500 mg adalah obat yang memiliki kandungan bahan aktif Paracetamol. Paracetamol bekerja dengan cara mengurangi kadar prostaglandin di dalam tubuh, sehingga tanda peradangan seperti demam dan nyeri akan berkurang. Obat ini digunakan untuk meringankan rasa sakit seperti sakit kepala, sakit gigi serta menurunkan demam.",
    'dosage' => "Dewasa: 1-2 tablet, diberikan sebanyak 3-4 kali per hari. Anak usia 6-12 tahun: ½-1 tablet, diberikan sebanyak 3-4 kali per hari.",
    'weight' => 60,
],
[
    'code' => '13234567426',
    'name' => 'SANMOL FORTE',
    'expiration_date' => '2026-03-16',
    'category_id' => 2,
    'stock' => 35,
    'price' => 6000,
    'unit' => 'TABLET',
    'description' => "Sanmol Forte adalah obat pereda rasa sakit yang dapat digunakan untuk mengatasi nyeri, sakit kepala, demam, serta nyeri haid. Obat ini mengandung Paracetamol yang efektif meredakan nyeri. Selain itu, Sanmol Forte juga berfungsi sebagai penurun demam. Sanmol Forte memiliki kelebihan dibandingkan Sanmol biasa, yaitu dosis Paracetamol yang lebih tinggi.",
    'dosage' => "Dewasa: 1 tablet, 2-3 kali sehari. Anak: 1/2 tablet, 2-3 kali sehari.",
    'weight' => 60,
],

[
    'code' => '13234567428',
    'name' => 'TRIANTA',
    'expiration_date' => '2026-12-01',
    'category_id' => 2,
    'stock' => 100,
    'price' => 4000,
    'unit' => 'TABLET',
    'description' => "Trianta adalah obat yang digunakan untuk menangani gangguan pencernaan, seperti asam lambung tinggi dan kembung. Obat ini mengandung aluminium hydroxide, magnesium hydroxide, dan simethicone. Aluminium hidroksida membantu menangani gejala akibat produksi asam lambung yang berlebihan. Sementara magnesium hidroksida bersama-sama dengan aluminium hidroksida membantu menetralkan asam lambung. Adapun simethicone dapat membantu mengurangi kembung, ketidaknyamanan dan rasa sakit karena gas yang berlebihan di dalam perut atau usus.",
    'dosage' => "Dewasa dan anak usia >12 tahun: 3 – 4 kali sehari sebanyak 1 – 2 tablet kunyah. Anak usia 6 – 12 tahun: 3 – 4 kali sehari sebanyak ½ - 1 tablet kunyah.",
    'weight' => 60,
],







            

          
        ];


        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }
}

