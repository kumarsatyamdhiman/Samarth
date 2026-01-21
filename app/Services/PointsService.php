<?php

namespace App\Services;

use App\Models\UserPoint;
use App\Models\SamarthUser;
use App\Models\UserEducationProfile;
use App\Models\UserEducationPlan;
use App\Models\Video;
use App\Models\VideoLike;
use App\Models\VideoComment;
use App\Models\UserProgress;
use App\Models\UserChallenge;
use App\Models\UserProfile;

class PointsService
{
    // Point values for each action
    public const POINTS_PROFILE_COMPLETE = 50;
    public const POINTS_EDUCATION_PROFILE = 100;
    public const POINTS_PLAN_GENERATE = 75;
    public const POINTS_WATCH_VIDEO = 10;
    public const POINTS_LIKE_VIDEO = 5;
    public const POINTS_COMMENT_VIDEO = 15;
    public const POINTS_COMPLETE_GOAL = 50;
    public const POINTS_COMPLETE_CHALLENGE = 25;
    public const POINTS_VIEW_SECTORS = 20;
    public const POINTS_VIEW_STREAMS = 20;
    public const POINTS_VIEW_EXAMS = 20;

    // Total available points in the system
    public const TOTAL_AVAILABLE_POINTS = 535; // Sum of all one-time action points

    /**
     * Calculate and return user progress data.
     */
    public static function getUserProgress(int $userId): array
    {
        $earnedPoints = self::calculateEarnedPoints($userId);
        $progressPercentage = self::calculateProgressPercentage($earnedPoints);
        
        return [
            'earned_points' => $earnedPoints,
            'total_points' => self::TOTAL_AVAILABLE_POINTS,
            'progress_percentage' => $progressPercentage,
            'completed_actions' => self::getCompletedActions($userId),
            'pending_actions' => self::getPendingActions($userId),
        ];
    }

    /**
     * Calculate total earned points for a user.
     */
    public static function calculateEarnedPoints(int $userId): int
    {
        $points = 0;

        // Profile completion (50 points)
        if (UserProfile::where('user_id', $userId)->exists()) {
            $points += self::POINTS_PROFILE_COMPLETE;
        }

        // Education profile completion (100 points)
        if (UserEducationProfile::where('user_id', $userId)->exists()) {
            $points += self::POINTS_EDUCATION_PROFILE;
        }

        // Education plan generated (75 points)
        if (UserEducationPlan::where('user_id', $userId)->exists()) {
            $points += self::POINTS_PLAN_GENERATE;
        }

        // Videos watched (10 points each, max based on available videos)
        $totalVideos = Video::count();
        $points += min($totalVideos, 5) * self::POINTS_WATCH_VIDEO; // Limit to 5 videos for now

        // Videos liked (5 points each)
        $likedVideos = VideoLike::where('user_id', $userId)->count();
        $points += $likedVideos * self::POINTS_LIKE_VIDEO;

        // Videos commented (15 points each)
        $commentedVideos = VideoComment::where('user_id', $userId)->count();
        $points += $commentedVideos * self::POINTS_COMMENT_VIDEO;

        // Goals completed (50 points each)
        $completedGoals = UserProgress::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();
        $points += $completedGoals * self::POINTS_COMPLETE_GOAL;

        // Challenges completed (25 points each)
        $completedChallenges = UserChallenge::where('user_id', $userId)
            ->where('is_completed', true)
            ->count();
        $points += $completedChallenges * self::POINTS_COMPLETE_CHALLENGE;

        return $points;
    }

    /**
     * Calculate progress percentage.
     */
    public static function calculateProgressPercentage(int $earnedPoints): int
    {
        if (self::TOTAL_AVAILABLE_POINTS === 0) {
            return 0;
        }
        return min(100, round(($earnedPoints / self::TOTAL_AVAILABLE_POINTS) * 100));
    }

    /**
     * Get list of completed actions.
     */
    public static function getCompletedActions(int $userId): array
    {
        $completed = [];

        if (UserProfile::where('user_id', $userId)->exists()) {
            $completed[] = [
                'action' => 'profile_complete',
                'name' => 'Profile Completed',
                'points' => self::POINTS_PROFILE_COMPLETE,
                'completed' => true,
            ];
        }

        if (UserEducationProfile::where('user_id', $userId)->exists()) {
            $completed[] = [
                'action' => 'education_profile',
                'name' => 'Education Profile Completed',
                'points' => self::POINTS_EDUCATION_PROFILE,
                'completed' => true,
            ];
        }

        if (UserEducationPlan::where('user_id', $userId)->exists()) {
            $completed[] = [
                'action' => 'plan_generate',
                'name' => 'Education Plan Generated',
                'points' => self::POINTS_PLAN_GENERATE,
                'completed' => true,
            ];
        }

        $totalVideos = Video::count();
        $videosWatched = min($totalVideos, 5);
        if ($videosWatched > 0) {
            $completed[] = [
                'action' => 'watch_videos',
                'name' => 'Watch Videos',
                'points' => $videosWatched * self::POINTS_WATCH_VIDEO,
                'completed' => true,
                'detail' => "Watched {$videosWatched} videos",
            ];
        }

        $likedVideos = VideoLike::where('user_id', $userId)->count();
        if ($likedVideos > 0) {
            $completed[] = [
                'action' => 'like_videos',
                'name' => 'Like Videos',
                'points' => $likedVideos * self::POINTS_LIKE_VIDEO,
                'completed' => true,
                'detail' => "Liked {$likedVideos} videos",
            ];
        }

        $commentedVideos = VideoComment::where('user_id', $userId)->count();
        if ($commentedVideos > 0) {
            $completed[] = [
                'action' => 'comment_videos',
                'name' => 'Comment on Videos',
                'points' => $commentedVideos * self::POINTS_COMMENT_VIDEO,
                'completed' => true,
                'detail' => "Commented on {$commentedVideos} videos",
            ];
        }

        $completedGoals = UserProgress::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();
        if ($completedGoals > 0) {
            $completed[] = [
                'action' => 'complete_goals',
                'name' => 'Complete Goals',
                'points' => $completedGoals * self::POINTS_COMPLETE_GOAL,
                'completed' => true,
                'detail' => "Completed {$completedGoals} goals",
            ];
        }

        $completedChallenges = UserChallenge::where('user_id', $userId)
            ->where('is_completed', true)
            ->count();
        if ($completedChallenges > 0) {
            $completed[] = [
                'action' => 'complete_challenges',
                'name' => 'Complete Challenges',
                'points' => $completedChallenges * self::POINTS_COMPLETE_CHALLENGE,
                'completed' => true,
                'detail' => "Completed {$completedChallenges} challenges",
            ];
        }

        return $completed;
    }

    /**
     * Get list of pending actions.
     */
    public static function getPendingActions(int $userId): array
    {
        $pending = [];

        if (!UserProfile::where('user_id', $userId)->exists()) {
            $pending[] = [
                'action' => 'profile_complete',
                'name' => 'Complete Your Profile',
                'points' => self::POINTS_PROFILE_COMPLETE,
                'icon' => 'user',
            ];
        }

        if (!UserEducationProfile::where('user_id', $userId)->exists()) {
            $pending[] = [
                'action' => 'education_profile',
                'name' => 'Create Education Profile',
                'points' => self::POINTS_EDUCATION_PROFILE,
                'icon' => 'graduation-cap',
            ];
        }

        if (!UserEducationPlan::where('user_id', $userId)->exists()) {
            $pending[] = [
                'action' => 'plan_generate',
                'name' => 'Generate Education Plan',
                'points' => self::POINTS_PLAN_GENERATE,
                'icon' => 'clipboard-list',
            ];
        }

        $totalVideos = Video::count();
        if ($totalVideos > 0) {
            $pending[] = [
                'action' => 'watch_videos',
                'name' => 'Watch Educational Videos',
                'points' => self::POINTS_WATCH_VIDEO,
                'icon' => 'play',
            ];
        }

        $pending[] = [
            'action' => 'complete_goals',
            'name' => 'Complete Goals',
            'points' => self::POINTS_COMPLETE_GOAL,
            'icon' => 'bullseye',
        ];

        $pending[] = [
            'action' => 'complete_challenges',
            'name' => 'Complete Challenges',
            'points' => self::POINTS_COMPLETE_CHALLENGE,
            'icon' => 'fire',
        ];

        return $pending;
    }

    /**
     * Award profile completion points.
     */
    public static function awardProfilePoints(int $userId): bool
    {
        if (UserPoint::hasEarnedPoints($userId, 'profile_complete')) {
            return false;
        }

        UserPoint::awardPoints(
            $userId,
            'profile_complete',
            self::POINTS_PROFILE_COMPLETE,
            'Profile completed'
        );

        return true;
    }

    /**
     * Award education profile points.
     */
    public static function awardEducationProfilePoints(int $userId): bool
    {
        if (UserPoint::hasEarnedPoints($userId, 'education_profile')) {
            return false;
        }

        UserPoint::awardPoints(
            $userId,
            'education_profile',
            self::POINTS_EDUCATION_PROFILE,
            'Education profile completed'
        );

        return true;
    }

    /**
     * Award plan generation points.
     */
    public static function awardPlanPoints(int $userId): bool
    {
        if (UserPoint::hasEarnedPoints($userId, 'plan_generate')) {
            return false;
        }

        UserPoint::awardPoints(
            $userId,
            'plan_generate',
            self::POINTS_PLAN_GENERATE,
            'Education plan generated'
        );

        return true;
    }

    /**
     * Award video watch points.
     */
    public static function awardVideoWatchPoints(int $userId, int $videoId): bool
    {
        if (UserPoint::hasEarnedPoints($userId, "video_watch_{$videoId}")) {
            return false;
        }

        UserPoint::awardPoints(
            $userId,
            "video_watch_{$videoId}",
            self::POINTS_WATCH_VIDEO,
            "Watched video #{$videoId}"
        );

        return true;
    }

    /**
     * Award video like points.
     */
    public static function awardVideoLikePoints(int $userId, int $videoId): bool
    {
        $existingLike = VideoLike::where('user_id', $userId)
            ->where('video_id', $videoId)
            ->first();

        if (!$existingLike) {
            VideoLike::create([
                'video_id' => $videoId,
                'user_id' => $userId,
            ]);

            UserPoint::awardPoints(
                $userId,
                "video_like_{$videoId}",
                self::POINTS_LIKE_VIDEO,
                "Liked video #{$videoId}"
            );

            return true;
        }

        return false;
    }

    /**
     * Award video comment points.
     */
    public static function awardVideoCommentPoints(int $userId, int $videoId): bool
    {
        UserPoint::awardPoints(
            $userId,
            "video_comment_{$videoId}",
            self::POINTS_COMMENT_VIDEO,
            "Commented on video #{$videoId}"
        );

        return true;
    }

    /**
     * Award goal completion points.
     */
    public static function awardGoalCompletionPoints(int $userId, int $goalId): bool
    {
        if (UserPoint::hasEarnedPoints($userId, "goal_complete_{$goalId}")) {
            return false;
        }

        UserPoint::awardPoints(
            $userId,
            "goal_complete_{$goalId}",
            self::POINTS_COMPLETE_GOAL,
            "Completed goal #{$goalId}"
        );

        return true;
    }

    /**
     * Award challenge completion points.
     */
    public static function awardChallengeCompletionPoints(int $userId, int $challengeId): bool
    {
        if (UserPoint::hasEarnedPoints($userId, "challenge_complete_{$challengeId}")) {
            return false;
        }

        UserPoint::awardPoints(
            $userId,
            "challenge_complete_{$challengeId}",
            self::POINTS_COMPLETE_CHALLENGE,
            "Completed challenge #{$challengeId}"
        );

        return true;
    }
}

