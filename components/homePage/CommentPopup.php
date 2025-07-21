<?php
function renderCommentPopup($cardId) {
    ?>
    <div class="comment-popup-overlay" id="comment-popup-<?= $cardId ?>" style="display: none;">
        <div class="comment-popup">
            <div class="comment-popup__header">
                <h3>Comments</h3>
                <button class="comment-popup__close" onclick="closeCommentPopup('<?= $cardId ?>')">&times;</button>
            </div>
            <div class="comment-popup__body" id="comment-list-<?= $cardId ?>">
                <!-- Comments will be loaded here -->
                <div class="comment">
                    <img src="https://ui-avatars.com/api/?name=User&background=random" class="comment__avatar">
                    <div class="comment__content">
                        <span class="comment__author">@meme_lover</span>
                        <p class="comment__text">This is a sample comment!</p>
                        <span class="comment__time">2h ago</span>
                    </div>
                </div>
            </div>
            <form class="comment-form" onsubmit="submitComment(event, '<?= $cardId ?>')">
                <input type="text" class="comment-input" placeholder="Add a comment..." required>
                <button type="submit" class="comment-submit">Post</button>
            </form>
        </div>
    </div>
    <?php
}
?>

<style>
.comment-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.comment-popup {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    max-height: 80vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.comment-popup__header {
    padding: 16px;
    border-bottom: 1px solid #efefef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.comment-popup__header h3 {
    margin: 0;
    font-size: 18px;
    color: #262626;
}

.comment-popup__close {
    background: none;
    border: none;
    font-size: 28px;
    cursor: pointer;
    color: #262626;
    line-height: 1;
    padding: 0 8px;
}

.comment-popup__body {
    padding: 16px;
    overflow-y: auto;
    flex: 1;
}

.comment {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
}

.comment__avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.comment__content {
    flex: 1;
}

.comment__author {
    font-weight: 600;
    font-size: 14px;
    color: #262626;
    margin-right: 8px;
}

.comment__text {
    margin: 4px 0 6px;
    font-size: 14px;
    line-height: 1.4;
}

.comment__time {
    font-size: 10px;
    color: #8e8e8e;
}

.comment-form {
    display: flex;
    padding: 16px;
    border-top: 1px solid #efefef;
    gap: 8px;
}

.comment-input {
    flex: 1;
    border: 1px solid #dbdbdb;
    border-radius: 20px;
    padding: 10px 16px;
    font-size: 14px;
    outline: none;
}

.comment-submit {
    background: #0095f6;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 0 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.comment-submit:hover {
    background: #0077c2;
}
</style>

<script>
function openCommentPopup(cardId) {
    document.getElementById(`comment-popup-${cardId}`).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeCommentPopup(cardId) {
    document.getElementById(`comment-popup-${cardId}`).style.display = 'none';
    document.body.style.overflow = '';
}

function submitComment(event, cardId) {
    event.preventDefault();
    const input = event.target.querySelector('.comment-input');
    const commentText = input.value.trim();
    
    if (!commentText) return;
    
    const commentList = document.getElementById(`comment-list-${cardId}`);
    const comment = document.createElement('div');
    comment.className = 'comment';
    comment.innerHTML = `
        <img src="https://ui-avatars.com/api/?name=User&background=random" class="comment__avatar">
        <div class="comment__content">
            <span class="comment__author">@current_user</span>
            <p class="comment__text">${escapeHtml(commentText)}</p>
            <span class="comment__time">Just now</span>
        </div>
    `;
    
    commentList.prepend(comment);
    input.value = '';
    
    // Here you would typically make an API call to save the comment
    // fetch('/api/comments', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify({ cardId, text: commentText })
    // });
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Close popup when clicking outside
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('comment-popup-overlay')) {
        event.target.style.display = 'none';
        document.body.style.overflow = '';
    }
});
</script>
