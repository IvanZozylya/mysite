<?php


class News
{
    const SHOW_BY_DEFAULT = 5;

    //вывод одной новости
    public static function getShowItemNews($id)
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT * FROM news WHERE id = " . $id);
        return $row = $result->fetch(PDO::FETCH_ASSOC);
    }

    //получаем количество записей новостей по id
    public static function getCountNewsId()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM news ');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //вывод всех новостей
    public static function getNews($page = 1)
    {

        $page = intval($page);
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = Db::getConnection();
        $news = array();
        $result = $db->query("SELECT `id`, `title`,`date`,`image` FROM news "
            . "ORDER BY date DESC "
            . "LIMIT " . self::SHOW_BY_DEFAULT
            . ' OFFSET ' . $offset);

        $i = 0;
        //если запрос пустой ,делаем переадресацию на /news
        if(!$result){
            header("Location: /news");
            exit();
        }
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $news[$i]['id'] = $row['id'];
            $news[$i]['title'] = $row['title'];
            $news[$i]['date'] = $row['date'];
            $news[$i]['image'] = $row['image'];
            $i++;
        }

        return $news;
    }

    //Добавление новости
    public static function addNews($title, $date, $content, $image)
    {

        $db = Db::getConnection();
        $sql = "INSERT INTO news (`title`,`date`, `content`, `image`)
                  VALUES (:title,:date,:content,:image)";

        $result = $db->prepare($sql);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':content', $content, PDO::PARAM_STR);
        $result->bindParam(':image', $image, PDO::PARAM_STR);
        $result->execute();


    }

    //Редактирование новости
    public static function editNews($title, $date, $content, $image,$id)
    {

        $db = Db::getConnection();
        $sql = "UPDATE news SET`title`=:title,`date`=:date, `content`=:content, `image`=:image
                WHERE id=:id";

        $result = $db->prepare($sql);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':content', $content, PDO::PARAM_STR);
        $result->bindParam(':image', $image, PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();


    }

    //Удаление новости
    public static function deleteNews($id)
    {
        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM news WHERE id =".$id);
        return true;
    }

    //Вывод последней новости
    public static function getNewsItemLast()
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT `id`,`image` FROM `news` ORDER BY id DESC LIMIT 1");
        return $row = $result->fetch(PDO::FETCH_ASSOC);
    }

    //Обновить путь image нужной новости
    public static function editPathImage($id,$image)
    {
        $id = intval($id);


        $db = Db::getConnection();
        $result = $db->query("UPDATE news SET `image`={$image} WHERE id=".$id);
        if($result){
            return true;
        }else{
            return false;
        }
    }


}