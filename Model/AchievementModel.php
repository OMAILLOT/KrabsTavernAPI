<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class AchievementModel extends Database
{
    public function getAchievements($limit)
    {
        return $this->select("SELECT * FROM achievements  ORDER BY AchievementId
        LIMIT ?;", ["i", $limit]);
    }

    public function getOneAchievement($id) {
        return $this->select("SELECT * FROM achievements
        WHERE AchievementId = ?;", ["i", $id]);
    }

    public function postAchievement($GameId, $Title, $Overview) {
        return $this->insert("INSERT INTO achievements (GameId, Title, Overview) VALUES (?,?,?)",["iss",$GameId, $Title, $Overview]);
    }

    public function getAGameTitle($id){
        return $this->select("SELECT Title FROM games
        WHERE GameId = ?;", ["i", $id]); 
    }
}

?>