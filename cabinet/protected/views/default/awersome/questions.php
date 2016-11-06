<div class="row">
    <div class="col-sm-8">
        <h2>Мои вопросы</h2>

        <table class="table table-first-column-number">
            <thead>
            <tr>
                <th>#</th>
                <th>Дата</th>
                <th>Вопрос</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($questions as $key => $question):?>
                <tr>
                    <td>
                        <?= $key + 1?>
                    </td>
                    <td>
                        <?= $question->date;?>
                    </td>
                    <td>
                        <?= (isset($question->messages[0])) ? $question->messages[0]->message : 'сообщение не найдено';?>
                    </td>
                    <td>
                        <a href="<?= Yii::app()->params['baseUrl'] . '/messageList/' . $question->id?>" >Развернуть переписку</a>
                    </td>
                </tr>
            <? endforeach;?>
            </tbody>
        </table>
        <form class="form" role="form" method='POST' action=''>
        <div class="form-group">
            <label for="message">Ваш вопрос</label>
            <textarea name="message" class="form-control col-md-12" rows="8" name="message"></textarea>
        </div>
        <input type="submit" value="Опубликовать" class="btn btn-primary" style="display: block;">
        </form>
    </div>

</div>
