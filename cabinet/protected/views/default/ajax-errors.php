<? if (empty($errors) === false) :?>
    <div class="alert alert-warning" role="alert">
        <? foreach ($errors as $key => $error):?>
            <?= $error?> <br />
        <? endforeach;?>
    </div>
<? endif;?>
