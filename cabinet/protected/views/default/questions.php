<div class="main_content">
    <? if (empty($questions) === false):?>
        <h3>Мои вопросы:</h3>
        <div class="panel panel-default">
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Дата</th>
                    <th>Вопрос</th>
                </tr>
                <? foreach ($questions as $key => $question):?>
                    <tr>
                        <td>
                            <?= $key + 1?>
                        </td>
                        <td>
                            <?= $question->date;?>
                        </td>
                        <td>
                            <?= $question->messages[0]->message;?>
                        </td>
                        <td>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/messageList/' . $question->id?>" >Развернуть переписку</a>
                        </td>
                    </tr>
                <? endforeach;?>
            </table>
        </div>
    <? endif;?>
    <form class="form" role="form" method='POST' action=''>
        <div class="form-group">
            <textarea name="message" style="width: 100%; height: 100px;"></textarea>
            <div class="input-group">
                <input class="btn" type="submit" value="Новый вопрос">
            </div>
        </div>
    </form>
</div>
