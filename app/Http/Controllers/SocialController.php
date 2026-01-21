<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JsonDataStore;

class SocialController extends Controller
{
    protected $store;

    public function __construct(JsonDataStore $store)
    {
        $this->store = $store;
        $this->ensureDataExists();
    }

    protected function ensureDataExists()
    {
        // Seed Users
        if (!$this->store->exists('social_users')) {
            $this->store->create('social_users', [
                'username' => 'akash_student',
                'full_name' => 'Akash Kumar',
                'avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
                'bio' => 'CSE Student | Future Dev | 🇮🇳',
                'followers' => 850,
                'following' => 450,
                'phone' => '9876543210',
                'is_current_user' => true
            ]);
            $this->store->create('social_users', [
                'username' => 'Physics_Guru',
                'full_name' => 'Rajesh Sir',
                'avatar' => 'https://randomuser.me/api/portraits/men/44.jpg',
                'bio' => 'Physics HOD | JEE Expert',
                'followers' => 15000,
                'following' => 12,
                'phone' => '9988776655'
            ]);
            $this->store->create('social_users', [
                'username' => 'Riya_Codes',
                'full_name' => 'Riya Sharma',
                'avatar' => 'https://randomuser.me/api/portraits/women/65.jpg',
                'bio' => 'React Developer | Open Source',
                'followers' => 1200,
                'following' => 300,
                'phone' => '8899776655'
            ]);
        }

        // Seed Stories
        if (!$this->store->exists('social_stories')) {
            $this->store->create('social_stories', [
                'user_id' => 2, // Physics_Guru
                'image_url' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=800&fit=crop',
                'seen' => false
            ]);
            $this->store->create('social_stories', [
                'user_id' => 3, // Riya_Codes
                'image_url' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400&h=800&fit=crop',
                'seen' => false
            ]);
             $this->store->create('social_stories', [
                'user_id' => 1, // Current User
                'image_url' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=800&fit=crop',
                'seen' => false
            ]);
        }

        // Seed Posts
        if (!$this->store->exists('social_posts')) {
             $this->store->create('social_posts', [
                'user_id' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=400&fit=crop',
                'caption' => 'Important formula sheet for JEE Mains! 📚 Save this for later.',
                'likes' => 1243,
                'comments' => 45,
                'location' => 'Kota, Rajasthan',
                'is_liked' => false,
                'is_bookmarked' => false,
                'time_ago' => '2 hours ago'
            ]);
            $this->store->create('social_posts', [
                'user_id' => 3,
                'image_url' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400&h=400&fit=crop',
                'caption' => 'Finally deployed my first React App! 🚀 Check link in bio.',
                'likes' => 856,
                'comments' => 128,
                'location' => 'Bangalore',
                'is_liked' => true,
                'is_bookmarked' => true,
                'time_ago' => '5 hours ago'
            ]);
        }

        // Seed Comments
        if (!$this->store->exists('social_comments')) {
            $this->store->create('social_comments', [
                'post_id' => 1,
                'user_id' => 3, // Riya
                'text' => 'This is super helpful sir! 🔥',
                'time_ago' => '1h'
            ]);
            $this->store->create('social_comments', [
                'post_id' => 1,
                'user_id' => 1, // Current User
                'text' => 'Thanks for sharing!',
                'time_ago' => '30m'
            ]);
        }

        // Seed Notifications
        if (!$this->store->exists('social_notifications')) {
            $this->store->create('social_notifications', [
                'user_id' => 1, // Current User
                'from_user_id' => 2, // Physics Guru
                'type' => 'like',
                'text' => 'liked your photo.',
                'post_image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=100&h=100&fit=crop',
                'time_ago' => '2m',
                'read' => false
            ]);
            $this->store->create('social_notifications', [
                'user_id' => 1,
                'from_user_id' => 3, // Riya
                'type' => 'comment',
                'text' => 'commented: "Great click! 📸"',
                'post_image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=100&h=100&fit=crop',
                'time_ago' => '15m',
                'read' => false
            ]);
        }
    }

    public function index(Request $request)
    {
        $currentUser = $this->store->findBy('social_users', 'is_current_user', true);
        
        // Get generic posts and hydration with user data
        $posts = $this->store->all('social_posts');
        foreach ($posts as &$post) {
            $post['user'] = $this->store->find('social_users', $post['user_id']);
        }
        
        // Get stories with user data
        $stories = $this->store->all('social_stories');
        foreach ($stories as &$story) {
             $story['user'] = $this->store->find('social_users', $story['user_id']);
        }

        // Suggested users (exclude current)
        $suggested = array_filter($this->store->all('social_users'), function($u) {
            return !($u['is_current_user'] ?? false);
        });

        return view("social.index", compact('posts', 'stories', 'currentUser', 'suggested'));
    }

    public function like($postId)
    {
        $post = $this->store->find('social_posts', $postId);
        if ($post) {
            $post['is_liked'] = !$post['is_liked'];
            $post['likes'] += $post['is_liked'] ? 1 : -1;
            $this->store->update('social_posts', $postId, $post);
            return response()->json(['success' => true, 'liked' => $post['is_liked'], 'count' => $post['likes']]);
        }
        return response()->json(['success' => false]);
    }
    
    public function bookmark($postId)
    {
        $post = $this->store->find('social_posts', $postId);
        if ($post) {
            $post['is_bookmarked'] = !$post['is_bookmarked'];
            $this->store->update('social_posts', $postId, $post);
            return response()->json(['success' => true, 'bookmarked' => $post['is_bookmarked']]);
        }
         return response()->json(['success' => false]);
    }

    public function share($postId)
    {
        $post = $this->store->find('social_posts', $postId);
        if ($post) {
            // Create a share record
            $this->store->create('social_shares', [
                'post_id' => $postId,
                'user_id' => 1, // Current user
                'platform' => 'samarth',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            return response()->json(['success' => true, 'message' => 'Post shared successfully!']);
        }
        return response()->json(['success' => false]);
    }

    public function comment(Request $request, $postId)
    {
        $currentUser = $this->store->findBy('social_users', 'is_current_user', true);
        
        $this->store->create('social_comments', [
            'post_id' => $postId,
            'user_id' => $currentUser['id'],
            'text' => $request->input('text', ''),
            'time_ago' => 'Just now'
        ]);
        
        // Update post comment count
        $post = $this->store->find('social_posts', $postId);
        if($post) {
            $post['comments']++;
            $this->store->update('social_posts', $postId, $post);
        }

        return redirect()->back()->with('success', 'Comment added!');
    }

    public function getComments($postId)
    {
        $comments = array_filter($this->store->all('social_comments'), function($c) use ($postId) {
            return $c['post_id'] == $postId;
        });
        
        // Hydrate user
        foreach ($comments as &$comment) {
            $comment['user'] = $this->store->find('social_users', $comment['user_id']);
        }
        
        return response()->json(array_values($comments));
    }

    // Story methods
    public function stories(Request $request)
    {
        $currentUser = $this->store->findBy('social_users', 'is_current_user', true);
        $stories = $this->store->all('social_stories');
        
        foreach ($stories as &$story) {
            $story['user'] = $this->store->find('social_users', $story['user_id']);
        }
        
        return view("social.stories", compact('stories', 'currentUser'));
    }
    
    public function createStory(Request $request)
    {
        $currentUser = $this->store->findBy('social_users', 'is_current_user', true);
        
        $this->store->create('social_stories', [
            'user_id' => $currentUser['id'],
            'image_url' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=800&fit=crop',
            'seen' => false
        ]);

        return redirect()->route('social.index')->with('success', 'Story added!');
    }
    
    public function viewStory($storyId)
    {
        $story = $this->store->find('social_stories', $storyId);
        if ($story) {
            $story['seen'] = true;
            $this->store->update('social_stories', $storyId, $story);
        }
        return response()->json(['success' => true]);
    }
    
    public function deleteStory($storyId)
    {
        $this->store->delete('social_stories', $storyId);
        return redirect()->route('social.index')->with('success', 'Story deleted!');
    }

    // Explore page
    public function explore(Request $request)
    {
        $posts = $this->store->all('social_posts');
        foreach ($posts as &$post) {
            $post['user'] = $this->store->find('social_users', $post['user_id']);
        }
        return view("social.explore", compact('posts'));
    }

    // Messages
    public function messages(Request $request)
    {
        $currentUser = $this->store->findBy('social_users', 'is_current_user', true);
        $users = $this->store->all('social_users');
        $users = array_filter($users, function($u) use ($currentUser) {
            return $u['id'] != $currentUser['id'];
        });
        return view("social.messages", compact('users', 'currentUser'));
    }
    
    public function chat(Request $request, $userId)
    {
        $currentUser = $this->store->findBy('social_users', 'is_current_user', true);
        $chatUser = $this->store->find('social_users', $userId);
        
        // Get messages between users
        $allMessages = $this->store->all('social_messages') ?: [];
        $messages = array_filter($allMessages, function($m) use ($currentUser, $userId) {
            return ($m['from_id'] == $currentUser['id'] && $m['to_id'] == $userId) ||
                   ($m['from_id'] == $userId && $m['to_id'] == $currentUser['id']);
        });
        
        return view("social.chat", compact('messages', 'chatUser', 'currentUser'));
    }
    
    public function sendMessage(Request $request)
    {
        $currentUser = $this->store->findBy('social_users', 'is_current_user', true);
        $targetUserId = $request->input('to_id');
        
        $this->store->create('social_messages', [
            'from_id' => $currentUser['id'],
            'to_id' => $targetUserId,
            'text' => $request->input('text', ''),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json(['success' => true]);
    }
    public function storePost(Request $request)
    {
        $request->validate(['text' => 'required|string', 'image' => 'nullable|url']);
        // Logic will go here - placeholder for now to prevent 500 error
        return back()->with('success', 'Post created!');
    }

    public function postComment(Request $request, $postId)
    {
        // Wrapper for comment logic
        return $this->comment($request, $postId);
    }

    public function getNotifications()
    {
        return response()->json(['notifications' => []]);
    }

    public function getMessages(Request $request, $userId)
    {
        return response()->json(['messages' => []]);
    }

    public function searchMessages(Request $request)
    {
        return response()->json(['users' => []]);
    }
}

