<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class UserModel extends Database
{
    public function getUsers($limit)
    {
        return $this->select("SELECT users.UserId, users.Name, users.EmailAddress FROM users 
        LIMIT ?;", ["i", $limit]);
    }

    public function getOneUser($id) {
        return $this->select("SELECT users.UserId, users.Name, users.EmailAddress FROM users 
        WHERE UserId = ?;", ["i", $id]);
    }

    public function postUser($Name,$emailAddress) {
        return $this->insert("INSERT INTO users (users.UserId, users.Name, users.EmailAddress) VALUES (?,?,?)",[$Name,$emailAddress]);
    }
}

?>