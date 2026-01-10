<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Challenge;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $challenges = [
            [
                'key' => 'daily_reflection_15min',
                'title_hindi' => '15 मिनट का रिफ्लेक्शन',
                'title_english' => '15 Minutes Reflection',
                'description_hindi' => 'काग़ज़ पर लिखें: "यदि मैं 18 से पहले शादी करूँ तो मेरे करियर के कौन‑कौन से सपने टूट सकते हैं?"',
                'description_english' => 'Write on paper: "If I get married before 18, which career dreams could be broken?"',
                'category' => 'self_reflection',
                'difficulty' => 'medium',
                'estimated_time_minutes' => 15,
                'instructions_hindi' => [
                    'एक शांत जगह बैठें',
                    'काग़ज़ और पेन लें',
                    '15 मिनट तक सोचें और लिखें',
                    'अपने सपनों को दर्ज करें'
                ],
                'instructions_english' => [
                    'Sit in a quiet place',
                    'Take paper and pen',
                    'Think and write for 15 minutes',
                    'Record your dreams'
                ],
                'reflection_questions' => [
                    'मेरे सबसे बड़े करियर सपने क्या हैं?',
                    'शिक्षा मुझे कैसे मदद कर सकती है?',
                    'जल्दी शादी से मेरे सपनों पर क्या असर पड़ेगा?'
                ],
                'points_reward' => 20,
                'badge_rewards' => ['reflection_master'],
                'is_daily' => true,
                'sort_order' => 1,
                'target_audience' => ['teenagers', 'young_adults']
            ],
            [
                'key' => 'law_awareness',
                'title_hindi' => 'कानून की जानकारी',
                'title_english' => 'Legal Awareness',
                'description_hindi' => 'भारत में बाल विवाह निषेध अधिनियम की जानकारी प्राप्त करें।',
                'description_english' => 'Learn about the Child Marriage Prohibition Act in India.',
                'category' => 'awareness',
                'difficulty' => 'easy',
                'estimated_time_minutes' => 10,
                'instructions_hindi' => [
                    'बाल विवाह निषेध अधिनियम की मुख्य बातें पढ़ें',
                    '18 और 21 वर्ष की आयु सीमा को समझें',
                    'अपने परिवार से इस कानून के बारे में चर्चा करें'
                ],
                'instructions_english' => [
                    'Read key points of Child Marriage Prohibition Act',
                    'Understand age limits of 18 and 21 years',
                    'Discuss this law with your family'
                ],
                'reflection_questions' => [
                    'यह कानून क्यों बनाया गया?',
                    'यह कानून मुझे कैसे सुरक्षित रखता है?',
                    'मैं इस कानून की जानकारी दूसरों तक कैसे पहुंचा सकता हूं?'
                ],
                'points_reward' => 15,
                'badge_rewards' => ['legal_aware'],
                'is_daily' => false,
                'sort_order' => 2,
                'target_audience' => ['teenagers', 'young_adults'],
                'resources' => [
                    'https://www.indiacode.nic.in/handle/123456789/20631',
                    'https://www.unicef.org/india/what-we-do/child-protection/child-marriage'
                ]
            ],
            [
                'key' => 'career_research',
                'title_hindi' => 'करियर रिसर्च',
                'title_english' => 'Career Research',
                'description_hindi' => 'अपने रुचि के करियर के बारे में जानकारी एकत्र करें।',
                'description_english' => 'Gather information about careers that interest you.',
                'category' => 'career',
                'difficulty' => 'medium',
                'estimated_time_minutes' => 30,
                'instructions_hindi' => [
                    'तीन करियर विकल्प चुनें',
                    'प्रत्येक के लिए शिक्षा की आवश्यकताओं की जांच करें',
                    'ऑनलाइन जानकारी एकत्र करें',
                    'स्थानीय संसाधनों की खोज करें'
                ],
                'instructions_english' => [
                    'Choose three career options',
                    'Check education requirements for each',
                    'Gather online information',
                    'Explore local resources'
                ],
                'reflection_questions' => [
                    'कौन सा करियर मुझे सबसे अधिक प्रेरित करता है?',
                    'इस करियर के लिए मुझे क्या सीखना होगा?',
                    'मैं अभी से इस करियर की तैयारी कैसे कर सकता हूं?'
                ],
                'points_reward' => 25,
                'badge_rewards' => ['career_explorer'],
                'is_daily' => false,
                'sort_order' => 3,
                'target_audience' => ['teenagers', 'young_adults'],
                'resources' => [
                    'https://www.nationalcareersservice.gov.uk/',
                    'https://www.education.gov.uk/'
                ]
            ]
        ];

        foreach ($challenges as $challenge) {
            Challenge::create($challenge);
        }
    }
}
