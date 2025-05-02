<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class seedUser extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            ['username' => 'soeprijadi', 'name' => 'Soeprijadi, S.Kom.', 'email' => 'sorprijadi@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'admin'],
            ['username' => 'tutug', 'name' => 'Tutug Ujiyanto, A.Kep', 'email' => 'ujiyantotutug91@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'nugraha', 'name' => 'Nugraha Priatmaja, S.Pd', 'email' => 'nugr22@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'adi', 'name' => 'Adi Waluyo, S.T', 'email' => 'adiwaluyoaddsoundadd@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'dhani', 'name' => 'Dhani Dwi Wijayanto, S.Pd', 'email' => 'dhaninto_wijaya@yahoo.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'sri', 'name' => 'Sri Muktiningsih, S.Pd', 'email' => 'srimuktiningsih56@gmail.com', 'password' => bcrypt ('sri54321'), 'role' => 'teller'],
            ['username' => 'ratna', 'name' => 'Ratna Kurniasih, S.Pd', 'email' => 'ratnakurniasihjava@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'cahyaning', 'name' => 'Cahyaning Dyah Respati, S.Pd', 'email' => 'shakiraalta@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'yuniah', 'name' => 'Yuniah Eka Rachmani, S.Pd.I', 'email' => 'yuniaheka88@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'kurnia', 'name' => 'Kurnia Dyah Arini, S. Pd', 'email' => 'arinydee@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'aries', 'name' => 'Aries Zam Zam N, S.Pd', 'email' => 'ariescokrownd@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'nikmatun', 'name' => 'Nikmatun Khasanah, S.Sos.I', 'email' => 'nikmatun@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'samsiyah', 'name' => 'Samsiyah, S.Kom', 'email' => 'samsiyahamir09@gmail.com', 'password' => bcrypt ('sam54321'), 'role' => 'teller'],
            ['username' => 'faisal', 'name' => 'Faisal Nur Hidayat, S.Pd.I', 'email' => 'faisalnurhidayat1989@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'fitri', 'name' => 'Fitri Mujiati, S.Pd', 'email' => 'fitrimujiati91@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'tofik', 'name' => 'Tofik Hidayatulloh, S.Pd.I', 'email' => 'tofik@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'siti', 'name' => 'Siti Maghfiroh, S.Pd', 'email' => 'sitimaghfirroh@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'septi', 'name' => 'Septi Melani, S.Pd', 'email' => 'septimelanie@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'eron', 'name' => 'Eron Khotim Abdulloh, S.Pd', 'email' => 'eronkhotimabdulloh@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'umar', 'name' => 'Umar Abdurrahman, S.Kom', 'email' => 'umarov.studio@gmail.com', 'password' => bcrypt ('admin123'), 'role' => 'admin'],
            ['username' => 'enggar', 'name' => 'Enggar Budi Prasetyo, S.Pd', 'email' => 'enggarbudhip@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'suswan', 'name' => 'Suswan, S.Pd', 'email' => 'suswanuny@gmail.com', 'password' => bcrypt ('admin123'), 'role' => 'guest'],
            ['username' => 'abdurrohman', 'name' => 'Abdurrohman H, S.Kom.', 'email' => 'habdurrohman9@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'guruh', 'name' => 'Guruh Susi Pangestuti, S.Pd.', 'email' => 'guruhgilar@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'dwi', 'name' => 'Dwi Agung Fitrianti, S.Pd., M.Pd.', 'email' => 'dwiagungfitrianti@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'allam', 'name' => 'Allam Raihan Zaky', 'email' => 'zakyarz01@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'difah', 'name' => 'Difah Ardini', 'email' => 'difah@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'septiarini', 'name' => 'Septiarini Sakiyah', 'email' => 'rini@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'akhmad', 'name' => 'Akhmad Heriyanto', 'email' => 'heriGL@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'annisa', 'name' => 'Annisa Maulida Ikhsanti', 'email' => 'anisa@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'kartika', 'name' => 'Kartika Eka Milasari, S.Pd.', 'email' => 'kartika@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'indriana', 'name' => 'Indriana Nur Vantari, S.Pd', 'email' => 'indriana@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'sripur', 'name' => 'Sri Purwaningsih', 'email' => 'srisa@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'bayu', 'name' => 'Bayu Aji Wibowo, S.Pd.', 'email' => 'senjawibowo99@gmail.com', 'password' => bcrypt ('admin123'), 'role' => 'admin'],
            ['username' => 'heni', 'name' => 'Fajriyatun Nugraheni, S.I.Pust', 'email' => 'heni@smk.com', 'password' => bcrypt ('heni54321'), 'role' => 'teller'],
            ['username' => 'herva', 'name' => 'Herva Liliani', 'email' => 'herva@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'yuli', 'name' => 'Yuli Setyawati', 'email' => 'yuli@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'elisa', 'name' => 'Elisa Maulidatun', 'email' => 'elisa@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
        ]);
    }
}
