<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class ScoreModel extends Database
{
    public function getScores($limit)
    {
        return $this->select("SELECT *, scoregame.GameId FROM scores INNER JOIN scoregame ON scores.ScoreId = scoregame.ScoreId ORDER BY scores.ScoreId
        LIMIT ?;", ["i", $limit]);
    }

    public function getOneScore($id) {
        return $this->select("SELECT * FROM scores 
        WHERE ScoreId = ?;", ["i", $id]);
    }

    public function postScore($gameId, $userId) {
        $scoreId = $this->getLastId();
        $this->insert("INSERT INTO scoregame (ScoreId, GameId) VALUES (?,?)",["ii", $scoreId+1, $gameId]);
        return $this->insert("INSERT INTO scores (WinNumber, LooseNumber, EqualityNumber, UserId) VALUES (?,?,?,?)",["iiii", 0,0,0, $userId]);
    }

    public function UpdateWin($userId, $gameId) {
        return $this->insert("UPDATE scores
                             INNER JOIN scoregame ON scores.ScoreId = scoregame.ScoreId
                             SET WinNumber = WinNumber + 1 
                             WHERE scores.UserId = (?) AND scoregame.GameId = (?)",
                             ["ii", $gameId, $userId]);
    }

    public function UpdateLoose($userId, $gameId) {
        return $this->insert("UPDATE scores
        INNER JOIN scoregame ON scores.ScoreId = scoregame.ScoreId
        SET LooseNumber = LooseNumber + 1 
        WHERE scores.UserId = (?) AND scoregame.GameId = (?)",
        ["ii", $gameId, $userId]);
    }

    public function UpdateEquality($userId, $gameId) {
        return $this->insert("UPDATE scores
        INNER JOIN scoregame ON scores.ScoreId = scoregame.ScoreId
        SET EqualityNumber = EqualityNumber + 1 
        WHERE scores.UserId = (?) AND scoregame.GameId = (?)",
        ["ii", $gameId, $userId]);
    }

    private function getLastId() {
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
}

?>