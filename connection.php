<?php

class DB
{
    const HOSTNAME = "localhost";
    const DB_NAME = "taskmanagementdb";
    const USERNAME = "root";
    const PASSWORD = "";

    public function connect()
    {
        $connect = mysqli_connect(self::HOSTNAME, self::USERNAME, self::PASSWORD, self::DB_NAME);

        mysqli_set_charset($connect, "utf8");

        if(mysqli_connect_errno() === 0){
            return $connect;
        }
        return false;
    }
}
?>

