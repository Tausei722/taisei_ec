<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        $restaurant = Category::where('name', 'レストラン・カフェ')->first();
        $beauty = Category::where('name', '美容・健康')->first();
        $hotel = Category::where('name', 'ホテル・宿泊')->first();
        $shopping = Category::where('name', 'ショッピング')->first();
        $entertainment = Category::where('name', 'エンターテイメント')->first();
        $fitness = Category::where('name', 'スポーツ・フィットネス')->first();

        $businesses = [
            // レストラン・カフェ
            [
                'name' => 'カフェドリーム',
                'description' => '新鮮な豆を使用したコーヒーと手作りスイーツが自慢のカフェです。落ち着いた雰囲気の中でゆったりとしたひとときをお過ごしください。',
                'category_id' => $restaurant->id,
                'address' => '東京都渋谷区渋谷2-3-4 カフェビル1F',
                'phone' => '03-1234-5678',
                'website' => 'https://cafe-dream.example.com',
                'business_hours' => [
                    'monday' => '8:00-20:00',
                    'tuesday' => '8:00-20:00',
                    'wednesday' => '8:00-20:00',
                    'thursday' => '8:00-20:00',
                    'friday' => '8:00-21:00',
                    'saturday' => '9:00-21:00',
                    'sunday' => '9:00-19:00'
                ],
                'latitude' => 35.658581,
                'longitude' => 139.701439,
                'is_active' => true,
            ],
            [
                'name' => 'イタリアンレストラン ベラビスタ',
                'description' => '本格的なイタリア料理を提供するレストランです。シェフ厳選の食材を使用し、本場の味をお楽しみいただけます。',
                'category_id' => $restaurant->id,
                'address' => '東京都新宿区新宿3-5-6 イタリアンビル2F',
                'phone' => '03-2345-6789',
                'website' => 'https://bellavista.example.com',
                'business_hours' => [
                    'monday' => '11:30-15:00,17:00-22:00',
                    'tuesday' => '11:30-15:00,17:00-22:00',
                    'wednesday' => '11:30-15:00,17:00-22:00',
                    'thursday' => '11:30-15:00,17:00-22:00',
                    'friday' => '11:30-15:00,17:00-23:00',
                    'saturday' => '11:30-23:00',
                    'sunday' => '11:30-22:00'
                ],
                'latitude' => 35.689487,
                'longitude' => 139.691706,
                'is_active' => true,
            ],
            [
                'name' => 'ラーメン横丁 味噌屋',
                'description' => '昔ながらの製法で作る味噌ラーメンが絶品。こだわりの麺とスープで心も体も温まる一杯をご提供します。',
                'category_id' => $restaurant->id,
                'address' => '東京都中野区中野5-7-8',
                'phone' => '03-3456-7890',
                'business_hours' => [
                    'monday' => '11:00-15:00,18:00-23:00',
                    'tuesday' => '11:00-15:00,18:00-23:00',
                    'wednesday' => '休み',
                    'thursday' => '11:00-15:00,18:00-23:00',
                    'friday' => '11:00-15:00,18:00-24:00',
                    'saturday' => '11:00-24:00',
                    'sunday' => '11:00-23:00'
                ],
                'latitude' => 35.707062,
                'longitude' => 139.665678,
                'is_active' => true,
            ],

            // 美容・健康
            [
                'name' => 'ヘアサロン シャインビューティー',
                'description' => '最新のヘアトリートメントと経験豊富なスタイリストによる丁寧なカットで、あなたの魅力を最大限に引き出します。',
                'category_id' => $beauty->id,
                'address' => '東京都港区青山1-2-3 ビューティービル3F',
                'phone' => '03-4567-8901',
                'website' => 'https://shine-beauty.example.com',
                'business_hours' => [
                    'monday' => '10:00-20:00',
                    'tuesday' => '10:00-20:00',
                    'wednesday' => '休み',
                    'thursday' => '10:00-20:00',
                    'friday' => '10:00-21:00',
                    'saturday' => '9:00-21:00',
                    'sunday' => '9:00-19:00'
                ],
                'latitude' => 35.669880,
                'longitude' => 139.714305,
                'is_active' => true,
            ],
            [
                'name' => 'リラクゼーションサロン 癒しの森',
                'description' => '疲れた心と体を癒すリラクゼーションサロン。アロマトリートメントとマッサージで至福のひとときを。',
                'category_id' => $beauty->id,
                'address' => '東京都世田谷区三軒茶屋2-4-5',
                'phone' => '03-5678-9012',
                'business_hours' => [
                    'monday' => '10:00-22:00',
                    'tuesday' => '10:00-22:00',
                    'wednesday' => '10:00-22:00',
                    'thursday' => '10:00-22:00',
                    'friday' => '10:00-22:00',
                    'saturday' => '10:00-22:00',
                    'sunday' => '10:00-20:00'
                ],
                'latitude' => 35.643896,
                'longitude' => 139.668274,
                'is_active' => true,
            ],

            // ホテル・宿泊
            [
                'name' => 'グランドホテル トーキョー',
                'description' => '東京の中心地に位置する高級ホテル。上質なサービスと快適な客室で、特別なひとときをお過ごしください。',
                'category_id' => $hotel->id,
                'address' => '東京都千代田区丸の内1-1-1',
                'phone' => '03-6789-0123',
                'website' => 'https://grandhotel-tokyo.example.com',
                'business_hours' => [
                    'monday' => '24時間',
                    'tuesday' => '24時間',
                    'wednesday' => '24時間',
                    'thursday' => '24時間',
                    'friday' => '24時間',
                    'saturday' => '24時間',
                    'sunday' => '24時間'
                ],
                'latitude' => 35.680959,
                'longitude' => 139.767306,
                'is_active' => true,
            ],

            // ショッピング
            [
                'name' => 'セレクトショップ フェリス',
                'description' => '厳選されたファッションアイテムを取り揃えるセレクトショップ。トレンドを押さえたスタイリングをご提案します。',
                'category_id' => $shopping->id,
                'address' => '東京都渋谷区表参道3-6-7',
                'phone' => '03-7890-1234',
                'website' => 'https://felice-shop.example.com',
                'business_hours' => [
                    'monday' => '11:00-20:00',
                    'tuesday' => '11:00-20:00',
                    'wednesday' => '11:00-20:00',
                    'thursday' => '11:00-20:00',
                    'friday' => '11:00-21:00',
                    'saturday' => '10:00-21:00',
                    'sunday' => '10:00-20:00'
                ],
                'latitude' => 35.665498,
                'longitude' => 139.712013,
                'is_active' => true,
            ],

            // エンターテイメント
            [
                'name' => 'シネマコンプレックス 夢劇場',
                'description' => '最新の音響設備と快適なシートで映画をお楽しみいただける映画館。話題の作品から名作まで幅広く上映中。',
                'category_id' => $entertainment->id,
                'address' => '東京都豊島区池袋2-8-9 エンタメビル5-8F',
                'phone' => '03-8901-2345',
                'website' => 'https://cinema-yumegekijo.example.com',
                'business_hours' => [
                    'monday' => '9:00-24:00',
                    'tuesday' => '9:00-24:00',
                    'wednesday' => '9:00-24:00',
                    'thursday' => '9:00-24:00',
                    'friday' => '9:00-25:00',
                    'saturday' => '9:00-25:00',
                    'sunday' => '9:00-24:00'
                ],
                'latitude' => 35.728926,
                'longitude' => 139.714300,
                'is_active' => true,
            ],

            // スポーツ・フィットネス
            [
                'name' => 'フィットネスクラブ ボディメイク24',
                'description' => '24時間営業のフィットネスクラブ。最新マシンとプロのトレーナーがあなたの理想のボディメイクをサポートします。',
                'category_id' => $fitness->id,
                'address' => '東京都品川区大井町1-3-5 フィットネスビル2-3F',
                'phone' => '03-9012-3456',
                'website' => 'https://bodymake24.example.com',
                'business_hours' => [
                    'monday' => '24時間',
                    'tuesday' => '24時間',
                    'wednesday' => '24時間',
                    'thursday' => '24時間',
                    'friday' => '24時間',
                    'saturday' => '24時間',
                    'sunday' => '24時間'
                ],
                'latitude' => 35.606012,
                'longitude' => 139.733570,
                'is_active' => true,
            ],
        ];

        foreach ($businesses as $business) {
            Business::create($business);
        }
    }
}