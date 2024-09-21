
<article class="card card-event">
        <header class="card-header card-event-header">
            <h1><?php $post["title"]?></h1>
            <p><?php $post["date"]?> - <?php $post["place"]?> - <?php $post["city"]?></p>
        </header>

        <div class="card-content card-article-content">
            <div class="card-image" >
                <img src="Framework/assets/images/CR2.jpg" alt="image placeholder article">
            </div>
            <div class="card-infos card-event-infos">
                <p><?php $post["content"]?></p>
                <div class="button-open-post">
                    <a href="#" class="button button-primary">lire la suite</a>
                </div>
            </div>
        </div>

        <footer class="card-footer card-event-footer">
            <a href="#"><?php $post["comments"]?></a>
            <p>publié le <?php $post["createdAt"]?></p>
            <ul class="interactions-list">
                <li><a href="" class="interaction interaction-views"><img src="Framework/assets/images/views-icon.svg" alt=""></a></li>
                <li><a href="" class="interaction interaction-like"><img src="Framework/assets/images/heart-icon.svg" alt=""></a></li>
                <li><a href="" class="interaction interaction-share"><img src="Framework/assets/images/link-icon.svg" alt=""></a></li>
            </ul>
        </footer>
    </article>


    <script>

    document.addEventListener('DOMContentLoaded', function() {
    const shareButton = document.querySelector('.interaction-share');
    const likeButton = document.querySelector('.interaction-like');
    const viewCounter = document.querySelector('.interaction-views .interaction-counter');
    const likeCounter = document.querySelector('.interaction-like .interaction-counter');
    
    function updateCounter(counterElement, count) {
        counterElement.textContent = count > 99 ? '99+' : count;
    }

    shareButton.addEventListener('click', function(e) {
        e.preventDefault();
        const postUrl = window.location.href;
        navigator.clipboard.writeText(postUrl).then(function() {
            alert('Lien du post copié.');
        }, function() {
            alert('échec de la copie.');
        });
    });

    let isLiked = false;
    likeButton.addEventListener('click', function(e) {
        e.preventDefault();
        if (!isLiked) {
            isLiked = true;
            const currentLikes = parseInt(likeCounter.textContent) || 0;
            updateCounter(likeCounter, currentLikes + 1);
        }
    });

    function incrementViewCount() {
        const currentViews = parseInt(viewCounter.textContent) || 0;
        updateCounter(viewCounter, currentViews + 1);
        localStorage.setItem('viewed_' + postId, 'true');
    }

    const postId = 1;
    if (!localStorage.getItem('viewed_' + postId)) {
        incrementViewCount();
    }
});
</script>
