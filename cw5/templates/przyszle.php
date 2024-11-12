<?php
?>
<div class="container">
    <div class="main-content" role="main">
        <div id="future-missions" class="section hero fade-in">
            <h1>Przyszłe misje kosmiczne</h1>

            <img src="https://cms-image-bucket-production-ap-northeast-1-a7d2.s3.ap-northeast-1.amazonaws.com/images/5/8/6/3/47293685-9-eng-GB/photo_SXM2024021700001938%20(1).jpg"
                 alt="Obraz kosmosu"
                 class="hero-image">

            <p>Eksploracja kosmosu nie zwalnia tempa. Agencje kosmiczne i prywatne firmy planują ambitne misje, które mają popchnąć ludzkość jeszcze dalej w kosmos.</p>
        </div>

        <div class="section topics">
            <?php
            $topics = [
                [
                    'title' => 'Powrót na Księżyc',
                    'description' => 'Plany NASA i innych agencji dotyczące powrotu ludzi na Księżyc i ustanowienia stałej obecności.'
                ],
                [
                    'title' => 'Misje na Marsa',
                    'description' => 'Plany wysłania ludzi na Marsa i potencjalnej kolonizacji Czerwonej Planety.'
                ],
                [
                    'title' => 'Eksploracja asteroid',
                    'description' => 'Misje mające na celu badanie i potencjalne wykorzystanie zasobów z asteroid.'
                ],
                [
                    'title' => 'Teleskopy nowej generacji',
                    'description' => 'Plany budowy zaawansowanych teleskopów kosmicznych do badania odległych zakątków wszechświata.'
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