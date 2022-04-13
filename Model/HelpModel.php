<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class HelpModel extends Database
{
    public function getHelp()
    {
        return "All Documentation for methode post and update :

Method: POST
/index.php/register
register parameter : \n
    Name : String,
    EmailAddress : String (***@***.***),
    Password : String


Method: POST
/index.php/login
login parameter : \n
    Identifier : String (EmailAdress / Name),
    Password : String


score : \n
    Method: GET
    get score:
        /index.php/score
    get One Score
        /index.php/score/{ID}

    Method: POST
    Add a Win :
        /index.php/score/win
     
        UserId : Int, 
        GameId : Int

    Method: POST
    Add a loose : 
        /index.php/score/loose

        UserId : Int, 
        GameId : Int

    Method: POST
    Add an equality :
        /index.php/score/equality

        UserId : Int, 
        GameId : Int


Method: GET
/index.php/game
Method: GET
/index.php/game/{ID}

Method: POST
/index.php/game
game parameter : \n
    Title : String,
    Overview : String


Method: GET
/index.php/userAchievement
Method: GET
/index.php/userAchievement/{ID}

Method: POST
/index.php/userAchievement
userAchievement parameter : \n
    UserId : Int,
    AchievementId : Int



Method: GET
/index.php/achievement
Method: GET
/index.php/achievement/{ID}

Method: POST
/index.php/achievement
achievement parameter : \n
    GameId : Int,
    Title : String,
    Overview : String
        ";
    }

    public function getOneGame($table) {
        switch($table) {
            case "register":
                return "Method: POST
                /index.php/register\n
register parameter : \n
    Name : String,
    EmailAddress : String (***@***.***),
    Password : String
                ";
                break;

            case "login":
                return "Method: POST
                /index.php/login\n
login parameter : \n
    Identifier : String (EmailAdress / Name),
    Password : String
                ";
                break;

            case "score":
                return "
                score : \n
                Method: GET
                get score:
                    /index.php/score
                get One Score
                    /index.php/score/{ID}
            
                Method: POST
                Add a Win :
                    /index.php/score/win
                 
                    UserId : Int, 
                    GameId : Int
            
                Method: POST
                Add a loose : 
                    /index.php/score/loose
            
                    UserId : Int, 
                    GameId : Int
            
                Method: POST
                Add an equality :
                    /index.php/score/equality
            
                    UserId : Int, 
                    GameId : Int
    ";
                break;

            case "game" :
                return"Method: GET
                /index.php/game
                Method: GET
                /index.php/game/{ID}
                
                Method: POST
                /index.php/game
                game parameter : \n
                    Title : String,
                    Overview : String
                ";
                break;
            case "userAchievement" :
                return"Method: GET
                /index.php/userAchievement
                Method: GET
                /index.php/userAchievement/{ID}
                
                Method: POST
                /index.php/userAchievement
                userAchievement parameter : \n
                    UserId : Int,
                    AchievementId : Int
                ";
                break;
            case "achievement" :
                return"Method: GET
                /index.php/achievement
                Method: GET
                /index.php/achievement/{ID}
                
                Method: POST
                /index.php/achievement
                achievement parameter : \n
                    GameId : Int,
                    Title : String,
                    Overview : String ";
                break;
            
            
        
                
        }
    }

    
}

?>