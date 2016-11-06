<div class="row">
    <div class="col-sm-6">
    <br />
    <br />
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">Ссылка для приглашения</span>
            <input type="text" class="form-control" value="http://vkdirect.ru/cabinet/registration?ref=<?= $this->user->referralCode?>" readonly>
        </div>
    </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <h2>Мои рефералы</h2>
        <? if (empty($referrals) === false):?>
        <table class="table table-first-column-number">
            <thead>
            <tr>
                <th>#</th>
                <th>Логин</th>
            </tr>
            </thead>
            <tbody>
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
            <tbody>
        </table>
        <? endif;?>
    </div>
</div>
