
<div class="container">
    <div class="main-content filmy" role="main">
        <div class="section hero fade-in">
            <h1>Fascynujące filmy o eksploracji kosmosu</h1>
            <p>Zobacz wybrane materiały dokumentalne o podboju kosmosu i najważniejszych misjach kosmicznych.</p>
        </div>

        <div class="videos">
            <?php
            $videos = [
                [
                    'title' => 'Historia programu Apollo',
                    'description' => 'Dokument przedstawiający historię programu Apollo i pierwszego lądowania człowieka na Księżycu. Zobacz jak przebiegały przygotowania do tej historycznej misji i jakie wyzwania stały przed astronautami.',
                    'embedUrl' => 'https://www.youtube.com/embed/2uyTgdzH7u4',
                ],
                [
                    'title' => 'Międzynarodowa Stacja Kosmiczna',
                    'description' => 'Życie na Międzynarodowej Stacji Kosmicznej i jej rola w badaniu kosmosu. Poznaj codzienne życie astronautów na orbicie i dowiedz się, jakie eksperymenty są tam prowadzone.',
                    'embedUrl' => 'https://www.youtube.com/embed/SOCixRhRGDw',
                ],
                [
                    'title' => 'SpaceX i przyszłość lotów kosmicznych',
                    'description' => 'Jak prywatne firmy kosmiczne zmieniają przyszłość eksploracji kosmosu. Zobacz najnowsze osiągnięcia SpaceX i plany na przyszłe misje załogowe na Marsa.',
                    'embedUrl' => 'https://www.youtube.com/embed/zqE-ultsWt0',
                ]
            ];

            foreach ($videos as $video): ?>
                <div class="video-card fade-in">
                    <h3><?php echo htmlspecialchars($video['title']); ?></h3>
                    <div class="video-container">
                        <iframe
                            src="<?php echo htmlspecialchars($video['embedUrl']); ?>"
                            title="<?php echo htmlspecialchars($video['title']); ?>"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                    <p><?php echo htmlspecialchars($video['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>