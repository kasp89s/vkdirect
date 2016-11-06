<style>
    .table td {
        border: none;
    }
</style>
<div class="row">
    <div class="col-sm-9">
        <h2>Добавить новый сайт</h2>
        <div class="error-area">
            <? if (empty($errors) === false) :?>
                <div class="alert alert-warning" role="alert">
                    <? var_dump($errors)?>
                </div>
            <? endif;?>
        </div>
        <form role="form" action="" method="post" style="margin: 5px;" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Адресс сайта</label>
                <input type="text" class="form-control" id="url" name="url" placeholder="http://"/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Добавить" />
            </div>
        </form>
    </div>
</div>
