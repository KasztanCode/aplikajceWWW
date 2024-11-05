<?php
?>
<div class="container">
    <div class="main-content" role="main">
        <div id="iss" class="section hero fade-in">
            <h1>Międzynarodowa Stacja Kosmiczna (ISS)</h1>

            <img src="https://cms-image-bucket-production-ap-northeast-1-a7d2.s3.ap-northeast-1.amazonaws.com/images/5/8/6/3/47293685-9-eng-GB/photo_SXM2024021700001938%20(1).jpg"
                 alt="Obraz kosmosu"
                 class="hero-image">

            <p>Międzynarodowa Stacja Kosmiczna (ISS) to wielonarodowy projekt badawczy na orbicie okołoziemskiej, będący symbolem współpracy międzynarodowej w eksploracji kosmosu.</p>
        </div>

        <div class="section topics">
            <?php
            $topics = [
                [
                    'title' => 'Budowa i rozwój',
                    'description' => 'ISS jest budowana i rozwijana od 1998 roku, z udziałem wielu krajów.'
                ],
                [
                    'title' => 'Badania naukowe',
                    'description' => 'Na ISS prowadzone są liczne eksperymenty z zakresu biologii, fizyki, astronomii i innych dziedzin.'
                ],
                [
                    'title' => 'Życie na stacji',
                    'description' => 'Astronauci mieszkają i pracują na ISS, prowadząc badania i utrzymując stację.'
                ],
                [
                    'title' => 'Przyszłość ISS',
                    'description' => 'Plany dotyczące przyszłości stacji, w tym jej roli w przyszłych misjach kosmicznych.'
                ]
            ];

            foreach ($topics as $topic): ?>
                <div class="topic-card fade-in">
                    <h3><?php echo htmlspecialchars($topic['title']); ?></h3>
                    <p><?php echo htmlspecialchars($topic['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>