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
    <?= Html::csrfMetaTags() ?>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
<?php $this->head()?>
</head>
<body<?=isset($params['fixed']) ? ' class="fix"':''?>>
<?php $this->beginBody()?>
<div class="header">
    <div class="header-inner clearfix">
        <img src="/images/dish.png" alt="Logo" class="fl logo">
        <span class="fl title"><?= $app_name?></span>
        <?php if($params['hasCount']) { ?>
            <div class="countdown fr" data-diff="<?=$params['countdown']?>"></div>
        <?php }?>
    </div>
</div>
<?= $content?>
<?php $this->endBody()?>
<?php if(isset($params['script'])): ?>
    <script src="//apps.bdimg.com/libs/jquery/1.10.1/jquery.min.js"></script>
    <?php if($params['hasCount']): ?>
    <script src="/js/jquery.countdown.js"></script>
    <script src="//apps.bdimg.com/libs/underscore.js/1.6.0/underscore-min.js"></script>
    <?php endif;?>
    <script src="/js/<?=$params['script']?>.js"></script>
<?php endif;?>
</body>
</html>
<?php $this->endPage() ?>
