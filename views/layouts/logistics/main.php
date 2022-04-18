<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
$this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ml-auto'],
            'items' => [
                ['label' => 'Мои посылки', 'url' => ['logistics/user/my-tracker']],
                ['label' => 'Добавить трек', 'url' => ['logistics/user/add-tracker-client']],
                '<li class="nav-item dropdown">
                ' . Html::tag(
                    "a",
                    'Настройка',
                    ['class' => 'dropdown-toggle nav-link active', "data-toggle" => "dropdown", "role" => "button"]
                ) . '
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="' . Yii::$app->urlManager->createUrl(['logistics/user/address']) . '">Адрес доставки</a>
                </div>
                </li>',
                Yii::$app->user->isGuest ? (['label' => 'Авторизация', 'url' => ['/logistics/user/signin']]
                ) : ('<li class="nav-item dropdown">' . Html::tag(
                    "a",
                    Yii::$app->user->identity->username,
                    ['class' => 'dropdown-toggle nav-link active', "data-toggle" => "dropdown", "role" => "button"]
                ) .
                    '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        ' . Html::a(
                        "Выход (" . Yii::$app->user->identity->username . ")",
                        ['site/logout'],
                        [
                            'class' => 'dropdown-item',
                            'data-method' => 'POST'
                        ]
                    ) . '
                    </div>
                </li>'
                )
            ],
        ]);
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-left">&copy; My Company <?= date('Y') ?></p>
            <p class="float-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>