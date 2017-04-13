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
    private $peopleWorkflow;
    /**
     * people of people
     */
    private $peoplePeople;

    /**
     * constructor for this people class
     * @param int $newPeopleDashboard forign key for people
     * @param string $newPeopleLists list of people
     * @param int $newPeopleWorkflow workflow for people
     * @param string $newPeoplePeople people on people
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data types are to long
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     */
    public function __construct(int $newPeopleDashboard = null, string $newPeopleLists = null, int $newPeopleWorkflow = null, string $newPeoplePeople = null) {
        try {
            $this->setPeopleDashboard($newPeopleDashboard);
            $this->setPeopleLists($newPeopleLists);
            $this->setPeopleWorkflow($newPeopleWorkflow);
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
     * @return int value of people lists
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

}