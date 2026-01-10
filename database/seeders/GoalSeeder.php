<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Goal;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goals = [
            [
                'key' => 'doctor',
                'title_hindi' => 'डॉक्टर बनना',
                'title_english' => 'Become a Doctor',
                'description_hindi' => 'डॉक्टर बनने का मतलब है कि आप जल्दी शादी से ज़्यादा अपने भविष्य और शिक्षा को प्राथमिकता दे रहे हैं।',
                'description_english' => 'Becoming a doctor means prioritizing your future and education over early marriage.',
                'steps_hindi' => [
                    'आज से 2 घंटे पढ़ाई शुरू करें।',
                    'स्कूल में साइंस स्ट्रीम के बारे में जानकारी लें।',
                    'माता‑पिता से अपने सपने पर खुलकर बात करें।'
                ],
                'steps_english' => [
                    'Start studying 2 hours daily from today.',
                    'Get information about science stream in school.',
                    'Openly discuss your dreams with parents.'
                ],
                'default_progress' => 25,
                'difficulty_level' => 4,
                'estimated_duration_days' => 365,
                'required_skills' => ['science', 'biology', 'chemistry', 'mathematics'],
                'resources' => [
                    'https://www.youtube.com/results?search_query=doctor+career+india',
                    'https://www.nta.nic.in/',
                ],
                'icon' => 'fa-user-md',
                'color' => '#dc2626',
                'sort_order' => 1
            ],
            [
                'key' => 'teacher',
                'title_hindi' => 'शिक्षक बनना',
                'title_english' => 'Become a Teacher',
                'description_hindi' => 'शिक्षक बनने का मतलब है कि आप जल्दी शादी से ज़्यादा अपने भविष्य और शिक्षा को प्राथमिकता दे रहे हैं।',
                'description_english' => 'Becoming a teacher means prioritizing your future and education over early marriage.',
                'steps_hindi' => [
                    'आज एक विषय चुनकर किसी को समझाएँ।',
                    'बीएड / टीचर ट्रेनिंग के विकल्प खोजें।',
                    'पास के स्कूल में किसी शिक्षक से मार्गदर्शन लें।'
                ],
                'steps_english' => [
                    'Choose a subject today and explain it to someone.',
                    'Explore B.Ed/Teacher Training options.',
                    'Get guidance from a teacher in a nearby school.'
                ],
                'default_progress' => 10,
                'difficulty_level' => 3,
                'estimated_duration_days' => 180,
                'required_skills' => ['communication', 'subject_expertise', 'patience'],
                'resources' => [
                    'https://www.youtube.com/results?search_query=teacher+career+india',
                    'https://www.ncte.gov.in/',
                ],
                'icon' => 'fa-chalkboard-teacher',
                'color' => '#059669',
                'sort_order' => 2
            ],
            [
                'key' => 'entrepreneur',
                'title_hindi' => 'उद्यमी बनना',
                'title_english' => 'Become an Entrepreneur',
                'description_hindi' => 'उद्यमी बनने का मतलब है कि आप जल्दी शादी से ज़्यादा अपने भविष्य और शिक्षा को प्राथमिकता दे रहे हैं।',
                'description_english' => 'Becoming an entrepreneur means prioritizing your future and education over early marriage.',
                'steps_hindi' => [
                    'अपने गाँव की एक समस्या लिखें जिसे आप हल करना चाहते हैं।',
                    'ऐसे युवा उद्यमियों की कहानी देखें जिन्होंने बाल विवाह से इंकार किया।',
                    'एक छोटे व्यवसाय आइडिया को कॉपी में लिखें।'
                ],
                'steps_english' => [
                    'Write down a problem in your village that you want to solve.',
                    'Watch stories of young entrepreneurs who refused child marriage.',
                    'Write a small business idea in your copy.'
                ],
                'default_progress' => 5,
                'difficulty_level' => 5,
                'estimated_duration_days' => 730,
                'required_skills' => ['leadership', 'problem_solving', 'creativity', 'business_acumen'],
                'resources' => [
                    'https://www.youtube.com/results?search_query=young+entrepreneur+india',
                    'https://www.startupindia.gov.in/',
                ],
                'icon' => 'fa-lightbulb',
                'color' => '#7c3aed',
                'sort_order' => 3
            ]
        ];

        foreach ($goals as $goal) {
            Goal::create($goal);
        }
    }
}
