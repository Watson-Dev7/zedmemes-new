<?php
function renderCard($imageSrc, $title = "Untitled", $likes = 0) {
    echo <<<HTML
    <div class="card-container" >
        
        <!-- Option Button -->
        <button style="position: absolute; top: 10px; right: 10px; background: transparent; border: none; color: white; font-size: 18px; cursor: pointer;">
            &#8942;
        </button>

        <!-- Image Section -->
        <img src="$imageSrc" alt="$title" style="width: 100%; height: 180px; object-fit: cover;">

        <!-- Content -->
        <div style="padding: 1rem;">
            <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem;">$title</h3>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <form method="post" action="#">
                    <button type="submit" style="background-color: #10b981; color: white; border: none; padding: 0.5rem 0.75rem; border-radius: 4px; cursor: pointer;">
                        ❤️ Like
                    </button>
                </form>
                <span>$likes Likes</span>
            </div>
        </div>
    </div>
HTML;
}
