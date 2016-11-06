<div class="row">
    <div class="col-sm-9">
        <h2>Обмен валют на i.ua</h2>
		<form class="" method="post">
                <div class="form-group">
                    <!-- Text input-->
                    <label class="control-label" for="input01">Логин</label>
                    <div class="controls">
                        <input type="text" class="form-control" name="login" value="<?= $trade['login']?>">
                    </div>
                </div>
                <div class="form-group">
                    <!-- Text input-->
                    <label class="control-label" for="input01">Пароль</label>
                    <div class="controls">
                        <input type="text" class="form-control" name="password" value="<?= $trade['password']?>">
                    </div>
                </div>
				<br />
				<br />
				<br />
		<div class="pricing non-spaced four hidden-xs">
            <div class="product">
                <h2 class="text-info">Покупка</h2>
                <ul>
                    <li>
						<span class="label label-default"><?= $statistic->buy->recommend?></span><br>
						<?= $statistic->buy->min[0] . ' <span class="badge badge-success">' . $statistic->buy->min[1] . '</span> ' . $statistic->buy->min[2] . ' ' . $statistic->buy->min[3] . ' ' . $statistic->buy->min[4] . ' ' . $statistic->buy->min[5]?>
						<br>
						<?= $statistic->buy->max[0] . ' <span class="badge badge-important">' . $statistic->buy->max[1] . '</span> ' . $statistic->buy->max[2] . ' ' . $statistic->buy->max[3] . ' ' . $statistic->buy->max[4] . ' ' . $statistic->buy->max[5]?>
					</li>
					<? foreach($statistic->buy->list as $item):?>
						<li><?= $item[2] . ' => ' . $item[1]?></li>
					<? endforeach;?>
                </ul>          
            </div>
            <div class="product">
                <h2 class="text-info">Продажа</h2>
                <ul>
                    <li >
						<span class="label label-default"><?= $statistic->sell->recommend?></span><br>
						<?= $statistic->sell->min[0] . ' <span class="badge badge-success">' . $statistic->sell->min[1] . '</span> ' . $statistic->sell->min[2] . ' ' . $statistic->sell->min[3] . ' ' . $statistic->sell->min[4] . ' ' . $statistic->sell->min[5]?><br>
						<?= $statistic->sell->max[0] . ' <span class="badge badge-important">' . $statistic->sell->max[1] . '</span> ' . $statistic->sell->max[2] . ' ' . $statistic->sell->max[3] . ' ' . $statistic->sell->max[4] . ' ' . $statistic->sell->max[5]?>
					</li>
					<? foreach($statistic->sell->list as $item):?>
						<li><?= $item[2] . ' => ' . $item[1]?></li>
					<? endforeach;?>
                </ul>          
            </div>
			<div class="product popular" style="width: 400px;">
                <h2 class="text-info">На торгах</h2>
                <ul>
                    <li>
						<span class="label label-info">Покупка</span> <br />
						<table>
							<tr>
								<td><input type="text" name="buyAmount" class="form-control" value="<?= $trade['buyAmount']?>"></td>
								<td>курс</td>
								<td><input type="text" name="buyPrice" class="form-control" value="<?= $trade['buyPrice']?>"></td>
							</tr>
						</table>
					</li>
                    <li>
						<span class="label label-info">Продажа</span><br />
						<table>
							<tr>
								<td><input type="text" name="sellAmount" class="form-control" value="<?= $trade['sellAmount']?>"></td>
								<td>курс</td>
								<td><input type="text" name="sellPrice" class="form-control" value="<?= $trade['sellPrice']?>"></td>
							</tr>
						</table>
					</li>
                    <li>
						<span class="label label-info">Район</span><br />
						<input type="text" name="district" class="form-control" value="<?= $trade['district']?>">
					</li>
                    <li>
						<span class="label label-info">Комментарий</span><br />
						<input type="text" name="comment" class="form-control" value="<?= $trade['comment']?>">
					</li>
                    <li>
						<span class="label label-info">Обновлять c</span><br />
						<input type="text" name="start" class="form-control" value="<?= $trade['start']?>">
					</li>
                    <li>
						<span class="label label-info">Обновлять до</span><br />
						<input type="text" name="live" class="form-control" value="<?= $trade['live']?>">
					</li>
                </ul>          
                <p class="call-to-action">
				<button class="btn btn-success" type="submit">
				<i class="icon-ok"></i> Сохранить
				</button>
				</p>
            </div>
            <div style="clear: both;"></div>
        </div>
		</form>
	</div>
</div>