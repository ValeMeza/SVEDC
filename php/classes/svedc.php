<?php
namespace Svedc\DataDesign;
require_once("autoload.php");


class Svedc implements \JsonSerializable {
    use ValidateDate;
    /**
     * @var int $svedcCalender
     */
    private $svedcCalender;

    /**
     * constructor for this Calender
     *
     * @param int|null $newSvedcCalender calender for the svedc or null if empty
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data types vvalues are out of bounds
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     */
    public function __construct($newSvedcCalender) {
       try {
           $this->setSvedcCalender($newSvedcCalender);
       }
       catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
           $exceptionType = get_class($exception);
           throw(new $exceptionType($exception->getMessage(), 0, $exception));
       }
    }
    /**
     * accessor method for svedc calender
     *
     * @return \DateTime value of svedc calender
     */
    public function getSvedcCalender() : \DateTime {
        return($this->svedcCalender);
    }
    /**
     * mutator method for svedc calender
     *
     * @param \DateTime|string|null $newSvedcCalender new value of svedc calender
     * @throws \RangeException if $newSvedcCalender is not positive
     * @throws \TypeError if$newSvedcCalender is not an integer
     */
    /**
     *
     */
    public function setSvedcCalender($newSvedcCalender = null) : void {
        if($newSvedcCalender === null) {
            $this->svedcCalender = new \DateTime();
            return;
        }
        try {
            $newSvedcCalender = self::validateDateTime($newSvedcCalender);
        } catch(\InvalidArgumentException | \RangeException $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        $this->svedcCalender = $newSvedcCalender;
    }
    /**
     * inserts this Calender into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     */
    public function insert(\PDO $pdo) : void {
        if($this->svedcCalender !== null) {
            throw(new \PDOException("not a new calender"));
        }
        $query = "INSERT INTO svedc(svedcCalender) VALUE(:svedcCalender)";
        $statement = $pdo->prepare($query);
        $formattedDate = $this->svedcCalender->format("Y-m-d H:i:s");
        $parameters = ["svedcCalender" => $formattedDate];
        $statement->execute($parameters);
        $this->svedcCalender = intval($pdo->lastInsertId());
    }
}