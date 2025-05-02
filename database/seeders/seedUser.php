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
            ['username' => 'soeprijadi', 'nama' => 'Soeprijadi, S.Kom.', 'email' => 'sorprijadi@smk.com', 'password' => bcrypt ('admin123'), 'role' => 'admin'],
            ['username' => 'tutug', 'nama' => 'Tutug Ujiyanto, A.Kep', 'email' => 'ujiyantotutug91@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'nugraha', 'nama' => 'Nugraha Priatmaja, S.Pd', 'email' => 'nugr22@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'adi', 'nama' => 'Adi Waluyo, S.T', 'email' => 'adiwaluyoaddsoundadd@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'dhani', 'nama' => 'Dhani Dwi Wijayanto, S.Pd', 'email' => 'dhaninto_wijaya@yahoo.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'sri', 'nama' => 'Sri Muktiningsih, S.Pd', 'email' => 'srimuktiningsih56@gmail.com', 'password' => bcrypt ('sri54321'), 'role' => 'teller'],
            ['username' => 'ratna', 'nama' => 'Ratna Kurniasih, S.Pd', 'email' => 'ratnakurniasihjava@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'cahyaning', 'nama' => 'Cahyaning Dyah Respati, S.Pd', 'email' => 'shakiraalta@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'yuniah', 'nama' => 'Yuniah Eka Rachmani, S.Pd.I', 'email' => 'yuniaheka88@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'kurnia', 'nama' => 'Kurnia Dyah Arini, S. Pd', 'email' => 'arinydee@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'aries', 'nama' => 'Aries Zam Zam N, S.Pd', 'email' => 'ariescokrownd@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'nikmatun', 'nama' => 'Nikmatun Khasanah, S.Sos.I', 'email' => 'nikmatun@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'samsiyah', 'nama' => 'Samsiyah, S.Kom', 'email' => 'samsiyahamir09@gmail.com', 'password' => bcrypt ('sam54321'), 'role' => 'teller'],
            ['username' => 'faisal', 'nama' => 'Faisal Nur Hidayat, S.Pd.I', 'email' => 'faisalnurhidayat1989@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'fitri', 'nama' => 'Fitri Mujiati, S.Pd', 'email' => 'fitrimujiati91@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'tofik', 'nama' => 'Tofik Hidayatulloh, S.Pd.I', 'email' => 'tofik@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'siti', 'nama' => 'Siti Maghfiroh, S.Pd', 'email' => 'sitimaghfirroh@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'septi', 'nama' => 'Septi Melani, S.Pd', 'email' => 'septimelanie@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'eron', 'nama' => 'Eron Khotim Abdulloh, S.Pd', 'email' => 'eronkhotimabdulloh@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'umar', 'nama' => 'Umar Abdurrahman, S.Kom', 'email' => 'umarov.studio@gmail.com', 'password' => bcrypt ('admin123'), 'role' => 'admin'],
            ['username' => 'enggar', 'nama' => 'Enggar Budi Prasetyo, S.Pd', 'email' => 'enggarbudhip@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'suswan', 'nama' => 'Suswan, S.Pd', 'email' => 'suswanuny@gmail.com', 'password' => bcrypt ('admin123'), 'role' => 'guest'],
            ['username' => 'abdurrohman', 'nama' => 'Abdurrohman H, S.Kom.', 'email' => 'habdurrohman9@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'guruh', 'nama' => 'Guruh Susi Pangestuti, S.Pd.', 'email' => 'guruhgilar@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'dwi', 'nama' => 'Dwi Agung Fitrianti, S.Pd., M.Pd.', 'email' => 'dwiagungfitrianti@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'allam', 'nama' => 'Allam Raihan Zaky', 'email' => 'zakyarz01@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'difah', 'nama' => 'Difah Ardini', 'email' => 'difah@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'septiarini', 'nama' => 'Septiarini Sakiyah', 'email' => 'rini@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'akhmad', 'nama' => 'Akhmad Heriyanto', 'email' => 'heriGL@gmail.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'annisa', 'nama' => 'Annisa Maulida Ikhsanti', 'email' => 'anisa@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'kartika', 'nama' => 'Kartika Eka Milasari, S.Pd.', 'email' => 'kartika@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'indriana', 'nama' => 'Indriana Nur Vantari, S.Pd', 'email' => 'indriana@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'sripur', 'nama' => 'Sri Purwaningsih', 'email' => 'srisa@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'bayu', 'nama' => 'Bayu Aji Wibowo, S.Pd.', 'email' => 'senjawibowo99@gmail.com', 'password' => bcrypt ('admin123'), 'role' => 'admin'],
            ['username' => 'heni', 'nama' => 'Fajriyatun Nugraheni, S.I.Pust', 'email' => 'heni@smk.com', 'password' => bcrypt ('heni54321'), 'role' => 'teller'],
            ['username' => 'herva', 'nama' => 'Herva Liliani', 'email' => 'herva@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'yuli', 'nama' => 'Yuli Setyawati', 'email' => 'yuli@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
            ['username' => 'elisa', 'nama' => 'Elisa Maulidatun', 'email' => 'elisa@smk.com', 'password' => bcrypt ('guru12345'), 'role' => 'guest'],
        ]);
    }
}
