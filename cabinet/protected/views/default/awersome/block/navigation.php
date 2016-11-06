    <div id="sidebar-nav" class="hidden-xs">
        
        <ul id="dashboard-menu" class="nav nav-list">
            <? foreach ($this->menu as $link => $item):?>
				<li class="<?= $item['class']?>"><a rel="tooltip" data-placement="right" data-original-title="<?= $item['title']?>" href="<?= Yii::app()->params['baseUrl']?><?= $link?>"><i class="<?= $item['icon']?>"></i> <span class="caption"><?= $item['title']?></span></a></li>
			<? endforeach; ?>
         </ul>
    </div>