<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BattleShip In The Galaxy</title>
    <link rel="stylesheet" href="<?= $basePath ?>/public/css/app.css">
</head>
<body>

    <header class="section">
        <div class="container">
            <h1 class="title has-text-centered">
                BattleShip In The Galaxy
            </h1>
            <h2 class="subtitle has-text-centered">
                Le premier jeu de bataille navale 100% Galaxy
            </h2>
        </div>
    </header>

<section class="section">
    <div class="content">
        <h3>Instructions</h3>
        <blockquote id="instructions">
            A vous de jouer
        </blockquote>
    </div>
</section>

<section class="container has-text-centered">
    <div class="button is-link btn-generate">Nouvelle Partie</div>
</section>

<section class="section">
    <div class="container">
        <div class="columns">

            <!-- VOS TIRS -->
            <div class="column">
                <h3 class="subtitle has-text-centered">Vos tirs</h3>

                <!-- Pour créer le tableau :
                - première ligne c'est
                - une case vide, puis 10 cases-titre "lettre"-->

                <div class="columns is-gapless is-mobile bs-cases">
                    <div class="column bs-case">
                    <div class="bs-case__none"></div>
                    </div>

                    <!-- générer les 10 cases lettre : -->
                    <?php for ($code=65; $code < (65 + $boardWidth); $code++) : ?>
                <div class="column bs-case">
                <div class="bs-case__title"><?= chr($code) ?></div>
                </div>
                <?php endfor; ?>

                </div>

                <!-- - les 10 lignes suivantes
                - la première case qui contient le numéro de la ligne
                - puis 10 cases vides -->
                <?php for ($row=1; $row <= $boardHeight; $row++) : ?>
                    <div class="columns is-gapless is-mobile bs-cases">

                        <div class="column bs-case">
                            <div class="bs-case__title"><?= $row ?></div>
                        </div>

                        <?php for ($col=1; $col <= $boardWidth; $col++) : ?>
                            <div class="column bs-case">
                                <div
                                    class="bs-case__fury"
                                    data-coordinates="<?=$col?>-<?=$row?>"
                                    ></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endfor; ?>
            </div>

            <!-- VOS VAISSEAUX -->
            <div class="column">
                <h3 class="subtitle has-text-centered">Vos vaisseaux</h3>

                <!-- Pour créer le tableau :
                - première ligne c'est
                - une case vide, puis 10 cases-titre "lettre"-->

                <div class="columns is-gapless is-mobile bs-cases">
                    <div class="column bs-case">
                    <div class="bs-case__none"></div>
                    </div>

                    <!-- générer les 10 cases lettre : -->
                    <?php for ($code=65; $code < (65 + $boardWidth); $code++) : ?>
                <div class="column bs-case">
                <div class="bs-case__title"><?= chr($code) ?></div>
                </div>
                <?php endfor; ?>

                </div>

                <!-- - les 10 lignes suivantes
                - la première case qui contient le numéro de la ligne
                - puis 10 cases vides -->
                <?php for ($row=1; $row <= $boardHeight; $row++) : ?>
                    <div class="columns is-gapless is-mobile bs-cases">

                        <div class="column bs-case">
                            <div class="bs-case__title"><?= $row ?></div>
                        </div>

                        <?php for ($col=1; $col <= $boardWidth; $col++) : ?>
                            <div class="column bs-case">
                                <div id="<?= $col ?>-<?= $row ?>"></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endfor; ?>

            </div>
        </div>
    </div>
</section>


<footer class="footer">
    <div class="container">
        <div class="content has-text-centered">
            <p>
                <strong>BattleShip</strong> by <a href="http://oclock.io">Galaxy</a>. Just have fun !
            </p>
        </div>
    </div>
</footer>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="<?= $basePath ?>/public/js/app.js" charset="utf-8"></script>
</body>
