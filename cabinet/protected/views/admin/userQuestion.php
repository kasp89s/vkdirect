<div class="main_content">
    <? if (empty($questions) === false):?>
        <h3>Вопросы:</h3>
        <div class="panel panel-default">
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Пользователь</th>
                    <th>Вопрос</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
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
            </table>
        </div>
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
