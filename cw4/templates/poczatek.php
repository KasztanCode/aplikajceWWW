<?php
?>
<div class="container">
    <div class="main-content" role="main">
        <div id="early-space-race" class="section hero fade-in">
            <h1>Początek wyścigu kosmicznego</h1>

            <img src="https://cms-image-bucket-production-ap-northeast-1-a7d2.s3.ap-northeast-1.amazonaws.com/images/5/8/6/3/47293685-9-eng-GB/photo_SXM2024021700001938%20(1).jpg"
                 alt="Obraz kosmosu"
                 class="hero-image">

            <p>Wyścig kosmiczny był intensywną rywalizacją między Stanami Zjednoczonymi a Związkiem Radzieckim o dominację w eksploracji kosmosu. Trwał od późnych lat 50. do 1975 roku.</p>
        </div>

        <div class="section topics">
            <?php
            $topics = [
                [
                    'title' => 'Sputnik 1',
                    'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/be/Sputnik_asm.jpg/800px-Sputnik_asm.jpg',
                    'description' => '4 października 1957 roku ZSRR wystrzelił Sputnika 1, pierwszego sztucznego satelitę Ziemi, rozpoczynając erę kosmiczną.'
                ],
                [
                    'title' => 'Wystrzelenie Jurija Gagarina',
                    'image' => 'https://upload.wikimedia.org/wikipedia/en/b/b6/Vostok1_big.gif',
                    'description' => '12 kwietnia 1961 roku radziecki kosmonauta Jurij Gagarin stał się pierwszym człowiekiem w kosmosie.'
                ],
                [
                    'title' => 'Projekt Mercury',
                    'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtPEqGlFrWoXV5CxY6E7cYo3YXimG-7hhqnA&s',
                    'description' => 'NASA rozpoczęła program Mercury, którego celem było wysłanie człowieka na orbitę okołoziemską.'
                ],
                [
                    'title' => 'Przemówienie Kennedy\'ego',
                    'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRc5ZV9_tkWs4i8zfG-dyPCmi8_D6xIbi-0Mg&s',
                    'description' => '25 maja 1961 roku prezydent John F. Kennedy ogłosił cel wysłania człowieka na Księżyc przed końcem dekady.'
                ]
            ];

            foreach ($topics as $topic): ?>
                <div class="topic-card fade-in">
                    <h3><?php echo htmlspecialchars($topic['title']); ?></h3>
                    <img src="<?php echo htmlspecialchars($topic['image']); ?>" alt="<?php echo htmlspecialchars($topic['title']); ?>" class="image">
                    <p><?php echo htmlspecialchars($topic['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>