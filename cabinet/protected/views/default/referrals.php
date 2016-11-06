<div class="main_content">
        <p<lable>Ссылка:</lable> <input type="text" class="form-control" value="http://redirekt.center/cabinet/registration?ref=<?= $this->user->referralCode?>" readonly></p>
		<? if (empty($referrals) === false):?>
		<h3>Мои рефералы:</h3>
		<div class="panel panel-default">
		<table class="table">
			<tr>
			<th>#</th>
			<th>Логин</th>
			</tr>
			<? foreach ($referrals as $key => $user):?>
			<tr>
				<td>
					<?= $key + 1?>
				</td>
				<td>
					<?= $user->username?>
				</td>
			</tr>
			<? endforeach;?>
		</table>
		</div>
		<? endif;?>
</div>