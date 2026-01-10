<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\JsonDataStore;

class VideoController extends Controller
{
    protected $dataStore;

    public function __construct()
    {
        $this->dataStore = new JsonDataStore();
    }

    /**
     * Display all videos from videos.json file
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');
        
        // Read videos from JSON file
        $jsonPath = resource_path('data/videos.json');
        $jsonData = file_get_contents($jsonPath);
        $videosData = json_decode($jsonData, true);
        
        // Convert arrays to objects for compatibility with the view
        $videos = collect(array_map(function($item) {
            return (object) $item;
        }, $videosData));
        
        // Filter by type if specified
        if ($type !== 'all') {
            $videos = $videos->where('type', $type);
        }
        
        // Get user interactions from JSON store
        $userId = Auth::id();
        $userLikes = [];
        $comments = collect([]);
        
        if ($userId) {
            $likes = $this->dataStore->getByField('video_likes', 'user_id', $userId);
            $userLikes = array_column($likes, 'video_id');
            
            $allComments = $this->dataStore->all('video_comments');
            $comments = collect($allComments)->where('video_id', $videos->pluck('id')->toArray());
        }
        
        return view('videos.index', compact('videos', 'userLikes', 'comments', 'type'));
    }

    /**
     * Like a video
     */
    public function like(Request $request, $videoId)
    {
        $userId = Auth::id();
        
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // Check if already liked
        $existingLike = $this->dataStore->findByTwoFields('video_likes', 'video_id', $videoId, 'user_id', $userId);
        
        if ($existingLike) {
            // Unlike - delete the like
            $this->dataStore->delete('video_likes', $existingLike['id']);
            $liked = false;
        } else {
            // Like - create new like
            $this->dataStore->create('video_likes', [
                'video_id' => $videoId,
                'user_id' => $userId
            ]);
            $liked = true;
        }
        
        // Get like count
        $allLikes = $this->dataStore->getByField('video_likes', 'video_id', $videoId);
        $likeCount = count($allLikes);
        
        return response()->json([
            'liked' => $liked,
            'likeCount' => $likeCount
        ]);
    }

    /**
     * Share a video
     */
    public function share(Request $request, $videoId)
    {
        $userId = Auth::id();
        
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $this->dataStore->create('video_shares', [
            'video_id' => $videoId,
            'user_id' => $userId
        ]);
        
        $allShares = $this->dataStore->getByField('video_shares', 'video_id', $videoId);
        $shareCount = count($allShares);
        
        return response()->json([
            'success' => true,
            'shareCount' => $shareCount
        ]);
    }

    /**
     * Add a comment to a video
     */
    public function comment(Request $request, $videoId)
    {
        $request->validate([
            'comment' => 'required|string|max:500'
        ]);
        
        $userId = Auth::id();
        
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $comment = $this->dataStore->create('video_comments', [
            'video_id' => $videoId,
            'user_id' => $userId,
            'comment' => $request->comment,
            'created_at' => now()->toISOString()
        ]);
        
        // Get user info for the comment
        $user = $this->dataStore->find('users', $userId);
        $comment['user'] = $user ? (object)[
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name']
        ] : null;
        
        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }

    /**
     * Get comments for a video
     */
    public function getComments($videoId)
    {
        $comments = $this->dataStore->getByField('video_comments', 'video_id', $videoId);
        
        // Add user info to each comment
        foreach ($comments as &$comment) {
            $user = $this->dataStore->find('users', $comment['user_id']);
            $comment['user'] = $user ? (object)[
                'id' => $user['id'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name']
            ] : null;
        }
        
        // Sort by created_at descending
        usort($comments, function($a, $b) {
            return strtotime($b['created_at'] ?? 0) - strtotime($a['created_at'] ?? 0);
        });
        
        return response()->json([
            'comments' => $comments
        ]);
    }
}

