<?php
use yii\helpers\Html;
$this->beginPage();
$app_name = Yii::$app->name;
$this->title = $this->title . ' - ' . $app_name;
$params = Yii::$app->params;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= Html::encode($this->title)?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
<?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>
<div class="header">
    <div class="header-inner clearfix">
        <img src="/images/dish.png" alt="Logo" class="fl logo">
        <span class="fl title"><?= $app_name?></span>
        <?php if($params['hasCount']): ?>
            <div class="countdown fr" data-diff="2400"></div>
        <?php endif;?>
    </div>
</div>
<?= $content?>
<?php $this->endBody()?>
<script src="/js/jquery.min.js"></script>
<?php if($params['hasCount']): ?>
<script src="/js/jquery.countdown.js"></script>
<?php endif;?>
<script src="/js/entry.js"></script>
</body>
</html>
<?php $this->endPage() ?>
