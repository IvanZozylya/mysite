<?php


class Category
{
    const SHOW_BY_DEFAULT = 5;

    //получаем количество записей категорий по id
    public static function getCountCategoryId()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM category ');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //вывод всех категорий форума
    public static function getCategoryList($page = 1)
    {

        $page = intval($page);
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = Db::getConnection();
        $news = array();
        $result = $db->query("SELECT `id`, `title`,`image` FROM category "
            . "ORDER BY date ASC "
            . "LIMIT " . self::SHOW_BY_DEFAULT
            . ' OFFSET ' . $offset);

        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $news[$i]['id'] = $row['id'];
            $news[$i]['title'] = $row['title'];
            $news[$i]['image'] = $row['image'];
            $i++;
        }

        return $news;
    }

    //Добавление категории
    public static function addCategory($title, $date, $short_content, $image)
    {

        $db = Db::getConnection();
        $sql = "INSERT INTO category (`title`,`date`, `short_content`, `image`)
                  VALUES (:title,:date,:short_content,:image)";

        $result = $db->prepare($sql);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':short_content', $short_content, PDO::PARAM_STR);
        $result->bindParam(':image', $image, PDO::PARAM_STR);
        $result->execute();
        if($result){
            return true;
        }else{
            return false;
        }


    }

    //Вывод одной категории
    public static function getCategoryItem($id)
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT * FROM category WHERE id =" . $id);
        return $row = $result->fetch(PDO::FETCH_ASSOC);

    }

    //Редактирование категории
    public static function editCategoryItem($title, $date, $short_content, $image, $id)
    {
        $db = Db::getConnection();
        $sql = "UPDATE category SET`title`=:title,`date`=:date, `short_content`=:short_content, `image`=:image
                WHERE id=:id";

        $result = $db->prepare($sql);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':short_content', $short_content, PDO::PARAM_STR);
        $result->bindParam(':image', $image, PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
    }

    //Удаление категории
    public static function deleteCategory($id)
    {
        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM category WHERE id=" . $id);
        if(!$result){
            return false;
        }
        return true;
    }

    //Получить image нужной категории
    public static function getImageCategory($id)
    {
        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("SELECT `image` FROM category WHERE id=" . $id);
        if ($result) {
             $row = $result->fetch();
             return $row['image'];
        } else {
            return false;
        }
    }

    //Вывод последней категории
    public static function getCategoryItemLast()
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT `id`,`image` FROM category ORDER BY id DESC LIMIT 1");
        return $row = $result->fetch(PDO::FETCH_ASSOC);
    }

    //Обновить путь image нужной категории
    public static function editPathImage($id,$image)
    {
        $id = intval($id);


        $db = Db::getConnection();
        $result = $db->query("UPDATE category SET `image`={$image} WHERE id=".$id);
        if($result){
            return true;
        }else{
            return false;
        }
    }



}