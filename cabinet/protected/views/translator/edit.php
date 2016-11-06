<? if (empty($video) === false):?>
<div class="row-fluid marketing">
    <form action="" method="post">
        <fieldset>
            <label><?= $video->title?></label>
            <input type="hidden" name="referer" value="<?= $_SERVER['HTTP_REFERER']?>">
            <input class="input-xxlarge" type="text" name="title" value="<?= $video->title?>"/>
            <label><?= $video->description?></label>
            <textarea name="description" rows="5" style="width: 530px;"><?= $video->description?></textarea>
            <br />
            <button type="submit" class="btn">Save</button>
            <a href="<?= $_SERVER['HTTP_REFERER']?>">Назад</a>
        </fieldset>
    </form>
</div>
<? endif;?>
