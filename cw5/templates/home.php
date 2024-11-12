<div class="container">
    <div class="main-content" role="main">
        <div id="home" class="section hero fade-in">
            <h1>Odkrywanie kosmosu: Podróż ludzkości ku gwiazdom</h1>

            <img src="https://cms-image-bucket-production-ap-northeast-1-a7d2.s3.ap-northeast-1.amazonaws.com/images/5/8/6/3/47293685-9-eng-GB/photo_SXM2024021700001938%20(1).jpg"
                 alt="Obraz kosmosu"
                 class="hero-image">

            <p>Poznaj fascynującą historię eksploracji kosmosu i dowiedz się, jak marzenia o podróżach międzygwiezdnych stały się rzeczywistością.</p>
        </div>

        <div class="section topics">
            <?php
            $topics = [
                'early-space-race' => [
                    'title' => 'Początek wyścigu kosmicznego',
                    'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCtBsRLAWTgY4_BXXlvn9XrYyejDEr-UXXo7c-elAYgdzf5blsAVPLEZ-_71mscpbkBDo&usqp=CAU',
                    'description' => 'Intensywna rywalizacja między USA a ZSRR, która zapoczątkowała erę eksploracji kosmosu.'
                ],
                'moon-landing' => [
                      'title' => 'Lądowanie na Księżycu',
                       'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCtBsRLAWTgY4_BXXlvn9XrYyejDEr-UXXo7c-elAYgdzf5blsAVPLEZ-_71mscpbkBDo&usqp=CAU',
                       'description' => '20 lipca 1969 roku, misja Apollo 11 osiągnęła historyczny cel, lądując na Księżycu i umożliwiając ludziom po raz pierwszy postawić stopę na innym ciele niebieskim'
                ],
                'shuttle-era' =>[
                    'title' => 'Era wahadłowców',
                    'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCtBsRLAWTgY4_BXXlvn9XrYyejDEr-UXXo7c-elAYgdzf5blsAVPLEZ-_71mscpbkBDo&usqp=CAU',
                    'description' => 'Program wahadłowców kosmicznych NASA, trwający od 1981 do 2011 roku, zrewolucjonizował sposób, w jaki ludzie i ładunki były transportowane na orbitę i z powrotem.'
                ],
                'iss' =>[
                    'title' => 'ISS',
                    'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCtBsRLAWTgY4_BXXlvn9XrYyejDEr-UXXo7c-elAYgdzf5blsAVPLEZ-_71mscpbkBDo&usqp=CAU',
                    'description' => 'Międzynarodowa Stacja Kosmiczna (ISS) to wielonarodowy projekt badawczy na orbicie okołoziemskiej, będący symbolem współpracy międzynarodowej w eksploracji kosmosu.'
                ],
                'future-missions' =>[
                    'title' => 'Przyszłe misje',
                    'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCtBsRLAWTgY4_BXXlvn9XrYyejDEr-UXXo7c-elAYgdzf5blsAVPLEZ-_71mscpbkBDo&usqp=CAU',
                    'description' => 'Eksploracja kosmosu nie zwalnia tempa. Agencje kosmiczne i prywatne firmy planują ambitne misje, które mają popchnąć ludzkość jeszcze dalej w kosmos.'
                ]
            ];

            foreach ($topics as $id => $topic): ?>
                <div id="<?php echo htmlspecialchars($id); ?>" class="topic-card fade-in">
                    <h3><?php echo htmlspecialchars($topic['title']); ?></h3>
                    <img src="<?php echo htmlspecialchars($topic['image']); ?>" alt="<?php echo htmlspecialchars($topic['title']); ?>" class="image">
                    <p><?php echo htmlspecialchars($topic['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>