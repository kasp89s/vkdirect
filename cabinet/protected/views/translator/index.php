<div class="row-fluid marketing">
    <table class="table">
        <thead>
        <tr>
            <th>id</th>
            <th>Title</th>
            <th>Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <? if (empty($videos) === false):?>
        <? foreach ($videos as $video):?>
        <tr>
            <td><?= $video->id?></td>
            <td><?= $video->title?></td>
            <td><?= $video->description?></td>
            <td><a href="<?php echo Yii::app()->params['baseUrl']; ?>/translator/edit/<?= $video->id?>"><i class="icon-edit"></i></a></td>
        </tr>
            <? endforeach;?>
        <? endif;?>
        </tbody>
    </table>
    <div class="pagination">
        <? $this->widget('CLinkPager', array(
                'pages' => $pages,
                'selectedPageCssClass' => 'active',
                'htmlOptions' => array(
                    'class' => ''
                )
            ))?>
    </div>
</div>
