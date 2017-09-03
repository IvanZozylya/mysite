<?php
if (isset($_POST['armagedon']) && $_POST['armagedon'] == "Ok") {
    date_default_timezone_set('Europe/Kiev');
    $d = date("Y-m-d H:i:s");
    $date = '\'' . $d . '\'';
//Обновление пользователей на оффлайн каждые 15мин парам = date
    function UserAllOfflineDate($date)
    {
        $mysqli = new mysqli("localhost", "root", "", "diplom");
        $mysqli->set_charset("utf8");
        $result_set = $mysqli->query("UPDATE user SET `date` = {$date} WHERE `online`=1");
        $mysqli->close();


    }

//Обновление пользователей на оффлайн каждые 15мин парам = online
    function UserAllOfflineOnline0()
    {
        $mysqli = new mysqli("localhost", "root", "", "diplom");
        $mysqli->set_charset("utf8");
        $result_set = $mysqli->query("UPDATE user SET `online` = 0");
        $mysqli->close();
    }

    $userDate = UserAllOfflineDate($date);
    $userOffline = UserAllOfflineOnline0();
    echo "true";
    return true;
}else{
    return false;
}