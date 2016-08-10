<link href="<?=$this->getModuleUrl('static/css/layouts.css') ?>" rel="stylesheet">
<link href="<?=$this->getStaticUrl('js/star-rating/css/star-rating.css') ?>" rel="stylesheet">

<legend><?=$this->getTrans('menuLayout').' '.$this->getTrans('info') ?></legend>
<?php
$json = url_get_contents('http://ilch2.de/downloads/layouts/list.php');
$datas = json_decode($json);

if (empty($datas)) {
    echo $this->getTrans('noLayoutsAvailable');
    return;
}

foreach ($datas as $data): ?>
    <?php if ($data->id == $this->getRequest()->getParam('id')): ?>
        <div id="layout">
            <div class="col-lg-2">
                <div class="col-lg-12">
                    <div class="thumbnail">
                        <span data-toggle="modal" data-target="#infoModal">
                            <img src="<?=$data->thumb ?>" alt="<?=$this->escape($data->name) ?>" title="<?=$this->escape($data->name) ?>" />
                        </span>
                    </div>
                </div>
                <div class="col-lg-12 text-center">
                    <?php
                    $filename = basename($data->downloadLink);
                    $filename = strstr($filename,'.',true);
                    if (in_array($filename, $this->get('layouts'))): ?>
                        <span class="btn btn-default disabled" title="<?=$this->getTrans('layoutAvailable') ?>">
                            <i class="fa fa-check fa-lg text-success"></i> <?=$this->getTrans('layoutAvailable') ?>
                        </span>
                    <?php else: ?>
                        <form method="POST" action="<?=$this->getUrl(['module' => 'admin', 'controller' => 'layouts', 'action' => 'search']) ?>">
                            <?=$this->getTokenField() ?>
                            <button type="submit"
                                    class="btn btn-default"
                                    name="url"
                                    value="<?=$data->downloadLink ?>"
                                    title="<?=$this->getTrans('download') ?>">
                                <i class="fa fa-download fa-lg"></i> <?=$this->getTrans('download') ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="row">
                    <div class="col-lg-2 col-sm-3 col-xs-6">
                        <b><?=$this->getTrans('name') ?>:</b>
                    </div>
                    <div class="col-lg-10 col-sm-9 col-xs-6">
                        <?=$this->escape($data->name) ?>
                    </div>
                    <div class="col-lg-2 col-sm-3 col-xs-6">
                        <b><?=$this->getTrans('version') ?>:</b>
                    </div>
                    <div class="col-lg-10 col-sm-9 col-xs-6">
                        <?=$data->version ?>
                    </div>
                    <div class="col-lg-2 col-sm-3 col-xs-6">
                        <b><?=$this->getTrans('author') ?>:</b>
                    </div>
                    <div class="col-lg-10 col-sm-9 col-xs-6">
                        <?php if (!empty($data->link)): ?>
                            <a href="<?=$data->link ?>" alt="<?=$this->escape($data->author) ?>" title="<?=$this->escape($data->author) ?>" target="_blank">
                                <i><?=$this->escape($data->author) ?></i>
                            </a>
                        <?php else: ?>
                            <i><?=$this->escape($data->author) ?></i>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-2 col-sm-3 col-xs-6">
                        <b><?=$this->getTrans('hits') ?>:</b>
                    </div>
                    <div class="col-lg-10 col-sm-9 col-xs-6">
                        <?=$data->hits ?>
                    </div>
                    <div class="col-lg-2 col-sm-3 col-xs-6">
                        <b><?=$this->getTrans('downloads') ?>:</b>
                    </div>
                    <div class="col-lg-10 col-sm-9 col-xs-6">
                        <?=$data->downs ?>
                    </div>
                    <div class="col-lg-2 col-sm-3 col-xs-6">
                        <b><?=$this->getTrans('rating') ?>:</b>
                    </div>
                    <div class="col-lg-10 col-sm-9 col-xs-6">
                        <span title="<?=$data->rating ?> <?php if ($data->rating == 1) { echo $this->getTrans('star'); } else { echo $this->getTrans('stars'); } ?>">
                            <input type="number"
                                   class="rating"
                                   value="<?=$data->rating ?>"
                                   data-size="xs"
                                   data-readonly="true"
                                   data-show-clear="false"
                                   data-show-caption="false">
                        </span>
                    </div>
                </div>
                <br />
                <div class="col-lg-12">
                    <b><?=$this->getTrans('desc') ?>:</b>
                </div>
                <div class="col-lg-12">
                    <?=$this->escape($data->desc) ?>
                </div>
            </div>
        </div>

        <?=$this->getDialog('infoModal', $this->escape($data->name), '<center><img src="'.$data->thumb.'" alt="'.$this->escape($data->name).'" /></center>'); ?>
    <?php endif; ?>
<?php endforeach; ?>

<script src="<?=$this->getStaticUrl('js/star-rating/js/star-rating.js') ?>" type="text/javascript"></script>