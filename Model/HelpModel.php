<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class HelpModel extends Database
{
    public function getHelp()
    {
        return "All Documentation for methode post and update :

/index.php/register
register parameter : \n
    Name : String,
    EmailAddress : String (***@***.***),
    Password : String



/index.php/login
login parameter : \n
    Identifier : String (EmailAdress / Name),
    Password : String



score : \n
    Add a Win :
        /index.php/score/win
     
        UserId : Int, 
        GameId : Int

    Add a loose : 
        /index.php/score/loose

        UserId : Int, 
        GameId : Int
    
    Add an equality :
        /index.php/score/equality

        UserId : Int, 
        GameId : Int



/index.php/game
game parameter : \n
    Title : String,
    Overview : String



/index.php/userAchievement
userAchievement parameter : \n
    UserId : Int,
    AchievementId : Int




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
                return "/index.php/register\n
register parameter : \n
    Name : String,
    EmailAddress : String (***@***.***),
    Password : String
                ";
                break;

            case "login":
                return "/index.php/login\n
login parameter : \n
    Identifier : String (EmailAdress / Name),
    Password : String
                ";
                break;

            case "score":
                return "
score : \n
    Add a Win :
        /index.php/score/win
     
        UserId : Int, 
        GameId : Int

    Add a loose : 
        /index.php/score/loose

        UserId : Int, 
        GameId : Int
    
    Add an equality :
        /index.php/score/equality

        UserId : Int, 
        GameId : Int
    ";
                break;

            case "game" :
                return"/index.php/game\n
game parameter : \n
    Title : String,
    Overview : String
                ";
                break;
            case "userAchievement" :
                return"/index.php/userAchievement\n
userAchievement parameter : \n
    UserId : Int,
    AchievementId : Int
                ";
                break;
            case "achievement" :
                return"/index.php/achievement\n
achievement parameter : \n
    GameId : Int,
    Title : String,
    Overview : String
                ";
                break;
            
            
        
                
        }
    }

    
}

?>