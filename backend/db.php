<?php
class Database
{

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "schoolmembers";
    private $username = "root";
    private $password = "";
    public $conn;

    // get the database connection
    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function insertMember($pMember)
    {
        //extract object properties
        $name = $pMember->getName();
        $email = $pMember->getEmail();
        $school = $pMember->getSchool();

        // Clean data
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));
        $school = htmlspecialchars(strip_tags($school));

        // Start connection
        $this->connect();

        // Create query
        $query = 'INSERT INTO members (m_name, m_email) VALUES (:m_name,:m_email)';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(':m_name', $name);
        $stmt->bindParam(':m_email', $email);
        // Execute query
        if ($stmt->execute()) {

            //get last inserted user id
            $query = 'SELECT m_id FROM members WHERE m_email = "' . $email . '"';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            if ($stmt->execute()) {

                $memberId = $stmt->fetchAll();
                $memberId = $memberId[0][0];
                $schoolId = $school;

                // Insert into schools_members
                $query = 'INSERT INTO schools_members (sm_school_id, sm_member_id) VALUES (:s_id,:m_id)';

                // Prepare statement
                $stmt = $this->conn->prepare($query);

                // Bind data
                $stmt->bindParam(':s_id', $schoolId);
                $stmt->bindParam(':m_id', $memberId);

                // Execute query
                if ($stmt->execute()) {
                    // close
                    $this->conn = null;
                    $stmt = null;
                    return true;

                } else {
                    print_r($stmt->errorInfo());
                    // close
                    $this->conn = null;
                    $stmt = null;
                    return false;
                }

            } else {
                print_r($stmt->errorInfo());
                // close
                $this->conn = null;
                $stmt = null;
                return false;
            }

        } else {
            print_r($stmt->errorInfo());
            // close
            $this->conn = null;
            $stmt = null;
            return false;
        }
    }

    public function getMembers($pSchoolId)
    {
        // Start connection
        $this->connect();
        // Clean data
        $pSchoolId = htmlspecialchars(strip_tags($pSchoolId));
        //Create query
        $query = 'SELECT m.m_name, m.m_email FROM members m INNER JOIN schools_members sm ON sm.sm_member_id = m.m_id WHERE sm.sm_school_id = :schoolId';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind data
        $stmt->bindParam(':schoolId', $pSchoolId);

        // Execute query
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();

            // close
            $this->conn = null;
            $stmt = null;

            return $result;
        } else {
            print_r($stmt->errorInfo());
            // close
            $this->conn = null;
            $stmt = null;
            return false;
        }

    }

}
