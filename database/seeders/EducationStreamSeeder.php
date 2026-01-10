<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EducationStream;

class EducationStreamSeeder extends Seeder
{
    public function run()
    {
        $streams = [
            [
                'key' => 'science',
                'name_hindi' => 'Science',
                'name_english' => 'Science',
                'description_hindi' => 'विज्ञान स्ट्रीम में गणित, भौतिकी, रसायन और जीव विज्ञान शामिल है। यह इंजीनियरिंग, चिकित्सा, अनुसंधान और तकनीकी करियर के लिए मार्ग प्रदान करता है।',
                'description_english' => 'Science stream includes Mathematics, Physics, Chemistry, and Biology. It opens doors to engineering, medicine, research, and technical careers.',
                'subjects_hindi' => ['गणित', 'भौतिक विज्ञान', 'रसायन विज्ञान', 'जीव विज्ञान'],
                'subjects_english' => ['Mathematics', 'Physics', 'Chemistry', 'Biology'],
                'career_paths_hindi' => ['इंजीनियरिंग', 'चिकित्सा', 'अनुसंधान वैज्ञानिक', 'आईटी प्रोफेशनल', 'डेटा साइंटिस्ट'],
                'career_paths_english' => ['Engineering', 'Medicine', 'Research Scientist', 'IT Professional', 'Data Scientist'],
                'icon' => 'fa-flask',
                'color' => '#10b981',
                'sort_order' => 1,
            ],
            [
                'key' => 'commerce',
                'name_hindi' => 'Commerce',
                'name_english' => 'Commerce',
                'description_hindi' => 'वाणिज्य स्ट्रीम में अर्थशास्त्र, लेखा, व्यवसाय अध्ययन और गणित शामिल है। यह व्यापार, वित्त, CA/CS/CMA और प्रबंधन करियर के लिए आधार बनाता है।',
                'description_english' => 'Commerce stream includes Economics, Accountancy, Business Studies, and Mathematics. It provides foundation for business, finance, CA/CS/CMA and management careers.',
                'subjects_hindi' => ['अर्थशास्त्र', 'लेखा', 'व्यवसाय अध्ययन', 'गणित/सांख्यिकी'],
                'subjects_english' => ['Economics', 'Accountancy', 'Business Studies', 'Mathematics/Statistics'],
                'career_paths_hindi' => ['चार्टर्ड अकाउंटेंट', 'कंपनी सचिव', 'लागत लेखाकार', 'बैंकर', 'व्यापारिक विश्लेषक', 'मार्केटर'],
                'career_paths_english' => ['Chartered Accountant', 'Company Secretary', 'Cost Accountant', 'Banker', 'Business Analyst', 'Marketing Professional'],
                'icon' => 'fa-chart-line',
                'color' => '#3b82f6',
                'sort_order' => 2,
            ],
            [
                'key' => 'arts',
                'name_hindi' => 'Arts/Humanities',
                'name_english' => 'Arts/Humanities',
                'description_hindi' => 'कला स्ट्रीम में इतिहास, भूगोल, राजनीति विज्ञान, समाजशास्त्र, मनोविज्ञान और भाषाएं शामिल हैं। यह न्याय, सिविल सेवा, मीडिया और सामाजिक कार्य के लिए द्वार खोलता है।',
                'description_english' => 'Arts stream includes History, Geography, Political Science, Sociology, Psychology, and languages. It opens doors to law, civil services, media, and social work.',
                'subjects_hindi' => ['इतिहास', 'भूगोल', 'राजनीति विज्ञान', 'समाजशास्त्र', 'मनोविज्ञान', 'हिंदी/अंग्रेजी साहित्य'],
                'subjects_english' => ['History', 'Geography', 'Political Science', 'Sociology', 'Psychology', 'Hindi/English Literature'],
                'career_paths_hindi' => ['वकील', 'सिविल सेवक', 'पत्रकार', 'शिक्षक', 'सामाजिक कार्यकर्ता', 'डिजाइनर', 'कलाकार'],
                'career_paths_english' => ['Lawyer', 'Civil Servant', 'Journalist', 'Teacher', 'Social Worker', 'Designer', 'Artist'],
                'icon' => 'fa-palette',
                'color' => '#8b5cf6',
                'sort_order' => 3,
            ],
            [
                'key' => 'vocational',
                'name_hindi' => 'Vocational/Skills',
                'name_english' => 'Vocational/Skills',
                'description_hindi' => 'व्यावसायिक शिक्षा में व्यावहारिक कौशल, तकनीकी प्रशिक्षण और रोजगार-उन्मुख पाठ्यक्रम शामिल हैं। यह जल्दी आय और स्वरोजगार के अवसर प्रदान करता है।',
                'description_english' => 'Vocational education includes practical skills, technical training, and job-oriented courses. It provides early income opportunities and self-employment options.',
                'subjects_hindi' => ['व्यावसायिक कौशल', 'तकनीकी प्रशिक्षण', 'इंटर्नशिप', 'प्रोजेक्ट वर्क'],
                'subjects_english' => ['Vocational Skills', 'Technical Training', 'Internship', 'Project Work'],
                'career_paths_hindi' => ['इलेक्ट्रिशियन', 'प्लम्बर', 'टेक्निशियन', 'कुक', 'हॉस्पिटैलिटी वर्कर', 'डिजिटल मार्केटर'],
                'career_paths_english' => ['Electrician', 'Plumber', 'Technician', 'Cook', 'Hospitality Worker', 'Digital Marketer'],
                'icon' => 'fa-tools',
                'color' => '#f59e0b',
                'sort_order' => 4,
            ],
        ];

        foreach ($streams as $stream) {
            EducationStream::updateOrCreate(
                ['key' => $stream['key']],
                $stream
            );
        }
    }
}
