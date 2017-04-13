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
     * @param int $newPeopleLists list of people
     * @param int $newPeopleWorkflow workflow for people
     * @param string $newPeoplePeople people on people
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data types are to long
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     */
    public function __construct(int $newPeopleDashboard = null, int $newPeopleLists = null, int $newPeopleWorkflow = null, string $newPeoplePeople = null) {
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

}