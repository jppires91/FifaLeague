<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class League {

	public $IDLeague;
	public $Name;
    public $Location;
    public $teams;

	public function __construct($name, $location = null)
    {
        $this->Name = $name;
        $this->Location = $location;
    }

    public function addTeam(Team $team) {
	    if(!isset($this->teams[$team->Name])) {
            $this->teams[$team->Name] = $team;
        }
    }

    public function asArray() {
	    return get_object_vars($this);
    }

}