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

    </div>
HTML;
}
