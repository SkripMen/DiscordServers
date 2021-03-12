<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">
        <div class="row">
            <? foreach ($arr as $key => $value): ?>
                <div class="col-lg-4">
                    <h2><?= $value[0] ?></h2>

                    <p><?= $value[1] ?></p>

                    <? if ($value[2]) : ?>
                        <img src="<?= $value[2] ?>">
                    <? else : ?>
                        <div style="display: block; width: 128px; height: 128px; background-color: #0b72b8; font-size: xxx-large">
                            <?php
                            $str = '';
                            for ($i = 0; $i < strlen($value[0]); ++$i) {
                                if ($value[0][$i] != strtolower($value[0])[$i]) {
                                    $str .= $value[0][$i];
                                }
                            }
                            echo $str;
                            ?>
                        </div>
                    <? endif; ?>
                    <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a>
                    </p>
                </div>
            <? endforeach; ?>
        </div>

    </div>
</div>
