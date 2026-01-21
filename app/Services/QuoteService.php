<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class QuoteService
{
    const THEME_DEFAULT = 'default';
    const THEME_INDEPENDENCE_DAY = 'independence_day';
    const THEME_REPUBLIC_DAY = 'republic_day';
    const THEME_GANDHI_JAYANTI = 'gandhi_jayanti';
    const THEME_CHRISTMAS = 'christmas';
    const THEME_DIWALI = 'diwali';
    const THEME_HOLI = 'holi';
    const THEME_NEW_YEAR = 'new_year';

    public static function getAllQuotes(): array
    {
        return [
            ['text' => 'शिक्षा वह हथियार है जिससे आप पूरी दुनिया बदल सकते हैं।', 'author' => 'नेल्सन मंडेला', 'category' => 'शिक्षा'],
            ['text' => 'ज्ञान ही शक्ति है।', 'author' => 'फ्रांसिस बेकन', 'category' => 'शिक्षा'],
            ['text' => 'किताबें आपके सबसे अच्छे दोस्त हैं।', 'author' => 'चाणक्य', 'category' => 'शिक्षा'],
            ['text' => 'सीखना कभी भी बूढ़ा नहीं होता।', 'author' => 'जापनी कहावत', 'category' => 'शिक्षा'],
            ['text' => 'विद्या ददाति विनयम्।', 'author' => 'वेद', 'category' => 'शिक्षा'],
            ['text' => 'अज्ञानता सबसे बड़ा रोग है।', 'author' => 'सुभाष चंद्र बोस', 'category' => 'शिक्षा'],
            ['text' => 'पढ़ाई के बिना जीवन अधूरा है।', 'author' => 'लाल बहादुर शास्त्री', 'category' => 'शिक्षा'],
            ['text' => 'कलम तलवार से बड़ी होती है।', 'author' => 'महात्मा गांधी', 'category' => 'शिक्षा'],
            ['text' => 'जो पढ़ता है वही आगे बढ़ता है।', 'author' => 'भारतीय कहावत', 'category' => 'शिक्षा'],
            ['text' => 'ज्ञान का कोई विकल्प नहीं है।', 'author' => 'ए.पी.जे. अब्दुल कलाम', 'category' => 'शिक्षा'],
            ['text' => 'सफलता की कुंजी है परिश्रम।', 'author' => 'डॉ. ए.पी.जे. अब्दुल कलाम', 'category' => 'सफलता'],
            ['text' => 'हार मानो मत, लड़ते रहो।', 'author' => 'महात्मा गांधी', 'category' => 'सफलता'],
            ['text' => 'संकल्प सफलता की कुंजी है।', 'author' => 'स्वामी विवेकानंद', 'category' => 'सफलता'],
            ['text' => 'विजयी वही जो टिक के लड़े।', 'author' => 'छत्रपति शिवाजी', 'category' => 'सफलता'],
            ['text' => 'छोटे कदम बड़ी जीत की ओर ले जाते हैं।', 'author' => 'लाल बहादुर शास्त्री', 'category' => 'सफलता'],
            ['text' => 'हिम्मत नहीं हारनी चाहिए।', 'author' => 'सुभाष चंद्र बोस', 'category' => 'सफलता'],
            ['text' => 'सपने देखो और पूरे करो।', 'author' => 'डॉ. ए.पी.जे. अब्दुल कलाम', 'category' => 'सफलता'],
            ['text' => 'कर्म करो, फल मिलेगा।', 'author' => 'भगवद गीता', 'category' => 'सफलता'],
            ['text' => 'उत्साह से भरे रहो।', 'author' => 'जवाहरलाल नेहरू', 'category' => 'सफलता'],
            ['text' => 'साहस के साथ आगे बढ़ो।', 'author' => 'प्रधानमंत्री मोदी', 'category' => 'सफलता'],
            ['text' => 'आज का दिन आपका है।', 'author' => 'भारतीय कहावत', 'category' => 'प्रेरणा'],
            ['text' => 'सपनों की उड़ान भरें!', 'author' => 'स्वामी विवेकानंद', 'category' => 'प्रेरणा'],
            ['text' => 'हर क्षण नया अवसर है।', 'author' => 'रवींद्रनाथ टैगोर', 'category' => 'प्रेरणा'],
            ['text' => 'जो होना है वो होगा।', 'author' => 'कबीर दास', 'category' => 'प्रेरणा'],
            ['text' => 'आज करो कल का काम।', 'author' => 'तुलसीदास', 'category' => 'प्रेरणा'],
            ['text' => 'समय का सदुपयोग करो।', 'author' => 'चाणक्य', 'category' => 'प्रेरणा'],
            ['text' => 'जो करो अच्छे से करो।', 'author' => 'महात्मा गांधी', 'category' => 'प्रेरणा'],
            ['text' => 'प्यार से सब जीत लो।', 'author' => 'मदर टेरेसा', 'category' => 'प्रेरणा'],
            ['text' => 'हंसो और खुश रहो।', 'author' => 'दादा', 'category' => 'प्रेरणा'],
            ['text' => 'आगे बढ़ो मत रुको।', 'author' => 'सरदार पटेल', 'category' => 'प्रेरणा'],
            ['text' => 'पॉजिटिव रहो सदा।', 'author' => 'अमिताभ बच्चन', 'category' => 'प्रेरणा'],
            ['text' => 'भरोसा रखो खुद पर।', 'author' => 'डॉ. ए.पी.जे. अब्दुल कलाम', 'category' => 'प्रेरणा'],
            ['text' => 'लक्ष्य की ओर देखो।', 'author' => 'विराट कोहली', 'category' => 'प्रेरणा'],
            ['text' => 'जय हिंद!', 'author' => 'सुभाष चंद्र बोस', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'वंदे मातरम्।', 'author' => 'बंकिम चंद्र चट्टोपाध्याय', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'भारत माता की जय।', 'author' => 'राष्ट्रीय नारा', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'एकता में शक्ति है।', 'author' => 'सरदार पटेल', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'स्वतंत्रता दिवस की शुभकामनाएं।', 'author' => 'जवाहरलाल नेहरू', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'गणतंत्र दिवस की शुभकामनाएं।', 'author' => 'डॉ. राजेंद्र प्रसाद', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'वीरों का देश है भारत।', 'author' => 'महात्मा गांधी', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'हिंदी हमारी पहचान है।', 'author' => 'राष्ट्रीय संस्कृति', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'विविधता में एकता है।', 'author' => 'डॉ. ए.पी.जे. अब्दुल कलाम', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'भारत की शान बढ़ाओ।', 'author' => 'प्रधानमंत्री मोदी', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'देश सेवा ही धर्म है।', 'author' => 'स्वामी विवेकानंद', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'तिरंगा ऊंचा रहे।', 'author' => 'राष्ट्रीय गान', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'जय जवान, जय किसान।', 'author' => 'लाल बहादुर शास्त्री', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'भारत का नाम रोशन करो।', 'author' => 'पी.वी. सिंधु', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'खेलो और जीतो।', 'author' => 'अभिनव बिंद्रा', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'मेरा भारत महान।', 'author' => 'राष्ट्रीय गौरव', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'हिंदुस्तान जिंदाबाद।', 'author' => 'सुभाष चंद्र बोस', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'आत्मनिर्भर भारत।', 'author' => 'प्रधानमंत्री मोदी', 'category' => 'राष्ट्रीय गौरव'],
            ['text' => 'मेक इन इंडिया।', 'author' => 'भारत सरकार', 'category' => 'राष्ट्रीय गौरव'],
        ];
    }

    public static function getTodayQuote(): array
    {
        $quotes = self::getAllQuotes();
        $dayOfYear = date('z') + 1;
        $index = $dayOfYear % count($quotes);
        return $quotes[$index];
    }

    public static function getRandomQuote(): array
    {
        $quotes = self::getAllQuotes();
        $index = array_rand($quotes);
        return $quotes[$index];
    }

    public static function getCurrentTheme(): string
    {
        $month = (int) date('m');
        $day = (int) date('d');
        
        $specialDates = [
            ['month' => 8, 'day' => 15, 'theme' => self::THEME_INDEPENDENCE_DAY],
            ['month' => 1, 'day' => 26, 'theme' => self::THEME_REPUBLIC_DAY],
            ['month' => 10, 'day' => 2, 'theme' => self::THEME_GANDHI_JAYANTI],
            ['month' => 12, 'day' => 25, 'theme' => self::THEME_CHRISTMAS],
            ['month' => 11, 'day' => 12, 'theme' => self::THEME_DIWALI],
            ['month' => 3, 'day' => 15, 'theme' => self::THEME_HOLI],
            ['month' => 1, 'day' => 1, 'theme' => self::THEME_NEW_YEAR],
        ];
        
        foreach ($specialDates as $date) {
            if ($date['month'] === $month && $date['day'] === $day) {
                return $date['theme'];
            }
        }
        
        return self::THEME_DEFAULT;
    }

    public static function getThemeConfig(string $theme = null): array
    {
        $theme = $theme ?? self::getCurrentTheme();
        
        $configs = [
            self::THEME_DEFAULT => [
                'name' => 'डिफ़ॉल्ट थीम',
                'primary_color' => '#ea580c',
                'secondary_color' => '#f97316',
                'gradient_start' => '#020617',
                'gradient_end' => '#1e1b4b',
                'accent_color' => '#fbbf24',
                'description' => 'डिफ़ॉल्ट डार्क थीम',
            ],
            self::THEME_INDEPENDENCE_DAY => [
                'name' => 'स्वतंत्रता दिवस',
                'primary_color' => '#ff9933',
                'secondary_color' => '#138808',
                'gradient_start' => '#ff9933',
                'gradient_end' => '#138808',
                'accent_color' => '#ffffff',
                'description' => 'भारत के स्वतंत्रता दिवस की शुभकामनाएं',
            ],
            self::THEME_REPUBLIC_DAY => [
                'name' => 'गणतंत्र दिवस',
                'primary_color' => '#000080',
                'secondary_color' => '#ff9933',
                'gradient_start' => '#000080',
                'gradient_end' => '#ff9933',
                'accent_color' => '#ffffff',
                'description' => 'भारत के गणतंत्र दिवस की शुभकामनाएं',
            ],
            self::THEME_GANDHI_JAYANTI => [
                'name' => 'गांधी जयंती',
                'primary_color' => '#90EE90',
                'secondary_color' => '#228B22',
                'gradient_start' => '#90EE90',
                'gradient_end' => '#228B22',
                'accent_color' => '#006400',
                'description' => 'महात्मा गांधी जी की जयंती पर',
            ],
            self::THEME_CHRISTMAS => [
                'name' => 'क्रिसमस',
                'primary_color' => '#c41e3a',
                'secondary_color' => '#228B22',
                'gradient_start' => '#1e1b4b',
                'gradient_end' => '#c41e3a',
                'accent_color' => '#ffd700',
                'description' => 'मेरी क्रिसमस की शुभकामनाएं',
            ],
            self::THEME_DIWALI => [
                'name' => 'दिवाली',
                'primary_color' => '#ffd700',
                'secondary_color' => '#ff6b35',
                'gradient_start' => '#ffd700',
                'gradient_end' => '#ff6b35',
                'accent_color' => '#c41e3a',
                'description' => 'दिवाली की हार्दिक शुभकामनाएं',
            ],
            self::THEME_HOLI => [
                'name' => 'होली',
                'primary_color' => '#ff69b4',
                'secondary_color' => '#9400d3',
                'gradient_start' => '#ff69b4',
                'gradient_end' => '#9400d3',
                'accent_color' => '#00ff00',
                'description' => 'होली की हार्दिक शुभकामनाएं',
            ],
            self::THEME_NEW_YEAR => [
                'name' => 'नव वर्ष',
                'primary_color' => '#ffd700',
                'secondary_color' => '#c0c0c0',
                'gradient_start' => '#000000',
                'gradient_end' => '#ffd700',
                'accent_color' => '#ffffff',
                'description' => 'नए साल की शुभकामनाएं',
            ],
        ];
        
        return $configs[$theme] ?? $configs[self::THEME_DEFAULT];
    }

    public static function getHomePageData(): array
    {
        return [
            'quote' => self::getTodayQuote(),
            'theme' => self::getCurrentTheme(),
            'theme_config' => self::getThemeConfig(),
            'total_quotes' => count(self::getAllQuotes()),
        ];
    }
}
