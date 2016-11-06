<div class="row">
    <div class="col-sm-9">
        <h2>Вопросы</h2>
        <? if (empty($questions) === false):?>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Пользователь</th>
                <th>Вопрос</th>
                <th>Дата</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($questions as $key => $question):?>
                <?php
                if (empty($question->messages)) continue;
                ?>
                <tr>
                    <td>
                        <?= $key + 1?>
                    </td>
                    <td>
                        <?= $question->user->username?>
                    </td>
                    <td>
                        <?= $question->messages[0]->message;?>
                    </td>
                    <td>
                        <?= $question->date;?>
                    </td>
                    <td>
                        <a href="<?= Yii::app()->params['baseUrl'] . '/admin/messageList/' . $question->id?>" >Развернуть переписку</a>
                        <br />
                        <a href="<?= Yii::app()->params['baseUrl'] . '/admin/messageList/' . $question->id?>?active=false" >Закрыть</a>
                    </td>
                </tr>
            <? endforeach;?>
            </tbody>
        </table>
        <? endif;?>
        <? $this->widget('CLinkPager', array(
                'pages' => $pages,
                'selectedPageCssClass' => 'active',
                'header' => '',
                'htmlOptions' => array(
                    'class' => 'pagination'
                )
            ))?>
    </div>
</div>
