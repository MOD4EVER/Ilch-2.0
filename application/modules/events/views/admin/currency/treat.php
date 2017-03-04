<legend>
    <?php if ($this->getRequest()->getParam("id")) {
        echo $this->getTrans('edit');
    } else {
        echo $this->getTrans('add');
    }
    ?>
</legend>
<form class="form-horizontal" method="POST" action="">
    <?=$this->getTokenField() ?>
    <div class="form-group <?=$this->validation()->hasError('name') ? 'has-error' : '' ?>">
        <div class="col-lg-4">
            <input type="text"
                   class="form-control"
                   id="name"
                   name="name"
                   placeholder="<?=$this->getTrans('name') ?>"
                   value="<?=($this->get('currency') != '') ? $this->escape($this->get('currency')->getName()) : $this->originalInput('name') ?>" />
        </div>
    </div>
    <?=$this->getSaveBar() ?>
</form>
