<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class UserAchievementModel extends Database
{

    public function getUserAchievements($limit)
    {
        return $this->select("SELECT * FROM userachievement ORDER BY AchievementId
        LIMIT ?;", ["i", $limit]);  
    }

    public function postUserAchievement($userId, $AchievementId, $date) {
        return $this->insert("INSERT INTO userAchievement (UserId, AchievementId, Date) VALUES (?,?,?)",["iis",$userId, $AchievementId,$date]);
    }
}