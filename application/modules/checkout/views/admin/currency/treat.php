<?php $currency = $this->get('currency'); ?>

<legend>
    <?php if ($this->getRequest()->getParam("id") == 0) {
        echo $this->getTrans('edit');
    } else {
        echo $this->getTrans('add');
    }
    ?>
</legend>
<form class="form-horizontal" method="POST" action="<?=$this->getUrl(['action' => $this->getRequest()->getActionName()]) ?>">
    <?=$this->getTokenField() ?>
    <div class="form-group">
        <div class="col-lg-4">
            <input type="text"
                   class="form-control"
                   id="name"
                   name="name"
                   placeholder="<?=$this->getTrans('name') ?>"
                   value="<?=$this->escape($currency->getName()) ?>" />
        </div>
    </div>
    <div class="form-group hidden">
        <div class="col-lg-4">
            <input type="text"
                   class="form-control"
                   id="id"
                   name="id"
                   value="<?=$this->escape($currency->getId()) ?>" />
        </div>
    </div>
    <?=$this->getSaveBar() ?>
</form>