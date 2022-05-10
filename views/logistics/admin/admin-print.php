<head>
    <link href="http://logistics.loc/assets/31aae90c/css/bootstrap.css" rel="stylesheet">
</head>
<div class="container">
    <div style="page-break-after: always;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td colspan="2">Список доставки</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 50%;">
                        <address>
                            <strong>Логистическая компания <?= $_SERVER['HTTP_HOST'] ?></strong><br>
                            г. Москва, ул. Ленина 10 оф. 32
                        </address>
                        <b>Телефон</b> 495 888-88-88<br>
                        <b>E-Mail</b> forum@mail-opencart-russia.ru<br>
                        <b>Сайт</b> <a href="/"><?= $_SERVER['HTTP_HOST'] ?></a>
                    </td>
                    <td style="width: 50%;">
                        <b>Дата добавления</b> <?= $datePrint ?><br>
                        <b>Способ оплаты</b> Оплата при доставке<br>
                        <b>Способ доставки</b> Доставка с фиксированной стоимостью доставки<br>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td style="width: 50%;"><b>Адрес плательщика</b></td>
                    <td style="width: 50%;"><b>Контакты</b></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <address>
                            <?= $address->name ?> <?= $address->surname ?><br><?= $address->surname ?><br><?= $address->city ?> <?= $address->postcode ?><br><?= $address->region ?> <br><? if ($address->contry == 0) : ?>
                                Россия
                            <? endif; ?>
                            <? if ($address->contry == 1) : ?>
                                Казахстан
                            <? endif; ?>
                        </address>
                    </td>
                    <td>
                        <?= $user->email ?><br><?= $address->phone ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td><b>Расположение</b></td>
                    <td><b>Ссылка</b></td>
                    <td><b>Товар</b></td>
                    <td><b>Вес товара</b></td>
                    <td><b>Трекер</b></td>
                    <td class="text-right"><b>Количество</b></td>
                </tr>
            </thead>
            <tbody>
                <? if ($model) : ?>
                    <? foreach ($model as $value) : ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><?= $value->nameItem ?></td>
                            <td>10.00кг</td>
                            <td><?= $value->tracker ?></td>
                            <td class="text-right"><?= $value->quantity ?></td>
                        </tr>
                    <? endforeach; ?>
                <? else : ?>
                    <td>пусто!</td>
                <? endif; ?>

            </tbody>
        </table>
    </div>
</div>