<?php
/**
CREATE TABLE member(
member_id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
fname VARCHAR(50),
lname VARCHAR(50),
age INT,
gender vARCHAR(10),
phone VARCHAR(20),
email VARCHAR (50),
state VARCHAR(20),
seeking VARCHAR(10),
bio VARCHAR(255),
premium BOOLEAN,
image VARCHAR(255));

CREATE TABLE interests(
interests_id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
interests VARCHAR(50),
type VARCHAR(50));

CREATE TABLE member_interests(
member_id INT,
interests_id INT,
FOREIGN KEY (member_id) REFERENCES member(member_id),
FOREIGN KEY (interests_id) REFERENCES interests(interests_id));
 */

require '/home2/mgallar1/config.php';
class Database
{
    private $_dbh;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * @return PDO
     */
    function connect()
    {
        try{

            //instantiate a db object
            $this->_dbh = new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
            return $this->_dbh;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     * This method inserts new members and their favorite interests
     * @return void
     */
    function insertMembers()
    {
        global $f3;

        //Define the query
        $sql = 'INSERT INTO member VALUES (member_id, :fname, :lname, :age, :gender, :phone, 
        :email, :state, :seeking,:bio, :premium,"image path")';

        //2.prepare statement
        $statement = $this->_dbh->prepare($sql);

        //3.Define parameters
        $member = $f3->get('member');
        $fname = $member->getFname();
        $lname = $member->getLname();
        $age = $member->getAge();
        $gender = $member->getGender();
        $phone = $member->getPhone();
        $email = $member->getEmail();
        $state = $member->getState();
        $seeking = $member->getSeeking();
        $bio = $member->getBio();

        //check if user is a premium member
        if( $member instanceof PremiumMember)
        {
            $premium = 1;
        }
        else
        {
            $premium = 0;
        }

        //3.Define parameters
        $statement->bindParam(':fname', $fname, PDO::PARAM_STR);
        $statement->bindParam(':lname', $lname, PDO::PARAM_STR);
        $statement->bindParam(':age', $age, PDO::PARAM_INT);
        $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':state', $state, PDO::PARAM_STR);
        $statement->bindParam(':seeking', $seeking, PDO::PARAM_STR);
        $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
        $statement->bindParam(':premium', $premium, PDO::PARAM_STR);

        //Execute statement
        $statement->execute();

//        //add activities
        if( $member instanceof PremiumMember) {

            $id = $this->_dbh->lastInsertId();

            if (!empty($member->getInDoorInterests())) {

                $activities = $member->getInDoorInterests();
                foreach($activities as $activity) {
                    //Define the query
                    $sql = "SET @interest= (SELECT interests_id FROM interests WHERE interests='$activity');
                    INSERT INTO member_interests VALUES($id,@interest);";

                    echo $activity . $id;

                    //2.prepare statement
                    $statement = $this->_dbh->prepare($sql);

                    //Execute statement
                    $statement->execute();
                }
            }

            if (!empty($member->getOutDoorInterests())) {

                $activities = $member->getOutDoorInterests();
                foreach($activities as $activity) {
                    //Define the query
                    $sql = "SET @interest= (SELECT interests_id FROM interests WHERE interests='$activity');
                    INSERT INTO member_interests VALUES($id,@interest);";

                    echo $activity . $id;

                    //2.prepare statement
                    $statement = $this->_dbh->prepare($sql);

                    //Execute statement
                    $statement->execute();
                }
            }
        }
    }

    /**
     * This method gets all the members that have sign up for the dating site
     * @return void
     */
    function getMembers()
    {
        //Define the query
        $sql = "SELECT * FROM member;";

        //2.prepare statement
        $statement = $this->_dbh->prepare($sql);

        //Execute statement
        $statement->execute();

        //return the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * This method returns a singular member row
     * @param $member_id takes a member id to retrieve his information
     * @return string, member row information
     */
    function getMember($member_id)
    {
        //Define the query
        $sql = "SELECT * FROM member WHERE member_id =:member_id;";

        //2.prepare statement
        $statement = $this->_dbh->prepare($sql);

        //3.Define parameters
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_STR);

        //Execute statement
        $statement->execute();

        //return the result
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @param $member_id takes a member id to retrieve it's interessts
     * @return void
     */
    function getInterests($member_id)
    {
        $sql = "SELECT interests FROM interests, member, member_interests 
        WHERE member.member_id=:member_id AND member.member_id = member_interests.member_id 
        AND interests.interests_id = member_interests.interests_id;";

        //2.prepare statement
        $statement = $this->_dbh->prepare($sql);

        //3.Define parameters
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_STR);

        //Execute statement
        $statement->execute();

        //return the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            echo $row['interests'] . ", ";
        }
    }


}