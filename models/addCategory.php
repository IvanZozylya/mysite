<?php

class addCategory
{
    //Добавление категории на рассмотрение админу
    public static function addCategoryFor($title, $date, $short_content, $image)
    {
        $db = Db::getConnection();
        $sql = "INSERT INTO addcategory (`title`,`date`, `short_content`, `image`)
                  VALUES (:title,:date,:short_content,:image)";

        $result = $db->prepare($sql);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':short_content', $short_content, PDO::PARAM_STR);
        $result->bindParam(':image', $image, PDO::PARAM_STR);
        $result->execute();
    }

    //Получить Количество категории
    public static function getCountAddCategory()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM addcategory');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //Получить все категории
    public static function getCategoryList()
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT * FROM addcategory");
        $i = 0;
        $categoryList = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['title'] = $row['title'];
            $categoryList[$i]['date'] = $row['date'];
            $categoryList[$i]['short_content'] = $row['short_content'];
            $categoryList[$i]['image'] = $row['image'];
            $i++;
        }
        return $categoryList;
    }

    //Удалить все категории
    public static function deleteCategory($id)
    {

        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM addcategory WHERE id=" . $id);
        if($result){
            return true;
        }else{
            return false;
        }
    }

}