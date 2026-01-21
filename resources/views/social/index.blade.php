<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SAMARTH - Social</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #000; font-family: -apple-system, sans-serif; min-height: 100vh; display: flex; justify-content: center; }
        .app { width: 100%; max-width: 400px; background: #000; min-height: 100vh; position: relative; overflow: hidden; }
        .tab { display: none; height: calc(100vh - 110px); overflow-y: auto; padding-top: 50px; overflow-x: hidden; }
        .tab.active { display: block; }
        .story-ring { background: linear-gradient(135deg, #f97316, #ec4899, #8b5cf6); padding: 2px; border-radius: 50%; flex-shrink: 0; }
        .story-ring.seen { background: #555; }
        .heart-burst { animation: heartBurst 0.6s ease-out forwards; }
        @keyframes heartBurst { 0% { transform: scale(0) rotate(0deg); opacity: 1; } 50% { transform: scale(1.2) rotate(-10deg); } 100% { transform: scale(0) rotate(10deg); opacity: 0; } }
        .heartBeat { animation: heartBeat 0.3s ease-in-out; }
        @keyframes heartBeat { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.3); } }
        .sent { background: #e11d48; border-radius: 18px 18px 4px 18px; padding: 8px 12px; }
        .received { background: #262626; border-radius: 18px 18px 18px 4px; padding: 8px 12px; }
        ::-webkit-scrollbar { display: none; }
    </style>
</head>
<body>
    <div class="app">
        <!-- Header -->
        <div class="fixed top-0 w-full max-w-[400px] z-40 bg-black border-b border-gray-800">
            <div class="flex justify-between items-center px-3 h-11">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="text-white"><i class="fas fa-arrow-left"></i></a>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent" style="font-family:cursive">Samarth</h1>
                </div>
                <div class="flex gap-4">
                    <button class="relative" onclick="openNotifications()"><i class="far fa-heart text-lg text-white"></i><div class="absolute -top-0.5 -right-0.5 w-1.5 h-1.5 bg-red-500 rounded-full"></div></button>
                    <button class="relative" onclick="switchTab('chat')"><i class="fab fa-facebook-messenger text-lg text-white"></i><div class="absolute -top-1 -right-1 bg-red-600 text-[7px] w-3 h-3 flex items-center justify-center rounded-full">3</div></button>
                </div>
            </div>
        </div>

        <!-- Home Tab -->
        <div class="tab active" id="home">
            <!-- Stories -->
            <div class="flex gap-3 overflow-x-auto px-3 py-2 border-b border-gray-800 whitespace-nowrap">
                <form id="storyForm" action="{{ route('social.story.create') }}" method="POST" class="hidden">@csrf</form>
                <div class="flex flex-col items-center gap-0.5 shrink-0" onclick="document.getElementById('storyForm').submit()">
                    <div class="w-16 h-16 rounded-full bg-gray-800 border border-gray-700 relative cursor-pointer">
                        <img src="{{ $currentUser['avatar'] ?? 'https://ui-avatars.com/api/?name=Me' }}" class="w-full h-full rounded-full opacity-60">
                        <div class="absolute bottom-0 right-0 bg-blue-500 w-4 h-4 rounded-full flex items-center justify-center border-2 border-black">
                            <i class="fas fa-plus text-[8px] text-white"></i>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-400">You</span>
                </div>
                @foreach($stories as $story)
                <div class="flex flex-col items-center gap-0.5 shrink-0" onclick="openStory('{{ $story['image_url'] }}', '{{ $story['user']['avatar'] }}', '{{ $story['user']['username'] }}')">
                    <div class="w-16 h-16 story-ring p-[1.5px] {{ $story['seen'] ? 'seen' : '' }}">
                        <img src="{{ $story['user']['avatar'] }}" class="w-full h-full rounded-full border border-black object-cover">
                    </div>
                    <span class="text-[10px] text-white">{{ explode(' ', $story['user']['full_name'])[0] }}</span>
                </div>
                @endforeach
            </div>

            <!-- Posts -->
            <div class="pb-16">
                @foreach($posts as $post)
                <div class="border-b border-gray-800 pb-2 mb-1">
                    <div class="flex items-center justify-between px-2 py-1.5">
                        <div class="flex items-center gap-1.5">
                            <div class="story-ring p-[1px] w-8 h-8">
                                <img src="{{ $post['user']['avatar'] }}" class="w-full h-full rounded-full border border-black object-cover">
                            </div>
                            <div>
                                <span class="font-semibold text-xs text-white block">{{ $post['user']['username'] }}</span>
                                @if(isset($post['location']))
                                <span class="text-[9px] text-gray-400 block">{{ $post['location'] }}</span>
                                @endif
                            </div>
                        </div>
                        <i class="fas fa-ellipsis-h text-xs text-gray-500"></i>
                    </div>
                    <div class="relative w-full bg-gray-900" ondblclick="heartAnim(this, {{ $post['id'] }})">
                        <img src="{{ $post['image_url'] }}" class="w-full h-auto object-cover max-h-[500px]">
                    </div>
                    <div class="px-2 pt-1.5">
                        <div class="flex justify-between text-lg mb-0.5">
                            <div class="flex gap-4">
                                <button onclick="toggleLike(this, {{ $post['id'] }})">
                                    <i class="{{ $post['is_liked'] ? 'fas fa-heart text-red-500' : 'far fa-heart text-white' }}"></i>
                                </button>
                                <button onclick="openComments({{ $post['id'] }})"><i class="far fa-comment text-white"></i></button>
                                <button><i class="far fa-paper-plane text-white"></i></button>
                            </div>
                            <button onclick="toggleBookmark(this, {{ $post['id'] }})">
                                <i class="{{ $post['is_bookmarked'] ? 'fas' : 'far' }} fa-bookmark text-white"></i>
                            </button>
                        </div>
                        <p class="font-semibold text-xs text-white mb-0.5"><span class="like-count">{{ $post['likes'] }}</span> likes</p>
                        <p class="text-xs text-white leading-tight mb-0.5">
                            <span class="font-semibold">{{ $post['user']['username'] }}</span> {{ $post['caption'] }}
                        </p>
                        <p class="text-[10px] text-gray-500 cursor-pointer" onclick="openComments({{ $post['id'] }})">View all {{ $post['comments'] }} comments</p>
                        <p class="text-[9px] text-gray-600 uppercase mt-0.5">{{ $post['time_ago'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Explore Tab -->
        <div class="tab" id="explore">
            <div class="px-2 pb-2">
                <div class="relative"><i class="fas fa-search absolute left-2.5 top-2 text-gray-500 text-xs"></i><input type="text" placeholder="Search" class="w-full bg-gray-800 text-white text-xs py-1.5 pl-8 pr-2 rounded-lg focus:outline-none placeholder-gray-500"></div>
            </div>
            <div class="grid grid-cols-3 gap-0.5 pb-16">
                 @foreach($posts as $post)
                <div class="aspect-square bg-gray-900 relative">
                    <img src="{{ $post['image_url'] }}" class="w-full h-full object-cover">
                </div>
                 @endforeach
                 <!-- Fillers -->
                 <div class="aspect-square bg-gray-900"><img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=150&h=150&fit=crop" class="w-full h-full object-cover"></div>
                 <div class="aspect-square bg-gray-900"><img src="https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=150&h=150&fit=crop" class="w-full h-full object-cover"></div>
            </div>
        </div>

        <!-- Create Tab -->
        <div class="tab px-2" id="create">
             <form action="{{ route('social.post.store') }}" method="POST">
                @csrf
                <div class="flex justify-between items-center py-2">
                    <button type="button" class="text-white" onclick="switchTab('home')"><i class="fas fa-times"></i></button>
                    <h2 class="font-bold text-sm text-white">New Post</h2>
                    <button type="submit" class="text-pink-500 font-bold text-xs">Share</button>
                </div>
                <div class="flex gap-2 mb-2">
                    <img src="{{ $currentUser['avatar'] ?? 'https://ui-avatars.com/api/?name=Me' }}" class="w-8 h-8 rounded-full">
                    <textarea name="caption" class="w-full bg-transparent text-white text-xs focus:outline-none h-20 resize-none placeholder-gray-500" placeholder="Write a caption..."></textarea>
                </div>
                <div class="aspect-square bg-gray-800 rounded-lg border border-gray-700 flex flex-col items-center justify-center text-gray-500 mb-2 cursor-pointer">
                    <i class="fas fa-images text-2xl mb-1"></i>
                    <p class="text-xs">Select Photo (Auto-Mocked)</p>
                </div>
            </form>
        </div>

        <!-- Chat Tab -->
        <div class="tab" id="chat">
            <div class="px-2 mb-1">
                <div class="relative"><i class="fas fa-search absolute left-2.5 top-2 text-gray-500 text-xs"></i><input type="text" id="msgSearch" onkeyup="searchUsers()" placeholder="Search (Name, Phone)" class="w-full bg-gray-800 text-white text-xs py-1.5 pl-8 pr-2 rounded-lg focus:outline-none"></div>
            </div>
            <p class="px-2 font-semibold text-xs text-white mb-1">Messages</p>
            <div class="pb-16" id="msgList">
                 @foreach($suggested as $user)
                <div class="flex items-center gap-2 px-2 py-1 hover:bg-gray-900 cursor-pointer" onclick="openChatById({{ $user['id'] }}, '{{ $user['full_name'] }}', '{{ $user['avatar'] }}')">
                    <div class="relative">
                        <img src="{{ $user['avatar'] }}" class="w-10 h-10 rounded-full border border-gray-700">
                        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-black"></div>
                    </div>
                    <div class="flex-1"><p class="font-semibold text-xs text-white">{{ $user['full_name'] }}</p><p class="text-[10px] text-gray-500">Active now</p></div>
                    <i class="far fa-camera text-gray-500 text-base"></i>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Profile Tab -->
        <div class="tab" id="profile">
            <div class="px-3 py-2">
                 <div class="flex justify-between items-center mb-2">
                    <p class="text-lg font-bold text-white">{{ $currentUser['username'] ?? 'user' }} <i class="fas fa-chevron-down text-xs"></i></p>
                    <div class="flex gap-3 text-lg text-white"><i class="far fa-plus-square"></i><i class="fas fa-bars"></i></div>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-20 h-20 story-ring p-[1.5px]"><img src="{{ $currentUser['avatar'] ?? '' }}" class="w-full h-full rounded-full border-2 border-black object-cover"></div>
                    <div class="flex justify-around flex-1 ml-3 text-center">
                        <div><p class="font-bold text-base text-white">{{ count(collect($posts)->filter(fn($p)=>$p['user_id']==$currentUser['id'])) }}</p><p class="text-[10px] text-gray-400">Posts</p></div>
                        <div><p class="font-bold text-base text-white">{{ $currentUser['followers'] ?? 0 }}</p><p class="text-[10px] text-gray-400">Followers</p></div>
                        <div><p class="font-bold text-base text-white">{{ $currentUser['following'] ?? 0 }}</p><p class="text-[10px] text-gray-400">Following</p></div>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="font-semibold text-white">{{ $currentUser['full_name'] ?? 'User' }}</p>
                    <p class="text-xs text-gray-300">{{ $currentUser['bio'] ?? '' }}</p>
                </div>
                <div class="flex gap-2 mb-4">
                    <button class="flex-1 bg-gray-800 py-1.5 rounded text-xs font-semibold border border-gray-700 text-white">Edit Profile</button>
                    <button class="flex-1 bg-gray-800 py-1.5 rounded text-xs font-semibold border border-gray-700 text-white">Share Profile</button>
                </div>
                 <div class="flex border-t border-gray-800">
                    <button class="flex-1 py-2 border-b-2 border-white text-white"><i class="fas fa-th"></i></button>
                    <button class="flex-1 py-2 text-gray-500"><i class="fas fa-id-badge"></i></button>
                </div>
                <div class="grid grid-cols-3 gap-0.5 pb-16">
                     @php $myPosts = collect($posts)->where('user_id', $currentUser['id']); @endphp
                     @forelse($myPosts as $post)
                     <div class="aspect-square bg-gray-900 relative">
                        <img src="{{ $post['image_url'] }}" class="w-full h-full object-cover">
                     </div>
                     @empty
                     <div class="col-span-3 aspect-square bg-gray-900 flex items-center justify-center text-gray-600 text-xs">No posts yet</div>
                     @endforelse
                </div>
            </div>
        </div>

        <!-- Bottom Nav -->
        <div class="fixed bottom-0 w-full max-w-[400px] bg-black border-t border-gray-800 z-50">
            <div class="flex justify-around items-center h-12">
                <button class="nav text-white p-2" onclick="switchTab('home')"><i class="fas fa-home text-2xl"></i></button>
                <button class="nav text-gray-500 p-2" onclick="switchTab('explore')"><i class="fas fa-search text-2xl"></i></button>
                <button class="nav text-gray-500 p-2" onclick="switchTab('create')"><i class="far fa-plus-square text-2xl"></i></button>
                <button class="nav text-gray-500 p-2" onclick="switchTab('chat')"><i class="fab fa-rocketchat text-2xl"></i></button>
                <button class="nav text-gray-500 p-2" onclick="switchTab('profile')">
                    <img src="{{ $currentUser['avatar'] ?? 'https://ui-avatars.com/api/?name=Me' }}" class="w-6 h-6 rounded-full border border-gray-500 object-cover">
                </button>
            </div>
        </div>

        <!-- Overlays -->
        <div id="heart" class="fixed inset-0 z-50 flex items-center justify-center hidden pointer-events-none">
            <i class="fas fa-heart text-white text-6xl text-red-600 heart-burst"></i>
        </div>

        <div id="chatWin" class="fixed inset-0 bg-black z-[60] flex flex-col hidden translate-x-full transition-transform duration-300">
            <div class="flex items-center gap-2 px-2 h-11 border-b border-gray-800 bg-black">
                <button class="text-white" onclick="closeChat()"><i class="fas fa-arrow-left"></i></button>
                <div class="relative"><img id="chatImg" src="" class="w-6 h-6 rounded-full"><div class="absolute bottom-0 right-0 w-2 h-2 bg-green-500 rounded-full border-2 border-black"></div></div>
                <p id="chatName" class="font-semibold text-sm text-white">User</p>
                <div class="flex gap-4 ml-auto text-pink-500"><i class="fas fa-phone"></i><i class="fas fa-video"></i></div>
            </div>
            <div id="chatMsgs" class="flex-1 overflow-y-auto p-2 space-y-2 pb-12">
                <div class="flex justify-end"><div class="sent text-white text-xs px-3 py-1.5">Hi! Saw you were studying.</div></div>
                <div class="flex justify-start"><img id="chatAvatar" src="" class="w-5 h-5 rounded-full mr-1"><div class="received text-white text-xs px-3 py-1.5">Hey! Sure, I'd love to help.</div></div>
            </div>
            <div class="flex items-center gap-2 px-2 py-1.5 border-t border-gray-800 bg-black">
                <div class="w-7 h-7 rounded-full bg-gray-800 flex items-center justify-center text-pink-500"><i class="fas fa-camera text-xs"></i></div>
                <input type="text" id="msgInp" placeholder="Message..." class="flex-1 bg-gray-800 text-white text-xs py-1.5 px-2 rounded-full focus:outline-none">
                <button onclick="sendMsg()" class="text-pink-500 font-semibold text-xs">Send</button>
            </div>
        </div>
        
        <!-- Story Viewer Overlay -->
        <div id="storyViewer" class="absolute inset-0 bg-black z-[70] hidden flex flex-col">
            <div class="h-1 bg-gray-800 w-full mb-2">
                <div id="storyProgress" class="h-full bg-white w-0 transition-all duration-[3000ms] ease-linear"></div>
            </div>
            <div class="flex justify-between items-center px-3 mb-2">
                <div class="flex items-center gap-2">
                     <img id="storyUserImg" src="" class="w-8 h-8 rounded-full border border-gray-500">
                     <span id="storyUserName" class="text-white font-semibold text-sm"></span>
                </div>
                <button onclick="closeStory()" class="text-white"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="flex-1 bg-gray-900 flex items-center justify-center relative">
                 <img id="storyImg" src="" class="max-w-full max-h-full object-contain">
            </div>
            <div class="p-3">
                 <input type="text" placeholder="Send message" class="w-full bg-transparent border border-gray-600 rounded-full py-2 px-4 text-white text-sm focus:outline-none">
            </div>
        </div>

        <!-- Notifications Overlay -->
        <div id="notifOverlay" class="absolute inset-0 bg-black z-[60] hidden flex flex-col">
            <div class="flex items-center gap-2 px-3 h-11 border-b border-gray-800 bg-black">
                <button class="text-white" onclick="document.getElementById('notifOverlay').classList.add('hidden')"><i class="fas fa-arrow-left"></i></button>
                <p class="font-bold text-lg text-white">Notifications</p>
            </div>
            <div id="notifList" class="flex-1 overflow-y-auto p-2"></div>
        </div>

        <!-- Comments Overlay -->
        <div id="commentsOverlay" class="absolute inset-0 bg-black z-[65] hidden flex flex-col translate-y-full transition-transform duration-300">
            <div class="flex justify-center p-2 border-b border-gray-800"><div class="w-10 h-1 bg-gray-700 rounded-full"></div></div>
            <div class="flex items-center gap-2 px-3 py-2 border-b border-gray-800 bg-black">
                <button class="text-white" onclick="closeComments()"><i class="fas fa-arrow-left"></i></button>
                <p class="font-bold text-sm text-white">Comments</p>
            </div>
            <div id="commentsList" class="flex-1 overflow-y-auto p-3 space-y-4"></div>
            <div class="p-3 border-t border-gray-800 bg-black flex gap-2">
                <img src="{{ $currentUser['avatar'] ?? '' }}" class="w-8 h-8 rounded-full border border-gray-600">
                <div class="flex-1 relative">
                    <input type="text" id="commentInp" placeholder="Add a comment..." class="w-full bg-gray-900 text-white rounded-full py-2 px-4 text-xs focus:outline-none focus:ring-1 focus:ring-gray-600">
                    <button onclick="postComment()" class="absolute right-3 top-2 text-blue-500 font-semibold text-xs">Post</button>
                    <input type="hidden" id="currentPostId">
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(t) {
            document.querySelectorAll('.tab').forEach(e => e.classList.remove('active'));
            document.querySelectorAll('.nav').forEach(e => {
                e.classList.replace('text-white', 'text-gray-500');
            });
            document.getElementById(t).classList.add('active');
            
            const m = {home:0, explore:1, create:2, chat:3, profile:4};
            if(m[t]!==undefined) {
                const navBtn = document.querySelectorAll('.nav')[m[t]];
                navBtn.classList.replace('text-gray-500', 'text-white');
            }
            document.querySelector('.app').scrollTop = 0;
        }

        async function toggleLike(b, postId) {
            const i = b.querySelector('i');
            
            try {
                const response = await fetch(`/social/like/${postId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    if (data.liked) {
                        i.className = 'fas fa-heart text-red-500 heartBeat';
                    } else {
                        i.className = 'far fa-heart text-white';
                    }
                    const countSpan = b.closest('.px-2').querySelector('.like-count');
                    if (countSpan) countSpan.innerText = data.count;
                }
            } catch (err) {
                console.error(err);
            }
        }

        async function toggleBookmark(b, postId) {
            const i = b.querySelector('i');
             try {
                const response = await fetch(`/social/bookmark/${postId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                     i.className = data.bookmarked ? 'fas fa-bookmark text-white' : 'far fa-bookmark text-white';
                }
            } catch (err) {
                console.error(err);
            }
        }

        function heartAnim(c, postId) {
            document.getElementById('heart').classList.remove('hidden');
            setTimeout(() => document.getElementById('heart').classList.add('hidden'), 600);
            
            const btn = c.nextElementSibling.querySelector('button');
            toggleLike(btn, postId);
        }

        async function openChat(n, img) {
            document.getElementById('chatName').innerText = n;
            document.getElementById('chatImg').src = img;
            document.getElementById('chatAvatar').src = img;
            
            // Clear current messages
            const msgBox = document.getElementById('chatMsgs');
            msgBox.innerHTML = '';
            
            // Fetch messages
            // We need to find user ID or pass name. Backend updated to find by Name.
            // But getMessages needs ID. This is tricky with current setup. 
            // Workaround: We'll search user first to get ID, or we fetch all messages and filter in JS (inefficient but works for small app).
            // Better: update openChat to accept ID.
            
            // For now, let's just make sending work cleanly with name. 
            // Retrieving history efficiently requires ID.
            // Let's assume we can search by name to get ID again or pass ID in template.
            // Updated template to pass ID.
        }
        
        async function openChatById(id, n, img) {
            document.getElementById('chatName').innerText = n;
            document.getElementById('chatImg').src = img;
             document.getElementById('chatWin').dataset.toName = n; // Store for sending
             
            document.getElementById('chatWin').classList.remove('hidden');
            setTimeout(() => document.getElementById('chatWin').classList.remove('translate-x-full'), 10);
            
            // Fetch history
            const res = await fetch(`/social/messages/${id}`); // We need to implement this endpoint properly or use search
            // Wait, previous backend getMessages expects userId. 
            // In the view loop, we have user ID. Let's pass it.
            if(res.ok) {
                const msgs = await res.json();
                const msgBox = document.getElementById('chatMsgs');
                msgBox.innerHTML = '';
                msgs.forEach(m => {
                    const isMe = m.from_id == {{ $currentUser['id'] }};
                    if(isMe) {
                        msgBox.innerHTML += `<div class="flex justify-end"><div class="sent text-white text-xs px-3 py-1.5">${m.text}</div></div>`;
                    } else {
                         msgBox.innerHTML += `<div class="flex justify-start"><img src="${img}" class="w-5 h-5 rounded-full mr-1"><div class="received text-white text-xs px-3 py-1.5">${m.text}</div></div>`;
                    }
                });
                msgBox.scrollTop = msgBox.scrollHeight;
            }
        }

        function closeChat() {
            document.getElementById('chatWin').classList.add('translate-x-full');
            setTimeout(() => document.getElementById('chatWin').classList.add('hidden'), 300);
        }

        async function sendMsg() {
            const i = document.getElementById('msgInp'), m = i.value.trim();
            const toName = document.getElementById('chatWin').dataset.toName;
            
            if(m && toName) {
                // Optimistic append
                document.getElementById('chatMsgs').innerHTML += '<div class="flex justify-end"><div class="sent text-white text-xs px-3 py-1.5">' + m + '</div></div>';
                i.value = '';
                document.getElementById('chatMsgs').scrollTop = document.getElementById('chatMsgs').scrollHeight;
                
                // Send to backend
                await fetch('/social/message/send', {
                    method: 'POST',
                    headers: {
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                       'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ to_name: toName, text: m })
                });
            }
        }
        
        // Story Logic
        let storyTimeout;
        function openStory(img, userImg, userName) {
            document.getElementById('storyImg').src = img;
            document.getElementById('storyUserImg').src = userImg;
            document.getElementById('storyUserName').innerText = userName;
            
            const viewer = document.getElementById('storyViewer');
            viewer.classList.remove('hidden');
            
            const progress = document.getElementById('storyProgress');
            progress.style.width = '0%';
            
            // Force reflow
            void progress.offsetWidth;
            
            progress.style.width = '100%';
            
            clearTimeout(storyTimeout);
            storyTimeout = setTimeout(closeStory, 3000);
        }
        
        function closeStory() {
            document.getElementById('storyViewer').classList.add('hidden');
            document.getElementById('storyProgress').style.width = '0%';
            clearTimeout(storyTimeout);
        }

        document.addEventListener('keydown', function(e) {
            if(e.key === 'Escape') {
                closeChat();
                closeStory();
            }
        });

        async function searchUsers() {
            const q = document.getElementById('msgSearch').value;
            const res = await fetch(`/social/messages/search?q=${q}`);
            const users = await res.json();
            
            const list = document.getElementById('msgList');
            list.innerHTML = '';
            
            users.forEach(user => {
                list.innerHTML += `
                <div class="flex items-center gap-2 px-2 py-1 hover:bg-gray-900 cursor-pointer" onclick="openChatById(${user.id}, '${user.full_name}', '${user.avatar}')">
                    <div class="relative">
                        <img src="${user.avatar}" class="w-10 h-10 rounded-full border border-gray-700">
                        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-black"></div>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-xs text-white">${user.full_name}</p>
                        <p class="text-[10px] text-gray-500">${user.username} • ${user.phone || ''}</p>
                    </div>
                    <i class="far fa-camera text-gray-500 text-base"></i>
                </div>`;
            });
        }

        async function openNotifications() {
            const el = document.getElementById('notifOverlay');
            el.classList.remove('hidden');
            const res = await fetch('/social/notifications');
            const data = await res.json();
            const list = document.getElementById('notifList');
            list.innerHTML = '';
            
            data.forEach(n => {
                list.innerHTML += `
                <div class="flex items-center gap-3 py-2 border-b border-gray-900">
                    <img src="${n.from_user.avatar}" class="w-10 h-10 rounded-full border border-gray-700">
                    <div class="flex-1 text-sm text-white">
                        <span class="font-semibold">${n.from_user.username}</span> ${n.text}
                        <p class="text-[10px] text-gray-500">${n.time_ago}</p>
                    </div>
                    ${n.post_image ? `<img src="${n.post_image}" class="w-10 h-10 object-cover rounded">` : ''}
                </div>`;
            });
        }

        async function openComments(postId) {
            const el = document.getElementById('commentsOverlay');
            document.getElementById('currentPostId').value = postId;
            el.classList.remove('hidden');
            setTimeout(() => el.classList.remove('translate-y-full'), 10);
            
            const res = await fetch(`/social/comments/${postId}`);
            const data = await res.json();
            const list = document.getElementById('commentsList');
            list.innerHTML = '';
            
            data.forEach(c => {
                list.innerHTML += `
                <div class="flex gap-3">
                    <img src="${c.user.avatar}" class="w-8 h-8 rounded-full border border-gray-700">
                    <div class="text-xs text-white">
                        <p><span class="font-semibold mr-1">${c.user.username}</span>${c.text}</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">${c.time_ago} <span class="ml-2 font-semibold text-gray-400">Reply</span></p>
                    </div>
                    <i class="far fa-heart text-[10px] text-gray-500 ml-auto mt-1"></i>
                </div>`;
            });
        }

        function closeComments() {
            const el = document.getElementById('commentsOverlay');
            el.classList.add('translate-y-full');
            setTimeout(() => el.classList.add('hidden'), 300);
        }

        async function postComment() {
            const postId = document.getElementById('currentPostId').value;
            const text = document.getElementById('commentInp').value;
            if(!text) return;
            
            const res = await fetch(`/social/comments/${postId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ text })
            });
            const data = await res.json();
            if(data.success) {
                document.getElementById('commentInp').value = '';
                openComments(postId); // reload
            }
        }
    </script>
</body>
</html>
