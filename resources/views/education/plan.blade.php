@extends('layouts.app')

@section('content')
<div class="plan-container">
    <!-- Plan Header -->
    <div class="plan-header">
        <div class="header-content">
            <h1>
                <i class="fas fa-clipboard-list"></i>
                आपकी व्यक्तिगत शिक्षा योजना
            </h1>
            <p>{{ $plan->personalized_message }}</p>
        </div>
        <div class="plan-progress-overview">
            <div class="progress-circle">
                <div class="progress-ring">
                    <svg width="80" height="80">
                        <circle cx="40" cy="40" r="32" stroke="var(--light-gray)" stroke-width="6" fill="none"/>
                        <circle cx="40" cy="40" r="32" stroke="var(--insta-blue)" stroke-width="6" fill="none"
                                stroke-dasharray="{{ 2 * 3.14159 * 32 }}" 
                                stroke-dashoffset="{{ 2 * 3.14159 * 32 * (1 - $plan->progress_percentage / 100) }}"
                                transform="rotate(-90 40 40)" class="progress-circle-fill"/>
                    </svg>
                    <div class="progress-text">
                        <span class="progress-percentage">{{ $plan->progress_percentage }}%</span>
                        <span class="progress-label">पूर्ण</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plan Steps -->
    <div class="plan-steps">
        <div class="step-card active">
            <div class="step-number">1</div>
            <div class="step-content">
                <h3>चरण 1: बुनियादी जानकारी</h3>
                <p>कक्षा और स्ट्रीम की पुष्टि</p>
                @if($plan->profile)
                    <div class="step-details">
                        <span class="detail-item">
                            <i class="fas fa-school"></i>
                            कक्षा: {{ $plan->profile->current_class }}
                        </span>
                        @if($plan->profile->planned_stream && $plan->profile->planned_stream !== 'not_decided')
                            <span class="detail-item">
                                <i class="fas fa-bookmark"></i>
                                स्ट्रीम: {{ $plan->profile->stream->name ?? 'चुना गया' }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>
            <div class="step-status">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>

        <div class="step-card active">
            <div class="step-number">2</div>
            <div class="step-content">
                <h3>चरण 2: सुझाए गए सेक्टर</h3>
                <p>आपकी रुचियों के अनुसार 2-3 सेक्टर</p>
                <div class="recommended-sectors">
                    @foreach($plan->getRecommendedSectors() as $sector)
                        <span class="sector-tag" style="background: {{ $sector->color ?? '#6b7280' }}">
                            <i class="fas {{ $sector->icon ?? 'fa-building' }}"></i>
                            {{ $sector->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            <div class="step-status">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>

        <div class="step-card active">
            <div class="step-number">3</div>
            <div class="step-content">
                <h3>चरण 3: प्रवेश परीक्षाएं</h3>
                <p>उपयुक्त प्रतियोगी परीक्षाएं</p>
                <div class="recommended-exams">
                    @foreach($plan->getRecommendedExams()->take(3) as $exam)
                        <span class="exam-tag">
                            <i class="fas fa-file-alt"></i>
                            {{ $exam->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            <div class="step-status">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>

        <div class="step-card">
            <div class="step-number">4</div>
            <div class="step-content">
                <h3>चरण 4: 30-दिवसीय माइक्रो-प्लान</h3>
                <p>दैनिक और साप्ताहिक लक्ष्य</p>
                <div class="micro-plan-preview">
                    <div class="plan-preview-item">
                        <i class="fas fa-calendar-day"></i>
                        <span>दैनिक: 2 घंटे अध्ययन</span>
                    </div>
                    <div class="plan-preview-item">
                        <i class="fas fa-calendar-week"></i>
                        <span>साप्ताहिक: 1 मॉक टेस्ट</span>
                    </div>
                    <div class="plan-preview-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>मासिक: प्रगति समीक्षा</span>
                    </div>
                </div>
            </div>
            <div class="step-status">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <!-- Study Schedule -->
    <div class="study-schedule-section">
        <h2>
            <i class="fas fa-calendar-alt"></i>
            आपका अध्ययन कार्यक्रम
        </h2>
        
        <!-- Daily Schedule -->
        <div class="schedule-card">
            <div class="schedule-header">
                <h3>
                    <i class="fas fa-sun"></i>
                    दैनिक अध्ययन (हर दिन)
                </h3>
            </div>
            <div class="daily-schedule">
                <div class="schedule-item">
                    <div class="schedule-time">2 घंटे</div>
                    <div class="schedule-content">
                        <h4>विभाजित अध्ययन</h4>
                        <ul>
                            <li>स्कूल सिलेबस: 1 घंटा</li>
                            <li>चुने गए exam की तैयारी: 45 मिनट</li>
                            <li>English/Communication: 15 मिनट</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Schedule -->
        <div class="schedule-card">
            <div class="schedule-header">
                <h3>
                    <i class="fas fa-calendar-week"></i>
                    साप्ताहिक गतिविधियां
                </h3>
            </div>
            <div class="weekly-schedule">
                <div class="schedule-item">
                    <div class="schedule-time">हर सप्ताह</div>
                    <div class="schedule-content">
                        <h4>व्यापक तैयारी</h4>
                        <ul>
                            <li>1 मॉक टेस्ट या practice set</li>
                            <li>1 करियर वीडियो देखें</li>
                            <li>माता-पिता/शिक्षक से अध्ययन पर चर्चा</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Schedule -->
        <div class="schedule-card">
            <div class="schedule-header">
                <h3>
                    <i class="fas fa-calendar-alt"></i>
                    मासिक लक्ष्य
                </h3>
            </div>
            <div class="monthly-schedule">
                <div class="schedule-item">
                    <div class="schedule-time">हर महीना</div>
                    <div class="schedule-content">
                        <h4>प्रगति मूल्यांकन</h4>
                        <ul>
                            <li>अंकों का ट्रैक करें</li>
                            <li>योजना समायोजित करें</li>
                            <li>अगला माइलस्टोन सेट करें</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Tracking -->
    <div class="progress-tracking-section">
        <h2>
            <i class="fas fa-chart-line"></i>
            प्रगति ट्रैकिंग
        </h2>
        <div class="progress-cards">
            <div class="progress-card">
                <div class="progress-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="progress-content">
                    <h3>अध्ययन लक्ष्य</h3>
                    <div class="progress-bar-container">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 65%"></div>
                        </div>
                        <span class="progress-text">65% पूर्ण</span>
                    </div>
                    <p>इस महीने 12 में से 7 लक्ष्य पूरे किए</p>
                </div>
            </div>

            <div class="progress-card">
                <div class="progress-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="progress-content">
                    <h3>परीक्षा तैयारी</h3>
                    <div class="progress-bar-container">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 40%"></div>
                        </div>
                        <span class="progress-text">40% पूर्ण</span>
                    </div>
                    <p>5 में से 2 मॉक टेस्ट पूरे किए</p>
                </div>
            </div>

            <div class="progress-card">
                <div class="progress-icon">
                    <i class="fas fa-target"></i>
                </div>
                <div class="progress-content">
                    <h3>कौशल विकास</h3>
                    <div class="progress-bar-container">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 80%"></div>
                        </div>
                        <span class="progress-text">80% पूर्ण</span>
                    </div>
                    <p>English communication में सुधार</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Milestones -->
    <div class="milestones-section">
        <h2>
            <i class="fas fa-flag-checkered"></i>
            मुख्य माइलस्टोन
        </h2>
        <div class="milestones-timeline">
            <div class="milestone completed">
                <div class="milestone-marker">
                    <i class="fas fa-check"></i>
                </div>
                <div class="milestone-content">
                    <h3>प्रोफ़ाइल पूर्ण करना</h3>
                    <p>अपनी शिक्षा प्राथमिकताएं सेट करें</p>
                    <span class="milestone-date">पूर्ण: {{ $plan->profile?->profile_completed_at?->format('d M Y') ?? 'हाल ही में' }}</span>
                </div>
            </div>

            <div class="milestone completed">
                <div class="milestone-marker">
                    <i class="fas fa-check"></i>
                </div>
                <div class="milestone-content">
                    <h3>स्ट्रीम चुनना</h3>
                    <p>अपने लिए उपयुक्त स्ट्रीम का चयन</p>
                    <span class="milestone-date">पूर्ण: {{ $plan->generated_at?->format('d M Y') ?? 'हाल ही में' }}</span>
                </div>
            </div>

            <div class="milestone current">
                <div class="milestone-marker">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="milestone-content">
                    <h3>परीक्षा तैयारी शुरू करना</h3>
                    <p>मॉक टेस्ट देना और weak areas को मजबूत करना</p>
                    <span class="milestone-date">लक्ष्य: अगले 15 दिन में</span>
                </div>
            </div>

            <div class="milestone upcoming">
                <div class="milestone-marker">
                    <i class="fas fa-star"></i>
                </div>
                <div class="milestone-content">
                    <h3>पहली परीक्षा देना</h3>
                    <p>Mock test या practice exam में भाग लेना</p>
                    <span class="milestone-date">लक्ष्य: अगले महीने</span>
                </div>
            </div>

            <div class="milestone upcoming">
                <div class="milestone-marker">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="milestone-content">
                    <h3>Admission प्रक्रिया</h3>
                    <p>College admission के लिए आवेदन</p>
                    <span class="milestone-date">लक्ष्य: 3 महीने बाद</span>
                </div>
            </div>
        </div>
    </div>

    <!-- External Resources Links -->
    <div class="study-schedule-section" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(168, 85, 247, 0.1));">
        <h2 style="color: var(--insta-purple);">
            <i class="fas fa-external-link-alt"></i>
            बाहरी संसाधन (External Resources)
        </h2>
        <p style="font-size: 14px; color: var(--medium-gray); margin-bottom: 20px;">
            अपनी तैयारी को मजबूत करने के लिए इन मुफ्त संसाधनों का उपयोग करें।
        </p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <a href="https://infyspringboard.onwingspan.com" target="_blank" style="display: flex; flex-direction: column; padding: 20px; background: white; border-radius: 16px; box-shadow: var(--shadow-sm); text-decoration: none; transition: transform 0.2s; hover: transform: translateY(-4px);">
                <div style="width: 48px; height: 48px; background: #ef4444; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">
                    <i class="fas fa-play-circle" style="color: white; font-size: 24px;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: var(--dark-gray); margin-bottom: 4px;">Video Lectures</h3>
                <p style="font-size: 12px; color: #ef4444; font-weight: 500;">InfySpringBoard</p>
                <p style="font-size: 12px; color: var(--medium-gray); margin-top: 8px;">विशेषज्ञों द्वारा वीडियो पाठ्यक्रम</p>
            </a>
            
            <a href="https://ndl.education.gov.in/home" target="_blank" style="display: flex; flex-direction: column; padding: 20px; background: white; border-radius: 16px; box-shadow: var(--shadow-sm); text-decoration: none; transition: transform 0.2s; hover: transform: translateY(-4px);">
                <div style="width: 48px; height: 48px; background: #3b82f6; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">
                    <i class="fas fa-file-pdf" style="color: white; font-size: 24px;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: var(--dark-gray); margin-bottom: 4px;">PDF Notes</h3>
                <p style="font-size: 12px; color: #3b82f6; font-weight: 500;">NDL Education</p>
                <p style="font-size: 12px; color: var(--medium-gray); margin-top: 8px;">मुफ्त PDF नोट्स और पेपर्स</p>
            </a>
            
            <a href="https://vidya.cequ.in" target="_blank" style="display: flex; flex-direction: column; padding: 20px; background: white; border-radius: 16px; box-shadow: var(--shadow-sm); text-decoration: none; transition: transform 0.2s; hover: transform: translateY(-4px);">
                <div style="width: 48px; height: 48px; background: #f59e0b; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">
                    <i class="fas fa-question-circle" style="color: white; font-size: 24px;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: var(--dark-gray); margin-bottom: 4px;">Mock Tests</h3>
                <p style="font-size: 12px; color: #f59e0b; font-weight: 500;">Vidya Platform</p>
                <p style="font-size: 12px; color: var(--medium-gray); margin-top: 8px;">अभ्यास परीक्षाएं और क्विज़</p>
            </a>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="plan-actions">
        <div class="action-buttons">
            <button class="insta-btn insta-btn-primary" onclick="downloadPlan()">
                <i class="fas fa-download"></i>
                प्लान डाउनलोड करें
            </button>
            <button class="insta-btn insta-btn-secondary" onclick="sharePlan()">
                <i class="fas fa-share"></i>
                प्लान शेयर करें
            </button>
            <button class="insta-btn insta-btn-ghost" onclick="updateProgress()">
                <i class="fas fa-edit"></i>
                प्रगति अपडेट करें
            </button>
        </div>
        
        <div class="plan-cta">
            <div class="cta-card">
                <div class="cta-content">
                    <h3>
                        <i class="fas fa-magic"></i>
                        नई योजना चाहिए?
                    </h3>
                    <p>अपनी प्राथमिकताओं में बदलाव हुआ है? नई व्यक्तिगत योजना बनाएं</p>
                </div>
                <form action="{{ route('education.plan.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="insta-btn insta-btn-primary">
                        <i class="fas fa-refresh"></i>
                        नई योजना बनाएं
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.plan-container {
    padding: 0;
}

.plan-header {
    background: var(--insta-gradient);
    color: white;
    padding: 32px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
}

.header-content {
    flex: 1;
    min-width: 300px;
}

.plan-header h1 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.plan-header p {
    opacity: 0.9;
    margin: 0;
    font-size: 16px;
    line-height: 1.5;
}

.plan-progress-overview {
    display: flex;
    align-items: center;
}

.progress-circle {
    position: relative;
}

.progress-ring {
    position: relative;
    display: inline-block;
}

.progress-circle-fill {
    transition: stroke-dashoffset 0.3s ease;
}

.progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.progress-percentage {
    font-size: 16px;
    font-weight: 700;
    color: var(--insta-blue);
}

.progress-label {
    font-size: 10px;
    color: var(--medium-gray);
}

.plan-steps {
    padding: 32px 20px;
}

.plan-steps h2 {
    font-size: 20px;
    font-weight: 600;
    color: var(--dark-gray);
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.step-card {
    display: flex;
    align-items: center;
    gap: 20px;
    background: white;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 16px;
    box-shadow: var(--shadow-sm);
    transition: all 0.2s ease;
    position: relative;
}

.step-card:hover {
    box-shadow: var(--shadow-md);
}

.step-card.active {
    border-left: 4px solid var(--insta-blue);
    background: linear-gradient(135deg, rgba(0, 149, 246, 0.05), rgba(131, 58, 180, 0.05));
}

.step-number {
    width: 40px;
    height: 40px;
    background: var(--insta-gradient);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
    flex-shrink: 0;
}

.step-content {
    flex: 1;
}

.step-content h3 {
    font-size: 16px;
    font-weight: 600;
    color: var(--dark-gray);
    margin-bottom: 8px;
}

.step-content p {
    color: var(--medium-gray);
    margin-bottom: 12px;
    font-size: 14px;
}

.step-details {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 6px;
    background: var(--ultra-light-gray);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    color: var(--medium-gray);
}

.recommended-sectors,
.recommended-exams {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.sector-tag,
.exam-tag {
    display: flex;
    align-items: center;
    gap: 6px;
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.exam-tag {
    background: var(--medium-gray);
}

.micro-plan-preview {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.plan-preview-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: var(--medium-gray);
}

.plan-preview-item i {
    color: var(--insta-blue);
    width: 16px;
}

.step-status {
    color: var(--insta-blue);
    font-size: 20px;
}

.study-schedule-section,
.progress-tracking-section,
.milestones-section {
    padding: 32px 20px;
}

.study-schedule-section h2,
.progress-tracking-section h2,
.milestones-section h2 {
    font-size: 20px;
    font-weight: 600;
    color: var(--dark-gray);
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.schedule-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: var(--shadow-sm);
}

.schedule-header {
    margin-bottom: 16px;
}

.schedule-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: var(--dark-gray);
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}

.schedule-item {
    display: flex;
    gap: 16px;
    align-items: flex-start;
}

.schedule-time {
    background: var(--insta-gradient);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    flex-shrink: 0;
}

.schedule-content {
    flex: 1;
}

.schedule-content h4 {
    font-size: 14px;
    font-weight: 600;
    color: var(--dark-gray);
    margin-bottom: 8px;
}

.schedule-content ul {
    margin: 0;
    padding-left: 20px;
    color: var(--medium-gray);
}

.schedule-content li {
    margin-bottom: 4px;
    font-size: 14px;
}

.progress-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.progress-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: var(--shadow-sm);
    display: flex;
    align-items: center;
    gap: 16px;
}

.progress-icon {
    width: 48px;
    height: 48px;
    background: var(--insta-gradient);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    flex-shrink: 0;
}

.progress-content {
    flex: 1;
}

.progress-content h3 {
    font-size: 14px;
    font-weight: 600;
    color: var(--dark-gray);
    margin-bottom: 12px;
}

.progress-bar-container {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
}

.progress-bar {
    flex: 1;
    height: 6px;
    background: var(--ultra-light-gray);
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: var(--insta-gradient);
    border-radius: 3px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 12px;
    font-weight: 600;
    color: var(--insta-blue);
    white-space: nowrap;
}

.progress-content p {
    font-size: 12px;
    color: var(--medium-gray);
    margin: 0;
}

.milestones-timeline {
    position: relative;
    padding-left: 40px;
}

.milestones-timeline::before {
    content: '';
    position: absolute;
    left: 19px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--light-gray);
}

.milestone {
    position: relative;
    display: flex;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 32px;
}

.milestone-marker {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    position: absolute;
    left: -40px;
    top: 0;
    z-index: 2;
}

.milestone.completed .milestone-marker {
    background: #10b981;
}

.milestone.current .milestone-marker {
    background: var(--insta-blue);
}

.milestone.upcoming .milestone-marker {
    background: var(--medium-gray);
}

.milestone-content {
    flex: 1;
    background: white;
    border-radius: 12px;
    padding: 16px;
    box-shadow: var(--shadow-sm);
}

.milestone-content h3 {
    font-size: 16px;
    font-weight: 600;
    color: var(--dark-gray);
    margin-bottom: 8px;
}

.milestone-content p {
    color: var(--medium-gray);
    margin-bottom: 8px;
    line-height: 1.4;
    font-size: 14px;
}

.milestone-date {
    font-size: 12px;
    color: var(--medium-gray);
    font-style: italic;
}

.plan-actions {
    padding: 32px 20px;
    background: var(--ultra-light-gray);
}

.action-buttons {
    display: flex;
    gap: 12px;
    justify-content: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.plan-cta {
    max-width: 600px;
    margin: 0 auto;
}

.cta-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: var(--shadow-sm);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.cta-content h3 {
    font-size: 16px;
    font-weight: 600;
    color: var(--dark-gray);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.cta-content p {
    color: var(--medium-gray);
    margin: 0;
    font-size: 14px;
    line-height: 1.4;
}

@media (max-width: 640px) {
    .plan-header {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .plan-header h1 {
        font-size: 20px;
        flex-direction: column;
        gap: 8px;
    }
    
    .step-card {
        flex-direction: column;
        text-align: center;
        gap: 16px;
    }
    
    .schedule-item {
        flex-direction: column;
        gap: 12px;
    }
    
    .progress-cards {
        grid-template-columns: 1fr;
    }
    
    .milestones-timeline {
        padding-left: 20px;
    }
    
    .milestone {
        padding-left: 20px;
    }
    
    .milestone-marker {
        left: -20px;
    }
    
    .cta-card {
        flex-direction: column;
        text-align: center;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<script>
function downloadPlan() {
    // Create a simple text version of the plan
    const planText = `
SAMARTH - व्यक्तिगत शिक्षा योजना
=====================================

${{ $plan->personalized_message }}

प्रगति: ${{ $plan->progress_percentage }}% पूर्ण

चरण 1: बुनियादी जानकारी
- कक्षा: {{ $plan->profile?->current_class }}
- स्ट्रीम: {{ $plan->profile?->stream?->name ?? 'चुना गया' }}

चरण 2: सुझाए गए सेक्टर
@foreach($plan->getRecommendedSectors() as $sector)
- {{ $sector->name }}
@endforeach

चरण 3: प्रवेश परीक्षाएं
@foreach($plan->getRecommendedExams()->take(3) as $exam)
- {{ $exam->name }}
@endforeach

दैनिक अध्ययन: 2 घंटे
साप्ताहिक: 1 मॉक टेस्ट
मासिक: प्रगति समीक्षा

---
SAMARTH - Education Guidance Platform
    `;
    
    const blob = new Blob([planText], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'samarth-education-plan.txt';
    a.click();
    URL.revokeObjectURL(url);
}

function sharePlan() {
    if (navigator.share) {
        navigator.share({
            title: 'SAMARTH Education Plan',
            text: '{{ $plan->personalized_message }}',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Plan link copied to clipboard!');
        });
    }
}

function updateProgress() {
    // This would open a modal or navigate to a progress update page
    alert('Progress update feature coming soon!');
}
</script>
@endsection
