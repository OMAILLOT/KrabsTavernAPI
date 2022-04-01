<?php

    class AuthentificationModel extends Database {
        public function register ($name,$address,$password,$gamesNumber) {
            try {
                $scoreId = $this->getLastScoreId();
                if ($scoreId == 0) {
                    $scoreId = 1;
                }
                
                if ($this->isIdentifierExiste($name,$address) == true) {
                    return "your identifier already exist";
                }
                
                $this->insert("INSERT INTO users (Name,EmailAddress,Password)
                                VALUES (?,?,?)"
                ,["sss",$name,$address,$password]);
                
                
                $maxId = $this->getMaxId();

                if($maxId == null) {
                    $maxId = 1;
                }

                for ($i = 1; $i <= $gamesNumber; $i++) {
                    $this->insert("INSERT INTO scores (WinNumber, LooseNumber, EqualityNumber, UserId) VALUES (?,?,?,?)",["iiii", 0,0,0, $maxId]);
                    $this->insert("INSERT INTO scoregame (ScoreId, GameId) VALUES (?,?)",["ii", $this->getLastScoreId(), $i]);
                    
                    $scoreId++;
                }
                
                return ;
            } catch (Exception $e) {
                echo "Your identifier or EmailAddress are already exist."."\n".$e;
            }
            
        }
        
        public function login($identifier, $password) {
            try {
                $isPasswordFind = false;
                if ($this->getUserPasswordWithPseudoOrEmail($identifier) == false) {
                    return "your identifier not exist";
                }
                foreach ($this->getUserPasswordWithPseudoOrEmail($identifier) AS $verif) {
                    $verifPassword = password_verify($password, $verif);
                    if ($verifPassword == true) {
                        $isPasswordFind= true;
                    }
                }

                if ($isPasswordFind) {

                    return $this->select('SELECT UserId, Name, EmailAddress FROM users 
                    WHERE (EmailAddress = "'."$identifier" .'" OR Name = "'."$identifier".'") AND "'.$verifPassword.'" = true');
                }
            } catch (Exception $e) {
                echo "Your identifier or password are not correct.".$e;
            }
        }

        public function forgot_password($id, $email) {
            try {
                $newPassword = implode("",$this->generatePassword());
                $notHashPassword = $newPassword;
                $newPassword =  password_hash($newPassword, PASSWORD_DEFAULT);
                if ($this->getUserWithEmail($email) == false) {
                    return "your email is not found";
                }

                $userId = $this->getUserWithEmail($email);
                $isFind = false;
                foreach ($userId as $value) {
                    if ($value == $id) {
                        $isFind = true;
                    }
                }
                if (!$isFind) {
                    return "Your id is not correct";
                }

                $emailSubjet = "New password for e-commerce-SQL";
                $emailMessage = "Hello,\n I just send you an email for to tell you that we reset your password,\nyour new password is : $notHashPassword";

                ini_set("SMTP", "gmail-smtp-in.l.google.com");
                ini_set("smtp_port", 25);
                ini_set("sendmail_from","monadresse@gmail.com");
                
                mail($email,$emailSubjet,wordwrap($emailMessage, 70, "\r\n"),"From: username@gmail.com");

                $this->insert('UPDATE users SET Password ="'.$newPassword.'" WHERE UserId = "'.$id.'"');
                return $this->select('SELECT UserId, Pseudo, EmailAddress, CONCAT(FirstName," ", LastName) AS FullName FROM users 
                WHERE (EmailAddress = "'.$email.'") AND UserId = "'.$id.'"');
            } catch (Exception $e) {
                echo "Your email address are not correct.";
            }
        }

        public function getMaxId() {
            $selectUserId = "SELECT MAX(UserId) AS UserId FROM users";
            $resultQueryUser = $this -> connection -> query($selectUserId);
            $userId = 0;
            while($row = mysqli_fetch_array($resultQueryUser)) {
                $userId = $row['UserId'];
            }
            return $userId;
        }

        private function getUserWithEmail($email) {
            $selectUser = 'SELECT UserId FROM users WHERE (EmailAddress = "'."$email".'")';
            $resultQueryUser = $this -> connection -> query($selectUser);
            $password = array();
                while($row = mysqli_fetch_array($resultQueryUser)) {
                    array_push($password, $row['UserId']);
                }
            if ($password == []) {
                return false;
            } else {
                return $password;
            }
        }

        private function getUserPasswordWithPseudoOrEmail($identifier) {
            $selectUser = 'SELECT Password FROM users WHERE (EmailAddress = "'."$identifier" .'" OR Name = "'."$identifier".'")';
            $resultQueryUser = $this -> connection -> query($selectUser);
            $password = array();
                while($row = mysqli_fetch_array($resultQueryUser)) {
                    array_push($password, $row['Password']);
                }
            if ($password == []) {
                return false;
            } else {
                return $password;
            }
        }

        private function generatePassword() {
            $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); 
            $combLen = strlen($comb) - 1; 
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $combLen);
                $pass[] = $comb[$n];
            }
            return $pass;
        }

        private function isIdentifierExiste($name,$address) {
            $selectUser = 'SELECT Name, EmailAddress FROM users WHERE (EmailAddress = "'."$address" .'" OR Name = "'."$name".'")';
            $resultQueryUser = $this -> connection -> query($selectUser);
            $password = array();
                while($row = mysqli_fetch_array($resultQueryUser)) {
                    array_push($password, $row['Name']);
                    array_push($password, $row['EmailAddress']);
                }
            if ( count($password) == 0) {
                return false;
            } else {
                return true;
            }
        }

        private function getLastScoreId() {
            $selectScoreId = 'SELECT MAX(ScoreId) as ScoreId FROM scores';
            $resultQueryScore = $this -> connection -> query($selectScoreId);
            $resultId = 0;
                while($row = mysqli_fetch_array($resultQueryScore)) {
                    return $row['ScoreId'];
                }

                return $resultId;
        }
    }

?>