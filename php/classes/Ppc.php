<?php
namespace Svedc\DataDesign;
require_once("autoload.php");
/**
 * PPC class
 *
 * PPC class which allows users to authorize account with PPC.
 *
 * @author Mason Crane <cmd-space.com>
 * @version 1.0.0
 **/
class Ppc implements \JsonSerializable {
	/**
	 * id for this PPC; this is the primary key
	 * @var int $ppcOAuthId
	 **/
	private $ppcOAuthId;
	/**
	 * service name for PPC
	 * @var string $oAuthServiceName
	 **/
	private $ppcOAuthServiceName;
	/**
	 * constructor for this PPC
	 *
	 * @param int|null $newPpcOAuthId id of this PPC or null if a new PPC
	 * @param string $newPpcOAuthServiceName string containing actual Service Name data for this PPC
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newPpcOAuthId = null, string $newPpcOAuthServiceName) {
		try {
			$this->setPpcOAuthId($newPpcOAuthId);
			$this->setPpcOAuthServiceName($newPpcOAuthServiceName);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for ppcOAuth id
	 *
	 * @return int|null value of ppcOAuth id
	 **/
	public function getPpcOAuthId() {
		return($this->ppcOAuthId);
	}
	/**
	 * mutator method for ppcOAuth id
	 *
	 * @param int|null $newPpcOAuthId new value of ppcOAuth id
	 * @throws \RangeException if $newPpcOAuthId is not positive
	 * @throws \TypeError if $newPpcOAuthId is not an integer
	 **/
	public function setPpcOAuthId(int $newPpcOAuthId = null) {
		// base case: if the ppcOAuth id is null, this is a new ppcOAuth without a mySQL assigned id (yet)
		if($newPpcOAuthId === null) {
			$this->ppcOAuthId = null;
			return;
		}
		// verify that the ppcOAuth id is positive
		if($newPpcOAuthId <= 0) {
			throw(new \RangeException("ppcOAuth id is not positive..."));
		}
		// convert and store the ppcOAuth id
		$this->ppcOAuthId = $newPpcOAuthId;
	}
	/**
	 * accessor method for ppcOAuth service name
	 *
	 * @return string value of ppcOAuth service name
	 **/
	public function getPpcOAuthServiceName() {
		return($this->ppcOAuthServiceName);
	}
	/**
	 * mutator method for ppcOAuth service name
	 *
	 * @param string $newPpcOAuthServiceName new value of ppcOAuth service name
	 * @throws \InvalidArgumentException if $newPpcOAuthServiceName is insecure
	 * @throws \RangeException if $newPpcOAuthServiceName is > 32 characters
	 * @throws \TypeError if $newPpcOAuthServiceName is not a string
	 **/
	public function setPpcOAuthServiceName(string $newPpcOAuthServiceName) {
		// verify that the ppcOAuth service name content is secure
		$newPpcOAuthServiceName = trim($newPpcOAuthServiceName);
		$newPpcOAuthServiceName = filter_var($newPpcOAuthServiceName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPpcOAuthServiceName) === true) {
			throw(new \InvalidArgumentException("ppcOAuth service name is empty or insecure..."));
		}
		// verify that ppcOAuth service name content will fit in the database
		if(strlen($newPpcOAuthServiceName) > 32) {
			throw(new \RangeException("ppcOAuth service name is too long..."));
		}
		// store the ppcOAuth service name content
		$this->ppcOAuthServiceName = $newPpcOAuthServiceName;
	}
	/**
	 * inserts this PPC into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce the ppcOAuthId is null (i.e., don't insert a ppcOAuth that already exists)
		if($this->ppcOAuthId !== null) {
			throw(new \PDOException("PPC already exists..."));
		}
		// create query template
		$query = "INSERT INTO ppc(ppcOAuthServiceName) VALUES(:ppcOAuthServiceName)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the placeholders in the template
		$parameters = ["ppcOAuthServiceName" => $this->ppcOAuthServiceName];
		$statement->execute($parameters);
		// update the null ppcOAuthId with what mySQL just gave us
		$this->ppcOAuthId = intval($pdo->lastInsertId());
	}
	/**
	 * gets the PPC by ppcOAuth id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $ppcOAuthId PPC id to search for
	 * @return Ppc|null PPC found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getPpcByPpcOAuthId(\PDO $pdo, int $ppcOAuthId) {
		// sanitize the oAuthId before searching
		if($ppcOAuthId <= 0) {
			throw(new \PDOException("ppcOAuth id is 0 or negative..."));
		}
		// create query template
		$query = "SELECT ppcOAuthId, ppcOAuthServiceName FROM ppc WHERE ppcOAuthId = :ppcOAuthId";
		$statement = $pdo->prepare($query);
		// bind the ppcOAuth id to the placeholder in the template
		$parameters = ["ppcOAuthId" => $ppcOAuthId];
		$statement->execute($parameters);
		// grab the PPC from mySQL
		try {
			$ppc = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$ppc = new Ppc($row["ppcOAuthId"], $row["ppcOAuthServiceName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($ppc);
	}
	/**
	 * get ALL the PPCs
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of PPCs found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getAllPpcs(\PDO $pdo) {
		// create query template
		$query = "SELECT ppcOAuthId, ppcOAuthServiceName FROM ppc";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of PPCs
		$ppcs = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$ppc = new Ppc($row["ppcOAuthId"], $row["ppcOAuthServiceName"]);
				$ppcs[$ppcs->key()] = $ppc;
				$ppcs->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($ppcs);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}