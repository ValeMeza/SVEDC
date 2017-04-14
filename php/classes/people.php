<?php
namespace Svedc\DataDesign;
require_once ("autoload.php");
/**
 * Data Design for people planning center
 *
 * This class will be forgin key for accessing information from people planning center website.
 *
 *
 * @author Valente Meza <valebmeza@gmail.com>
 * @version 4.0.0
 */
class People implements \JsonSerializable {
    use ValidateDate;
    /**
     *
     * dashboard for people; this is the forign key
     * @var $peopleDashboard
     */
    private $peopleDashboard;
    /**
     * Lists of people
     */
    private $peopleLists;
    /**
     * workflow for people
     */
    private $peopleWorkflows;
    /**
     * people of people
     */
    private $peoplePeople;

    /**
     * constructor for this people class
     * @param int $newPeopleDashboard forign key for people
     * @param string $newPeopleLists list of people
     * @param int $newPeopleWorkflows workflow for people
     * @param string $newPeoplePeople people on people
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data types are to long
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     */
    public function __construct(int $newPeopleDashboard = null, string $newPeopleLists = null, int $newPeopleWorkflows = null, string $newPeoplePeople = null) {
        try {
            $this->setPeopleDashboard($newPeopleDashboard);
            $this->setPeopleLists($newPeopleLists);
            $this->setPeopleWorkflows($newPeopleWorkflows);
            $this->setPeoplePeople($newPeoplePeople);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }
    /**
     * accessor method for people Dashboard
     *
     * @return int|null value of people Dashboard
     */
    public function getPeopleDashboard() : int {
        return($this->peopleDashboard);
    }
    /**
     * mutator method for people Dashboard
     *
     * @param int|null $newPeopleDashboard new value of people Dashboard
     * @throws \RangeException if $newPeopleDashboard is not positive
     * @throws \TypeError if $newPeopleDashboard is not an integer
     */
    public function setPeopleDashboard(?int $newPeopleDashboard) : void {
        //if people dashboard is null immediately return it
        if($newPeopleDashboard === null) {
            $this->peopleDashboard = null;
            return;
        }
        // verify the people dashboard is positive
        if($newPeopleDashboard <= 0) {
            throw(new \RangeException("people dashboard is not positive"));
        }
        // convert and store the people dashboard
        $this->peopleDashboard = $newPeopleDashboard;
    }
    /**
     * accessor method for people Lists
     *
     * @return string value of people lists
     */
    public function getPeopleLists() : string {
        return($this->peopleLists);
    }
    /**
     * mutator method for people lists
     *
     * @param string $newPeopleLists new value of people lists
     * @throws \InvalidArgumentException if $newPeopleLists is not a string or insecure
     * @throws \RangeException if $newPeopleLists is > 80 characters
     * @throws \TypeError if $newPeopleLists is not a string
     */
    public function setPeopleLists(string $newPeopleLists) : void {
        // verify the people lists is secure
        $newPeopleLists = trim($newPeopleLists);
        $newPeopleLists = filter_var($newPeopleLists, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($newPeopleLists) === true) {
            throw(new \InvalidArgumentException("people lists is empty or insecure"));
        }
        // verify the people lists content will fit in the database
        if(strlen($newPeopleLists) > 80) {
            throw(new \RangeException("people lists is too large"));
        }
        // store the people content
        $this->peopleLists = $newPeopleLists;
    }
    /**
     * accessor method for people workflows
     *
     * @return int for people workflows
     */
    public function getPeopleWorkflows() : int {
        return($this->peopleWorkflows);
    }
    /**
     * mutator method for people workflows
     *
     * @param int|null $newPeopleWorkflows
     * @throws \RangeException if $newPeopleWorkflows is not positive
     * @throws \TypeError if $newPeopleWorkflows is not an intger
     */
    public function setPeopleWorkflows(?int $newPeopleWorkflows) : void  {
        // if people workflows is null immediately return it
        if($newPeopleWorkflows === null) {
            $this->peopleWorkflows = null;v
            return;
        }
        // verify the people workflows is positive
        if($newPeopleWorkflows <= 0) {
            throw(new \RangeException("people workflows is not positive"));
        }
        // convert and store the people workflows
        $this->peopleWorkflows = $newPeopleWorkflows;
    }
    /**
     * accessor method for people workflows
     *
     * @return string value of people workflows
     */
    public function getPeoplePeople() : string {
        return($this->peoplePeople);
    }
    /**
     * mutator method for people people
     *
     * @param string $newPeoplePeople new value of people people
     * @throws \InvalidArgumentException if $newPeoplePeople is not a string or insecure
     * @throws \RangeException if $newPeoplePeople is > 64 characters
     * @throws \TypeError if $newPeoplePeople is not a string
     */
    public function setPeoplePeople(string $newPeoplePeople) : void {
        // verify the people people is secure
        $newPeoplePeople = trim($newPeoplePeople);
        $newPeoplePeople = filter_var($newPeoplePeople, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($newPeoplePeople) === true) {
            throw(new \InvalidArgumentException("people people is empty or insecure"));
        }
        // verify the people people content will fit in the database
        if(strlen($newPeoplePeople) > 64) {
            throw(new \RangeException("people people is too large"));
        }
        // store the people people content
        $this->peoplePeople = $newPeoplePeople;
    }
    /**
     * inserts this People into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     */
    public function insert(\PDO $pdo) : void {
        // enfore the peopleDashboard is null (i.e, dont insert a dashboard that already exists)
        if($this->peopleDashboard !== null) {
            throw(new \PDOException("not a new dashboard"));
        }
        // create query template
        $query = "INSERT INTO people(peopleDashboard, peopleWorkflows, peopleLists, peoplePeople) VALUES(:peopleDashboard, :peopleWorkflows, :peopleLists, :peoplePeople)";
        $statement = $pdo->prepare($query);
        $parameters = ["peopleDashboard" => $this->peopleDashboard, "peopleWorkflows" => $this->peopleWorkflows, "peopleLists" => $this->peopleLists, "peoplePeople" => $this->peoplePeople];
        $statement->execute($parameters);
        // update the null peopleDashboard with what mySQl just gave us
        $this->peopleDashboard = intval($pdo->lastInsertId());
    }
}