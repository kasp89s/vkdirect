<div class="row">
	<div class="col-sm-9">
        <? if($this->user->balance < 1):?>
        <div class="alert fade in">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Внимание!</strong> На Вашем счету мало средств, <a href="<?= Yii::app()->params['baseUrl'] . '/balance'?>">пополните</a> пожалуйста Вас счёт, что бы избедать приостановки услуг.
        </div>
        <? endif;?>
        <div id="content-header">
            <h2>Список сайтов</h2>
        </div>
        <a style="float: left; display: block; margin: 15px; margin-left: 0px;" href="<?= Yii::app()->params['baseUrl'] . '/default/addSite'?>" class="btn btn-success">Подключить сайт</a>
        <br />
        <br />
        <br />
	<? if(empty($products) === false):?>
	<table class="table table-first-column-number">
	       <thead>
                    <tr>
                        <th>Сайт</th>
                        <th width="55px">Статус</th>
                        <th>Редактирование</th>
                    </tr>
          </thead>
          <tbody>
              <? foreach ($products as $product):?>
                  <tr>
                      <td><?= $product->url?></td>
                      <td>
                          <?= ($product->active == 1) ? '<span class="label label-success">Активен</span>' : '<span class="label label-important">Не активен</span>';?>
                      </td>
                      <td>
                          <? if ($product->active == 0):?>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/default/editSite/' . $product->id?>" class="btn btn-primary btn-xs">Активировать</a>
                          <? endif;?>
                          <a href="<?= Yii::app()->params['baseUrl'] . '/default/deleteSite/' . $product->id?>" class="btn btn-danger btn-xs" onclick="return confirm('Удалить?');">Удалить</a>
                      </td>
                  </tr>
              <? endforeach;?>
        </tbody>
    </table>
        <? $this->widget('CLinkPager', array(
                'pages' => $pages,
                'selectedPageCssClass' => 'active',
                'header' => '',
                'htmlOptions' => array(
                    'class' => 'pagination'
                )
            ))?>
		<? endif;?>
    </div>
    </div>
