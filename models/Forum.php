<?php


class Forum
{
    const SHOW_BY_DEFAULT = 5;

    //Получить список тем по заданой категории
    public static function getForumList($categoryId, $page = 1)
    {


        $page = intval($page);
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = Db::getConnection();
        $forumList = array();
        $result = $db->query("SELECT * FROM forum "
            . "WHERE `current_category_id` = '$categoryId' "
            . "ORDER BY id DESC "
            . "LIMIT " . self::SHOW_BY_DEFAULT
            . ' OFFSET ' . $offset);

        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $forumList[$i]['id'] = $row['id'];
            $forumList[$i]['title'] = $row['title'];
            $forumList[$i]['date'] = $row['date'];
            $forumList[$i]['current_user_id'] = $row['current_user_id'];
            $forumList[$i]['current_category_id'] = $row['current_category_id'];
            $forumList[$i]['image'] = $row['image'];
            $i++;
        }

        return $forumList;
    }

    //Получить количество записей по заданой категории
    public static function getCountForumList($categoryId)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM forum '
            . 'WHERE  current_category_id ="' . $categoryId . '"');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //Получить title нужной категории
    public static function getTitle($id)
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT `title` FROM forum WHERE id = {$id} 
                                ORDER BY id DESC LIMIT 1");
        if($result){
            $row = $result->fetch();

            return $row['title'];
        }else{
            return false;
        }


    }

    //Получить image нужной категории
    public static function getImage($id)
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT `image` FROM forum WHERE id = " . $id);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['image'];

    }

    //Редактирование темы
    public static function editTemaItem($title, $image, $id)
    {
        $db = Db::getConnection();
        $sql = "UPDATE forum SET`title`=:title,`image`=:image
                WHERE id=:id";

        $result = $db->prepare($sql);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':image', $image, PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
    }

    //Удаление темы по id
    public static function deleteTemaItem($categoryId)
    {
        $categoryId = intval($categoryId);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM forum WHERE id =" . $categoryId);
        return true;
    }

    //Удаление всех тем по current_category_id
    public static function deleteAllTema($id)
    {
        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM forum WHERE current_category_id =" . $id);
        if(!$result){
            return false;
        }
        return true;
    }

    //Добавление темы
    public static function addForumItem($title, $date, $current_user_id, $current_category_id,$image)
    {

        $db = Db::getConnection();
        $sql = "INSERT INTO forum (`title`,`date`, `current_user_id`, `current_category_id`,`image`)
                  VALUES (:title,:date,:current_user_id,:current_category_id,:image)";

        $result = $db->prepare($sql);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':current_user_id', $current_user_id, PDO::PARAM_INT);
        $result->bindParam(':current_category_id', $current_category_id, PDO::PARAM_INT);
        $result->bindParam(':image', $image, PDO::PARAM_STR);
        $result->execute();


    }

    //Вывод одной темы по (id и current_category_id)
    public static function getTemaOne($id,$category)
    {
        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("SELECT * FROM forum WHERE id = $id AND current_category_id = $category");
        return $row = $result->fetch();
    }


}