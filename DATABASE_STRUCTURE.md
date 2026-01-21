# Samarth Database Structure

## Overview
This document describes the database schema for the Samarth application.

## Database Type
- **Primary**: SQLite (for development)
- **Alternative**: MySQL/MariaDB (for production via Docker)

## Database File Location
- Development: `database/database.sqlite`
- Docker MySQL: `docker/mysql/data/`

## Tables Overview

### 1. Core Tables (Laravel Built-in)
| Table | Description |
|-------|-------------|
| `migrations` | Tracks migration history |
| `cache` | Application caching |
| `cache_locks` | Distributed cache locks |
| `jobs` | Queue jobs |
| `job_batches` | Batch job tracking |
| `failed_jobs` | Failed job logging |
| `password_reset_tokens` | Password reset tokens |
| `sessions` | User session data |

### 2. User Authentication Tables
| Table | Description |
|-------|-------------|
| `users` | Laravel default users table |
| `samarth_users` | Extended user table with Samarth-specific fields |

#### samarth_users Schema
```sql
CREATE TABLE samarth_users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR NOT NULL UNIQUE,
    email VARCHAR NOT NULL UNIQUE,
    email_verified_at DATETIME,
    password VARCHAR NOT NULL,
    first_name VARCHAR,
    last_name VARCHAR,
    gender VARCHAR CHECK (gender IN ('male', 'female', 'other')),
    date_of_birth DATE,
    phone VARCHAR,
    address TEXT,
    city VARCHAR,
    state VARCHAR,
    country VARCHAR,
    postal_code VARCHAR,
    role VARCHAR CHECK (role IN ('user', 'admin', 'moderator')) DEFAULT 'user',
    status VARCHAR CHECK (status IN ('active', 'inactive', 'suspended')) DEFAULT 'active',
    language VARCHAR NOT NULL DEFAULT 'hindi',
    preferences TEXT,
    is_terms_accepted TINYINT(1) DEFAULT 0,
    is_privacy_accepted TINYINT(1) DEFAULT 0,
    timezone VARCHAR,
    two_factor_enabled TINYINT(1) DEFAULT 0,
    last_login_at DATETIME,
    remember_token VARCHAR,
    created_at DATETIME,
    updated_at DATETIME,
    security_question VARCHAR DEFAULT 'school',
    security_answer VARCHAR
);
```

### 3. User Profile Tables
| Table | Description |
|-------|-------------|
| `user_profiles` | Extended user profile data |
| `user_progress` | User goal progress tracking |
| `user_challenges` | User challenge completions |

#### user_profiles Schema
```sql
CREATE TABLE user_profiles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    bio TEXT,
    location VARCHAR,
    website VARCHAR,
    avatar VARCHAR,
    preferred_language VARCHAR NOT NULL DEFAULT 'hindi',
    created_at DATETIME,
    updated_at DATETIME,
    display_name VARCHAR,
    language_preference VARCHAR NOT NULL DEFAULT 'hi',
    notification_preferences TEXT,
    FOREIGN KEY (user_id) REFERENCES samarth_users(id) ON DELETE CASCADE
);
```

### 4. Education Module Tables
| Table | Description |
|-------|-------------|
| `education_streams` | Educational streams (Science, Commerce, Arts) |
| `education_sectors` | Career sectors |
| `courses` | Course information |
| `competitive_exams` | Competitive exam details |
| `user_education_profiles` | User education profile |
| `user_education_plans` | Generated education plans |

#### education_streams Schema
```sql
CREATE TABLE education_streams (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    key VARCHAR NOT NULL UNIQUE,
    name_hindi VARCHAR NOT NULL,
    name_english VARCHAR NOT NULL,
    description_hindi TEXT NOT NULL,
    description_english TEXT NOT NULL,
    subjects_hindi TEXT,
    subjects_english TEXT,
    career_paths_hindi TEXT,
    career_paths_english TEXT,
    icon VARCHAR,
    color VARCHAR,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
);
```

#### education_sectors Schema
```sql
CREATE TABLE education_sectors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    key VARCHAR NOT NULL UNIQUE,
    name_hindi VARCHAR NOT NULL,
    name_english VARCHAR NOT NULL,
    description_hindi TEXT NOT NULL,
    description_english TEXT NOT NULL,
    why_important_hindi TEXT,
    why_important_english TEXT,
    eligibility_10th_hindi TEXT,
    eligibility_10th_english TEXT,
    eligibility_12th_hindi TEXT,
    eligibility_12th_english TEXT,
    career_prospects_hindi TEXT,
    career_prospects_english TEXT,
    icon VARCHAR,
    color VARCHAR,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
);
```

#### courses Schema
```sql
CREATE TABLE courses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    sector_id INTEGER NOT NULL,
    stream_id INTEGER,
    key VARCHAR NOT NULL UNIQUE,
    name_hindi VARCHAR NOT NULL,
    name_english VARCHAR NOT NULL,
    description_hindi TEXT NOT NULL,
    description_english TEXT NOT NULL,
    duration VARCHAR NOT NULL,
    eligibility_hindi TEXT NOT NULL,
    eligibility_english TEXT NOT NULL,
    job_prospects_hindi TEXT,
    job_prospects_english TEXT,
    avg_salary_hindi TEXT,
    avg_salary_english TEXT,
    required_subjects_hindi TEXT,
    required_subjects_english TEXT,
    skills_needed_hindi TEXT,
    skills_needed_english TEXT,
    course_type VARCHAR,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (sector_id) REFERENCES education_sectors(id) ON DELETE CASCADE,
    FOREIGN KEY (stream_id) REFERENCES education_streams(id) ON DELETE SET NULL
);
```

#### competitive_exams Schema
```sql
CREATE TABLE competitive_exams (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    sector_id INTEGER NOT NULL,
    stream_id INTEGER,
    key VARCHAR NOT NULL UNIQUE,
    name_hindi VARCHAR NOT NULL,
    name_english VARCHAR NOT NULL,
    sector VARCHAR NOT NULL,
    applicable_for VARCHAR NOT NULL,
    eligibility_class VARCHAR NOT NULL,
    eligibility_hindi TEXT,
    eligibility_english TEXT,
    exam_pattern VARCHAR,
    frequency VARCHAR,
    subjects_hindi TEXT,
    subjects_english TEXT,
    preparation_tips_hindi TEXT,
    preparation_tips_english TEXT,
    official_website VARCHAR,
    registration_period VARCHAR,
    exam_months VARCHAR,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (sector_id) REFERENCES education_sectors(id) ON DELETE CASCADE,
    FOREIGN KEY (stream_id) REFERENCES education_streams(id) ON DELETE SET NULL
);
```

#### user_education_profiles Schema
```sql
CREATE TABLE user_education_profiles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL UNIQUE,
    current_class VARCHAR NOT NULL,
    planned_stream VARCHAR,
    interest_tags TEXT,
    strengths_hindi TEXT,
    strengths_english TEXT,
    challenges_hindi TEXT,
    challenges_english TEXT,
    family_support_level VARCHAR,
    financial_constraints VARCHAR,
    career_goals_hindi TEXT,
    career_goals_english TEXT,
    preferred_learning_style TEXT,
    profile_completed_at DATETIME,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES samarth_users(id) ON DELETE CASCADE
);
```

#### user_education_plans Schema
```sql
CREATE TABLE user_education_plans (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    profile_id INTEGER NOT NULL,
    plan_type VARCHAR NOT NULL,
    recommended_streams TEXT,
    recommended_sectors TEXT,
    recommended_courses TEXT,
    recommended_exams TEXT,
    plan_data TEXT,
    progress TEXT,
    milestones TEXT,
    study_schedule TEXT,
    resources TEXT,
    personalized_message_hindi TEXT,
    personalized_message_english TEXT,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    generated_at DATETIME,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES samarth_users(id) ON DELETE CASCADE,
    FOREIGN KEY (profile_id) REFERENCES user_education_profiles(id) ON DELETE CASCADE
);
```

### 5. Goals & Challenges Tables
| Table | Description |
|-------|-------------|
| `goals` | User goals |
| `challenges` | Daily/weekly challenges |
| `user_progress` | User goal progress |
| `user_challenges` | User challenge completions |

#### goals Schema
```sql
CREATE TABLE goals (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title_hindi VARCHAR NOT NULL,
    title_english VARCHAR,
    description_hindi TEXT,
    description_english TEXT,
    category VARCHAR,
    target_age_group VARCHAR,
    estimated_time_hours INTEGER NOT NULL DEFAULT 1,
    points_reward INTEGER NOT NULL DEFAULT 10,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME,
    updated_at DATETIME
);
```

#### challenges Schema
```sql
CREATE TABLE challenges (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title_hindi VARCHAR NOT NULL,
    title_english VARCHAR,
    description_hindi TEXT,
    description_english TEXT,
    category VARCHAR,
    estimated_time_minutes INTEGER NOT NULL DEFAULT 30,
    points_reward INTEGER NOT NULL DEFAULT 5,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME,
    updated_at DATETIME
);
```

#### user_progress Schema
```sql
CREATE TABLE user_progress (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    goal_id INTEGER NOT NULL,
    progress_percentage NUMERIC NOT NULL DEFAULT 0,
    status VARCHAR NOT NULL DEFAULT 'in_progress',
    started_at DATETIME,
    completed_at DATETIME,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES samarth_users(id) ON DELETE CASCADE,
    FOREIGN KEY (goal_id) REFERENCES goals(id) ON DELETE CASCADE
);
```

#### user_challenges Schema
```sql
CREATE TABLE user_challenges (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    challenge_id INTEGER NOT NULL,
    is_completed TINYINT(1) NOT NULL DEFAULT 0,
    completed_at DATETIME,
    points_earned INTEGER NOT NULL DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES samarth_users(id) ON DELETE CASCADE,
    FOREIGN KEY (challenge_id) REFERENCES challenges(id) ON DELETE CASCADE
);
```

### 6. Videos Tables
| Table | Description |
|-------|-------------|
| `videos` | Video content |
| `video_comments` | Video comments |
| `video_likes` | Video likes |
| `video_shares` | Video shares |

#### videos Schema
```sql
CREATE TABLE videos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR NOT NULL,
    link VARCHAR NOT NULL,
    type VARCHAR NOT NULL DEFAULT 'motivational',
    thumbnail VARCHAR,
    duration VARCHAR,
    views_count INTEGER NOT NULL DEFAULT 0,
    likes_count INTEGER NOT NULL DEFAULT 0,
    comments_count INTEGER NOT NULL DEFAULT 0,
    author VARCHAR,
    created_at DATETIME,
    updated_at DATETIME
);
```

#### video_comments Schema
```sql
CREATE TABLE video_comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    video_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    comment TEXT NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES samarth_users(id) ON DELETE CASCADE
);
```

#### video_likes Schema
```sql
CREATE TABLE video_likes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    video_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES samarth_users(id) ON DELETE CASCADE
);
```

#### video_shares Schema
```sql
CREATE TABLE video_shares (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    video_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES samarth_users(id) ON DELETE CASCADE
);
```

## Database Relationships

```
samarth_users (1) ──── (1) user_profiles
samarth_users (1) ──── (1) user_education_profiles
samarth_users (1) ──── (N) user_education_plans
samarth_users (1) ──── (N) user_progress
samarth_users (1) ──── (N) user_challenges
samarth_users (1) ──── (N) video_comments
samarth_users (1) ──── (N) video_likes
samarth_users (1) ──── (N) video_shares

education_streams (1) ──── (N) courses
education_streams (1) ──── (N) competitive_exams
education_sectors (1) ──── (N) courses
education_sectors (1) ──── (N) competitive_exams

user_education_profiles (1) ──── (N) user_education_plans
goals (1) ──── (N) user_progress
challenges (1) ──── (N) user_challenges
videos (1) ──── (N) video_comments
videos (1) ──── (N) video_likes
videos (1) ──── (N) video_shares
```

## Setup Commands

### SQLite (Development)
```bash
# Install dependencies
composer install

# Setup database
touch database/database.sqlite
php artisan migrate --seed

# Start server
php artisan serve
```

### MySQL via Docker (Production)
```bash
# Build and start containers
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed
```

## Environment Variables
```env
DB_CONNECTION=sqlite
# OR for MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=samarth
DB_USERNAME=root
DB_PASSWORD=
```

