<?php


//define a class called resident managaer 
class ResidentManager
{
    private $db;
    private $residentList;

    // Define a constructor that accepts a database connection
    public function __construct()
    {
        $search = null;
        if (isset($_GET['search-q'])) {
            $search = $_GET['search-q'];
        }

        $this->db = new DB();
        $this->residentList = $this->getResidents($search);
    }

    public function getresidentList()
    {
        return $this->residentList;
    }

    // Define a public method called "getResidents" that retrieves all residents from the database and returns them as an array
    public function getResidents($search = null)
    {

        // if user did not search any thing, this line of code will be executed
        $stmt = $this->db->connect()->prepare('SELECT * FROM Residents');

        // if the search is not null, means if the user searched for something
        if ($search != null) {

            if (is_numeric($search)) {
                // $search = (int) $search;
                $stmt = $this->db->connect()->prepare("SELECT * FROM residents WHERE `Resident ID` = :search");
                $stmt->bindValue(':search', $search, PDO::PARAM_INT);
            } else {
                $stmt = $this->db->connect()->prepare("SELECT * FROM residents WHERE `Last Name` LIKE :search OR `First Name` LIKE :search");
                $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            }

        }

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $residentList = [];

        foreach ($results as $row) {
            $resident = new Resident(
                $row['First Name'], $row['Last Name'], $row['Middle Initial'], $row['Resident ID'],
                $row['Position'], $row['DOB'], $row['Nationality'], $row['Gender'], $row['Marital Status'],
                $row['Family Type'], $row['Home Address'], $row['Mailing Address'], $row['Email Address'],
                $row['Phone Number'], $row['ID Number'], $row['Contact Name'], $row['Contact Relationship'],
                $row['Contact Telephone'], $row['Contact Address'], $row['Contact Email'], $row['Level of Study'],
                $row['Year of Study'], $row['Programme Name'], $row['Faculty Name'], $row['Name of School'], $row['Room Number']
            );

            array_push($residentList, $resident);
        }

        return $residentList;
    }

    // Define a public method called "findResident" that retrieves a resident from the database based on their ID and returns their information as an array
    public function findResident($id)
    {
        $stmt = $this->db->connect()->prepare('SELECT * FROM Residents WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Define a public method called "updateResident" that updates a resident in the database based on their ID
    public function updateResident($id)
    {
        $resident = $this->findResident($id);

        if (!$resident) {
            return false; // Resident not found
        }

        $stmt = $this->db->connect()->prepare('UPDATE Residents WHERE id = :id');
        $stmt->bindParam(':firstname', $firstName);
        $stmt->bindParam(':lastname', $lastName);
        $stmt->bindParam(':middleInitial', $middleInitial);
        $stmt->bindParam(':residentID', $residentID);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':DOB', $DOB);
        $stmt->bindParam(':nationality', $nationality);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':martialStatus', $maritalStatus);
        $stmt->bindParam(':familyType', $familyType);
        $stmt->bindParam(':homeAddress', $homeAddress);
        $stmt->bindParam(':mailingAddress', $mailingAddress);
        $stmt->bindParam(':emailAddress', $emailAddress);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':studentID', $studentID);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':levelOfStudy', $levelOfStudy);
        $stmt->bindParam(':yearOfStudy', $yearOfStudy);
        $stmt->bindParam(':programme', $programme);
        $stmt->bindParam(':faculty', $faculty);
        $stmt->bindParam(':school', $school);
        $stmt->bindParam(':roomNumber', $roomNumber);
        $stmt->execute();

    }


    public function deleteResident($id)
    {
        $stmt = $this->db->connect()->prepare('DELETE FROM Residents WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function displayResidentByPosition($position){
        $dataToDisplay = "";
        foreach ($this->residentList as $resident){
            if($resident->getresident()->getPosition() == $position){
                $dataToDisplay .= "<tr>";
                $dataToDisplay .= "<td>".$resident->getResidents()."</td>";
                $dataToDisplay .= "<td>".$resident->getPersonalDetails()->getFirstName(). " " . $resident->getPersonalDetails()->getLastName() . "</td>";
                $dataToDisplay .= "<td> <span class=\"" . $resident->getresident()->getPosition() . "\">" . $resident->getresident()->getPosition(). "<span> </td>"; 
                //$dataToDisplay .= "<td> <a href=\" ./applicationDetails.php?id=". $applicant->getApplicantID() ."\" target=\"_blank\">View</a></td>"; //A link to view the application details
                $dataToDisplay .= "</tr>";
            }
        }
        return $dataToDisplay;

    }
    



    public function displayResidents($search = null)
    {

        $dataToDisplay = "";

      

        if ($search != null) {
            foreach ($this->residentList as $resident) {
                $dataToDisplay .= "<tr>";
                $dataToDisplay .= "<td>" . $resident->getResidentID() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getPosition() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getFirstName() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getLastName() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getMiddleInitial() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getHomeAddress() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getPhoneNumber() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getRoomNumber() . "</td>";

            }
        } else {
            foreach ($this->residentList as $resident) {
                $dataToDisplay .= "<tr>";
                $dataToDisplay .= "<td>" . $resident->getResidentID() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getPosition() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getFirstName() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getLastName() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getMiddleInitial() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getHomeAddress() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getPhoneNumber() . "</td>";
                $dataToDisplay .= "<td>" . $resident->getRoomNumber() . "</td>";

            }
        }

        return $dataToDisplay;
    }
}

    