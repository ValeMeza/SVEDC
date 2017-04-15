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
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}