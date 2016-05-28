<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile/record_article.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/record_article.js"></script>
<section class="record_artical_container">
    <div class="article">
            <div class="article_title">
                    <h2 class="title"><?php echo $model->event_title; ?></h2>
                    <div class="article_meta clearfix" >
                            <div>
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon_03.jpg" alt="" class='article_meta_icon'><span>作者: <em><?php echo $model->event_author; ?></em></span>
                            </div>
                            <div>
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon_07.jpg" alt="" class='article_meta_icon'><span><?php echo $model->create_time; ?></span>
                            </div>
                    </div>
            </div>
            <div class="article_content">
                <?php echo $model->contdata; ?>
            </div><!--article_content-->
    </div><!--article结束-->
</section>
<section class="aside">
    <?php if(!empty($advertise_arrs)){ ?>
        <a target="_blank" href="<?php echo $advertise_arrs[0]['target_url']; ?>" class="aside_top_ac">
            <img src="<?php echo Yii::app()->request->baseUrl.'/'.$advertise_arrs[0]['logo']; ?>" alt="" title="" />
        </a>
    <?php }else{ ?>
        <a  target="_blank" href="<?php echo Yii::app()->request->baseUrl; ?>" class="aside_top_ac">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/detail_img_07.jpg" alt="" title="" />
        </a>
    <?php } ?>
</section>