<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    public function run()
    {
        $videos = [
            [
                'name' => 'गाँव की लड़की का नर्स बनने का सफ़र',
                'link' => 'https://www.youtube.com/watch?v=nurse_journey',
                'type' => 'career',
                'thumbnail' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=400&h=225&fit=crop',
                'duration' => '3:45',
                'views_count' => 2400,
                'likes_count' => 156,
                'comments_count' => 23
            ],
            [
                'name' => 'खेल से नाम कमाया - अमन की जीत',
                'link' => 'https://www.youtube.com/watch?v=cricket_winner',
                'type' => 'sports',
                'thumbnail' => 'https://images.unsplash.com/photo-1461896836934- voices-9d91a7b4e7e8?w=400&h=225&fit=crop',
                'duration' => '2:30',
                'views_count' => 1800,
                'likes_count' => 98,
                'comments_count' => 15
            ],
            [
                'name' => 'सपना सच हुआ: पुलिस अफ़सर बनी',
                'link' => 'https://www.youtube.com/watch?v=police_officer',
                'type' => 'career',
                'thumbnail' => 'https://images.unsplash.com/photo-1609710228159-0fa9bd7c0827?w=400&h=225&fit=crop',
                'duration' => '5:15',
                'views_count' => 5100,
                'likes_count' => 342,
                'comments_count' => 56
            ],
            [
                'name' => 'मिट्टी की कला से रोज़गार',
                'link' => 'https://www.youtube.com/watch?v=pottery_art',
                'type' => 'skills',
                'thumbnail' => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=400&h=225&fit=crop',
                'duration' => '4:00',
                'views_count' => 3200,
                'likes_count' => 215,
                'comments_count' => 34
            ],
            [
                'name' => 'सफलता की कुंजी - मेरा अनुभव',
                'link' => 'https://www.youtube.com/watch?v=success_key',
                'type' => 'motivational',
                'thumbnail' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=225&fit=crop',
                'duration' => '6:20',
                'views_count' => 8500,
                'likes_count' => 678,
                'comments_count' => 89
            ],
            [
                'name' => 'योग से स्वास्थ्य - शुरुआत कैसे करें',
                'link' => 'https://www.youtube.com/watch?v=yoga_health',
                'type' => 'health',
                'thumbnail' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=225&fit=crop',
                'duration' => '8:30',
                'views_count' => 12000,
                'likes_count' => 892,
                'comments_count' => 145
            ],
            [
                'name' => 'ज़िला टॉपर बनी - पढ़ाई का महत्व',
                'link' => 'https://www.youtube.com/watch?v=topper_story',
                'type' => 'education',
                'thumbnail' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=400&h=225&fit=crop',
                'duration' => '4:45',
                'views_count' => 6700,
                'likes_count' => 456,
                'comments_count' => 67
            ],
            [
                'name' => 'क्रिकेटर बनने का सपना पूरा किया',
                'link' => 'https://www.youtube.com/watch?v=cricketer_dream',
                'type' => 'sports',
                'thumbnail' => 'https://images.unsplash.com/photo-1531415074968-bcce2fl17d4a?w=400&h=225&fit=crop',
                'duration' => '5:50',
                'views_count' => 9200,
                'likes_count' => 734,
                'comments_count' => 98
            ],
            [
                'name' => 'इलेक्ट्रीशियन बनकर आत्मनिर्भर',
                'link' => 'https://www.youtube.com/watch?v=electrician_skills',
                'type' => 'skills',
                'thumbnail' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=400&h=225&fit=crop',
                'duration' => '3:15',
                'views_count' => 2800,
                'likes_count' => 189,
                'comments_count' => 28
            ],
            [
                'name' => 'डॉक्टर बनने का सफ़र',
                'link' => 'https://www.youtube.com/watch?v=doctor_journey',
                'type' => 'career',
                'thumbnail' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&h=225&fit=crop',
                'duration' => '7:25',
                'views_count' => 15000,
                'likes_count' => 1234,
                'comments_count' => 189
            ],
            [
                'name' => 'कंप्यूटर सीखकर नौकरी पाई',
                'link' => 'https://www.youtube.com/watch?v=computer_job',
                'type' => 'skills',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=225&fit=crop',
                'duration' => '4:20',
                'views_count' => 4500,
                'likes_count' => 312,
                'comments_count' => 45
            ],
            [
                'name' => 'सुबह की दिनचर्या - सफलता की कुंजी',
                'link' => 'https://www.youtube.com/watch?v=morning_routine',
                'type' => 'motivational',
                'thumbnail' => 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?w=400&h=225&fit=crop',
                'duration' => '3:00',
                'views_count' => 11000,
                'likes_count' => 876,
                'comments_count' => 123
            ]
        ];

        foreach ($videos as $video) {
            Video::create($video);
        }

        echo "12 sample videos seeded successfully!\n";
    }
}

