<?php
function renderCard($imageSrc, $title = "Untitled", $likes = 0, $username = "User") {
    // Generate a unique ID for each card for JavaScript interactions
    $cardId = 'card-' . uniqid();
    
    // Format username for display
    $displayUsername = htmlspecialchars($username);
    $initials = strtoupper(substr($username, 0, 2));
    $bgColor = substr(md5($username), 0, 6); // Generate a consistent color based on username
    
    // Process image path before output
    $cleanPath = ltrim($imageSrc, '/');
    // If it's a local file that doesn't exist, try the uploads directory
    if (!filter_var($cleanPath, FILTER_VALIDATE_URL) && !file_exists($cleanPath) && file_exists('uploads/memes/' . basename($cleanPath))) {
        $cleanPath = 'uploads/memes/' . basename($cleanPath);
    }
    // If still not found, use a placeholder
    $finalPath = (file_exists($cleanPath) || filter_var($cleanPath, FILTER_VALIDATE_URL)) 
        ? $cleanPath 
        : 'https://via.placeholder.com/500x500?text=Image+Not+Found';
    $finalPath = htmlspecialchars($finalPath);
    $altText = htmlspecialchars($title);
    
    // Debug output - uncomment if needed
    // error_log("Image source: $imageSrc");
    // error_log("Final path: $finalPath");
    
    echo <<<HTML
    <div class="meme-card" id="$cardId">
        <!-- Card Header with User Info -->
        <div class="meme-card__header">
            <div class="meme-card__user">
                <div class="meme-card__avatar" style="background-color: #$bgColor">$initials</div>
                <div class="meme-card__user-info">
                    <span class="meme-card__username">@$displayUsername</span>
                    <span class="meme-card__time">Shared recently</span>
                </div>
            </div>
            <button class="meme-card__more" aria-label="More options">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="1"></circle>
                    <circle cx="12" cy="5" r="1"></circle>
                    <circle cx="12" cy="19" r="1"></circle>
                </svg>
            </button>
        </div>
        
        <!-- Card Image -->
        <div class="meme-card__image">
            <img src="$finalPath" 
                 alt="$altText" 
                 loading="lazy" 
                 onerror="this.onerror=null; this.src='https://via.placeholder.com/500x500?text=Image+Not+Found';">
        </div>
        
        <!-- Card Actions -->
        <div class="meme-card__actions">
            <button class="meme-card__action like-btn" data-card="$cardId" aria-label="Like">
                <svg class="like-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span class="like-count">$likes</span>
            </button>
            
            <button class="meme-card__action" aria-label="Comment">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <span>42</span>
            </button>
            
            <button class="meme-card__action" aria-label="Share">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                    <polyline points="16 6 12 2 8 6"></polyline>
                    <line x1="12" y1="2" x2="12" y2="15"></line>
                </svg>
            </button>
            
            <button class="meme-card__action save-btn" aria-label="Save">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                </svg>
            </button>
        </div>
        
        <!-- Card Footer -->
        <div class="meme-card__footer">
            <div class="meme-card__likes">
                <span class="like-count">$likes</span> likes
            </div>
            <h3 class="meme-card__title">$title</h3>
            <div class="meme-card__stats">
                <span class="meme-card__comments">View all 42 comments</span>
            </div>
        </div>
    </div>
    
    <style>
    .meme-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #f0f0f0;
    }
    
    .meme-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .meme-card__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        border-bottom: 1px solid #f5f5f5;
    }
    
    .meme-card__user {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .meme-card__avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
    }
    
    .meme-card__user-info {
        display: flex;
        flex-direction: column;
    }
    
    .meme-card__username {
        font-weight: 600;
        font-size: 14px;
        color: #262626;
    }
    
    .meme-card__time {
        font-size: 12px;
        color: #8e8e8e;
    }
    
    .meme-card__more {
        background: none;
        border: none;
        color: #262626;
        cursor: pointer;
        padding: 8px;
        margin: -8px;
        border-radius: 50%;
        transition: background 0.2s;
    }
    
    .meme-card__more:hover {
        background: #f5f5f5;
    }
    
    .meme-card__image {
        width: 100%;
        position: relative;
        background: #fafafa;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 300px;
        max-height: 500px;
        overflow: hidden;
    }
    
    .meme-card__image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        max-height: 500px;
    }
    
    .meme-card__actions {
        display: flex;
        padding: 12px 16px;
        gap: 20px;
        border-top: 1px solid #f5f5f5;
    }
    
    .meme-card__action {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #262626;
        padding: 8px;
        margin: -8px 0;
        border-radius: 4px;
        transition: all 0.2s;
    }
    
    .meme-card__action:hover {
        background: #f5f5f5;
    }
    
    .meme-card__action svg {
        width: 24px;
        height: 24px;
    }
    
    .meme-card__action.like-btn.liked {
        color: #ed4956;
    }
    
    .meme-card__action.like-btn.liked svg {
        fill: #ed4956;
    }
    
    .meme-card__footer {
        padding: 8px 16px 16px;
    }
    
    .meme-card__likes {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
    }
    
    .meme-card__title {
        font-size: 14px;
        margin: 0 0 8px;
        line-height: 1.4;
    }
    
    .meme-card__stats {
        font-size: 12px;
        color: #8e8e8e;
    }
    
    .meme-card__comments {
        cursor: pointer;
    }
    
    .meme-card__comments:hover {
        color: #8e8e8e;
    }
    
    /* Animation for like */
    @keyframes like {
        0% { transform: scale(1); }
        25% { transform: scale(1.2); }
        50% { transform: scale(0.95); }
        100% { transform: scale(1); }
    }
    
    .meme-card__action.like-btn.liked svg {
        animation: like 0.5s ease-in-out;
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const card = document.getElementById('$cardId');
        const likeBtn = card.querySelector('.like-btn');
        const likeCount = likeBtn.querySelector('.like-count');
        
        likeBtn.addEventListener('click', function() {
            const isLiked = likeBtn.classList.toggle('liked');
            let count = parseInt(likeCount.textContent);
            
            likeCount.textContent = isLiked ? count + 1 : count - 1;
            
            // Here you would make an AJAX call to update the like count on the server
            // fetch('/api/like', {
            //     method: 'POST',
            //     body: JSON.stringify({ 
            //         cardId: '$cardId', 
            //         liked: isLiked 
            //     }),
            //     headers: {
            //         'Content-Type': 'application/json'
            //     }
            // });
        });
        
        // Double tap to like
        let lastTap = 0;
        const image = card.querySelector('.meme-card__image');
        
        image.addEventListener('click', function(e) {
            const currentTime = new Date().getTime();
            const tapLength = currentTime - lastTap;
            
            if (tapLength < 300 && tapLength > 0) {
                // Double tap detected
                if (!likeBtn.classList.contains('liked')) {
                    likeBtn.classList.add('liked');
                    likeCount.textContent = parseInt(likeCount.textContent) + 1;
                    
                    // Show floating heart
                    const heart = document.createElement('div');
                    heart.innerHTML = '❤️';
                    heart.style.position = 'absolute';
                    heart.style.fontSize = '60px';
                    heart.style.opacity = '0';
                    heart.style.transform = 'scale(0)';
                    heart.style.transition = 'all 0.5s';
                    heart.style.pointerEvents = 'none';
                    heart.style.left = (e.pageX - 30) + 'px';
                    heart.style.top = (e.pageY - 30) + 'px';
                    document.body.appendChild(heart);
                    
                    setTimeout(() => {
                        heart.style.opacity = '1';
                        heart.style.transform = 'scale(1.2)';
                    }, 10);
                    
                    setTimeout(() => {
                        heart.style.opacity = '0';
                        heart.style.transform = 'scale(0.5)';
                        setTimeout(() => heart.remove(), 500);
                    }, 500);
                }
            }
            lastTap = currentTime;
        });
    });
    </script>
HTML;
}
