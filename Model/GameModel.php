<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class GameModel extends Database
{
    public function getGames($limit)
    {
        return $this->select("SELECT * FROM games  ORDER BY GameId
        LIMIT ?;", ["i", $limit]);
    }

    public function getOneGame($id) {
        return $this->select("SELECT * FROM games 
        WHERE GameId = ?;", ["i", $id]);
    }

    public function postGame($Title, $Overview) {
        $this->insert("INSERT INTO games (Title, Overview) VALUES (?,?)",["ss", $Title, $Overview]);
        $gameId = $this->GetMaxId();
        $scoreId = $this->getLastScoreId();
        $userCount = $this->getUserId();
        for ($i = 1; $i <= count($userCount); $i++) {
            $this->insert("INSERT INTO scores (WinNumber, LooseNumber, EqualityNumber, UserId) VALUES (?,?,?,?)",["iiii", 0,0,0, $i]);
            $this->insert("INSERT INTO scoregame (ScoreId, GameId) VALUES (?,?)",["ii", $this->getLastScoreId(), $gameId]);
            $scoreId++;
        }
        return ;
    }

    public function GetMaxId() {

        $selectGameId = "SELECT MAX(GameId) AS GameId FROM games";
        $resultQueryGame = $this -> connection -> query($selectGameId);
        $gameId = 0;
        while($row = mysqli_fetch_array($resultQueryGame)) {
            $gameId = $row['GameId'];
        }
        return $gameId;
    }

    private function getLastScoreId() {
        $selectScoreId = 'SELECT MAX(ScoreId) as ScoreId FROM scores';
        $resultQueryScore = $this -> connection -> query($selectScoreId);
        $resultId = array();
            while($row = mysqli_fetch_array($resultQueryScore)) {
                return $row['ScoreId'];
            }
        if ($resultId == []) {
            return false;
        } else {
            return $resultId;
        }
        
    }

    private function getUserId() {
        $selectUserId = "SELECT UserId FROM users GROUP BY UserId";
        $resultQueryUser = $this -> connection -> query($selectUserId);
        $userId = array();
        while($row = mysqli_fetch_array($resultQueryUser)) {
            array_push($userId,$row['UserId']);
        }

        return $userId;
    }

    
}

?>