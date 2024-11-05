<?php
?>
<div class="container">
    <div class="main-content" role="main">
        <div id="moon-landing" class="section hero fade-in">
            <h1>Lądowanie na Księżycu</h1>

            <img src="https://cms-image-bucket-production-ap-northeast-1-a7d2.s3.ap-northeast-1.amazonaws.com/images/5/8/6/3/47293685-9-eng-GB/photo_SXM2024021700001938%20(1).jpg"
                 alt="Obraz kosmosu"
                 class="hero-image">

            <p>20 lipca 1969 roku, misja Apollo 11 osiągnęła historyczny cel, lądując na Księżycu i umożliwiając ludziom po raz pierwszy postawić stopę na innym ciele niebieskim.</p>
        </div>

        <div class="section topics">
            <?php
            $topics = [
                [
                    'title' => 'Apollo 11',
                    'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3d/Apollo_11_Crew.jpg/240px-Apollo_11_Crew.jpg',
                    'description' => 'Misja Apollo 11 z astronautami Neilem Armstrongiem, Buzzem Aldrinem i Michaelem Collinsem.'
                ],
                [
                    'title' => '"Mały krok dla człowieka"',
                    'image' => 'https://media-cldnry.s-nbcnews.com/image/upload/msnbc/2015_30/364161/moonlanding_004_gettyimages-851491__1437422133.jpg',
                    'description' => 'Słynne słowa Neila Armstronga po wyjściu na powierzchnię Księżyca.'
                ],
                [
                    'title' => 'Eksperymenty naukowe',
                    'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQC-OQW3xkpxDpMRZx9IX-dr72jBHzrR0qwgg&s',
                    'description' => 'Astronauci przeprowadzili szereg eksperymentów naukowych i zebrali próbki księżycowe.'
                ],
                [
                    'title' => 'Wpływ na świat',
                    'image' => 'https://orbitaltoday.com/wp-content/uploads/2021/12/Spaceflight-and-Space-exploration-effects-on-the-environment-900x600-1.jpg',
                    'description' => 'Lądowanie na Księżycu było wydarzeniem oglądanym przez miliony ludzi na całym świecie i miało ogromny wpływ na kulturę i naukę.'
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