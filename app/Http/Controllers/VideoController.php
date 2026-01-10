<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Video;
use App\Models\VideoComment;
use App\Models\VideoLike;
use App\Models\VideoShare;

class VideoController extends Controller
{
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
        
        // Convert arrays to objects for compatibility with the view (which uses $video->id, etc.)
        $videos = collect(array_map(function($item) {
            return (object) $item;
        }, $videosData));
        
        // Filter by type if specified
        if ($type !== 'all') {
            $videos = $videos->where('type', $type);
        }
        
        // Since we're not using database, set empty arrays for user interactions
        $userLikes = [];
        $comments = collect([]);
        
        return view('videos.index', compact('videos', 'userLikes', 'comments', 'type'));
    }

    /**
     * Like a video
     */
    public function like(Request $request, $videoId)
    {
        $userId = Auth::id();
        
        $existingLike = VideoLike::where('video_id', $videoId)
            ->where('user_id', $userId)
            ->first();
        
        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            VideoLike::create([
                'video_id' => $videoId,
                'user_id' => $userId
            ]);
            $liked = true;
        }
        
        $likeCount = VideoLike::where('video_id', $videoId)->count();
        
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
        
        VideoShare::create([
            'video_id' => $videoId,
            'user_id' => $userId
        ]);
        
        $shareCount = VideoShare::where('video_id', $videoId)->count();
        
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
        
        $comment = VideoComment::create([
            'video_id' => $videoId,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        
        $comment->load('user');
        
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
        $comments = VideoComment::with('user')
            ->where('video_id', $videoId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'comments' => $comments
        ]);
    }
}

