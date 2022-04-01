<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");
 

// ALL CONFIGURATION FILE

// include main configuration file
require_once PROJECT_ROOT_PATH . "/inc/config.php";
 
// include the base controller file
require_once PROJECT_ROOT_PATH . "/Controller/BaseController.php";

// include the base controller file
require_once PROJECT_ROOT_PATH . "/Model/Database.php";


// ALL MODEL FILE

// Include the use UserModel file
require_once PROJECT_ROOT_PATH . "/Model/UserModel.php";

// Include the use AuthentificationModel file
require_once PROJECT_ROOT_PATH . "/Model/AuthentificationModel.php";

// Include the use AchievementModel file
require_once PROJECT_ROOT_PATH . "/Model/AchievementModel.php";

// Include the use GameModel file
require_once PROJECT_ROOT_PATH . "/Model/GameModel.php";

// Include the use ScoreModel file
require_once PROJECT_ROOT_PATH . "/Model/ScoreModel.php";

// Include the use UserAchievementModel file
require_once PROJECT_ROOT_PATH . "/Model/UserAchievementModel.php";

// Include the use HelpModel file
require_once PROJECT_ROOT_PATH . "/Model/HelpModel.php";


//ALL CONTROLLER FILE

// Include the user Controller file
require PROJECT_ROOT_PATH . "/Controller/UserController.php";

// Include the authentification Controller file
require PROJECT_ROOT_PATH . "/Controller/Authentification.php";

// Include the AchievementController Controller file
require PROJECT_ROOT_PATH . "/Controller/AchievementController.php";

// Include the GameController Controller file
require PROJECT_ROOT_PATH . "/Controller/GameController.php";

// Include the ScoreController Controller file
require PROJECT_ROOT_PATH . "/Controller/ScoreController.php";

// Include the UserAchievement Controller file
require PROJECT_ROOT_PATH . "/Controller/UserAchievementController.php";

// Include the Help Controller file
require PROJECT_ROOT_PATH . "/Controller/HelpController.php";

 

?>