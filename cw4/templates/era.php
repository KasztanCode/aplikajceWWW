<?php
?>
<div class="container">
    <div class="main-content" role="main">
        <div id="space-shuttle" class="section hero fade-in">
            <h1>Era wahadłowców</h1>

            <img src="https://cms-image-bucket-production-ap-northeast-1-a7d2.s3.ap-northeast-1.amazonaws.com/images/5/8/6/3/47293685-9-eng-GB/photo_SXM2024021700001938%20(1).jpg"
                 alt="Obraz kosmosu"
                 class="hero-image">

            <p>Program wahadłowców kosmicznych NASA, trwający od 1981 do 2011 roku, zrewolucjonizował sposób, w jaki ludzie i ładunki były transportowane na orbitę i z powrotem.</p>
        </div>

        <div class="section topics">
            <?php
            $topics = [
                [
                    'title' => 'Columbia',
                    'description' => 'Pierwszy wahadłowiec, który odbył lot kosmiczny w 1981 roku.'
                ],
                [
                    'title' => 'Misje naukowe',
                    'description' => 'Wahadłowce umożliwiły przeprowadzenie wielu misji naukowych, w tym wyniesienie teleskopu Hubble\'a.'
                ],
                [
                    'title' => 'Międzynarodowa współpraca',
                    'description' => 'Wahadłowce odegrały kluczową rolę w budowie i obsłudze Międzynarodowej Stacji Kosmicznej.'
                ],
                [
                    'title' => 'Zakończenie programu',
                    'description' => 'W 2011 roku program wahadłowców zakończył się po 30 latach służby.'
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