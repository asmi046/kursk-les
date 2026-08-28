<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contacts')->insert(
            [
                [
                    'name' => 'site_name',
                    'title' => 'Имя сайта',
                    'value' => 'Курский лес',
                ],

                [
                    'name' => 'company_name',
                    'title' => 'Название компании',
                    'value' => 'ООО «КУРСКИЙ ЛЕС»',
                ],

                [
                    'name' => 'legal_address',
                    'title' => 'Юридический адрес',
                    'value' => '142200, Московская обл., г.о. Серпухов, г. Серпухов, ул. Ворошилова, д. 49',
                ],

                [
                    'name' => 'address',
                    'title' => 'Почтовый адрес',
                    'value' => '305044, г. Курск, ул. Республиканская, дом 1Б, офис 206',
                ],

                [
                    'name' => 'phone',
                    'title' => 'Телефон',
                    'value' => '(4712) 34-19-95',
                ],

                [
                    'name' => 'email',
                    'title' => 'E-mail',
                    'value' => 'kurskforest@yandex.ru',
                ],

                [
                    'name' => 'inn',
                    'title' => 'ИНН',
                    'value' => '4632267750',
                ],

                [
                    'name' => 'kpp',
                    'title' => 'КПП',
                    'value' => '504301001',
                ],

                [
                    'name' => 'ogrn',
                    'title' => 'ОГРН',
                    'value' => '1204600005884',
                ],

                [
                    'name' => 'rs',
                    'title' => 'Р/С',
                    'value' => '40702810033000011200',
                ],

                [
                    'name' => 'bank_name',
                    'title' => 'Банк',
                    'value' => 'Курское отделение № 8596 г. Курск ПАО «Сбербанк»',
                ],

                [
                    'name' => 'ks',
                    'title' => 'К/С',
                    'value' => '30101810300000000606',
                ],

                [
                    'name' => 'bik',
                    'title' => 'БИК',
                    'value' => '043807606',
                ],

                [
                    'name' => 'director',
                    'title' => 'Директор',
                    'value' => 'Глазков Вячеслав Вячеславович',
                ],

                [
                    'name' => 'work_time',
                    'title' => 'Время работы',
                    'value' => 'Пн-Пт 09:00 - 18:00',
                ],

            ]
        );
    }
}
