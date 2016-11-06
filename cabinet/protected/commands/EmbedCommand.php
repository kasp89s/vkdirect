<?php
/**
 * Выполняет импорт и обработку файлов.
 */
//include_once __DIR__ . '/../components/EmbedUploader.php';
class EmbedCommand extends CConsoleCommand {

    public function actionXvideos($category = false)
    {
        new EmbedUploader(new XvideosAdapter(), $category);
    }

    public function actionXhamster($category = false)
    {
        new EmbedUploader(new XhamsterAdapter(), $category);
    }

    public function actionVidearn($category = false)
    {
        new EmbedUploader(new VidearnAdapter(), $category);
    }

    public function actionHub($category = false)
    {
        new EmbedUploader(new HubAdapter(), $category);
    }

    public function actionTube($category = false)
    {
        new EmbedUploader(new Tube8Adapter(), $category);
    }

    public function actionUpdateCategoryList()
    {
        ini_set("memory_limit","512M");

        $sql = "SELECT `category`.*, COUNT(DISTINCT `video`.`id`) as videoCount, `video`.`source`, `images`.`url` from `category`
                   LEFT OUTER JOIN `video_category` ON `category`.`id` = `video_category`.`categoryId`
                   LEFT OUTER JOIN `video` ON `video_category`.`videoId` = `video`.`id`
                   LEFT OUTER JOIN `images` ON `images`.`videoId` = `video`.`id`
                GROUP BY `category`.`id`
                HAVING `videoCount` > 0
                ORDER BY `category`.`name` ASC
        ";

        $categories = \Yii::app()->db->createCommand($sql)->query()->readAll();

        foreach ($categories as $category) {
            $update = Category::model()->find('id = :categoryId', array(':categoryId' => $category['id']));
            $update->image = $category['url'];
            $update->source = $category['source'];
            $update->videoCount = $category['videoCount'];
            $update->save();
        }
    }
}
