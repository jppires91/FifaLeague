<?php
/**
 * Created by PhpStorm.
 * User: Joao
 * Date: 12/12/2016
 * Time: 23:19
 */

class Team {
    public $IDTeam;
    public $Name;
    public $Logo;
    public $Url;
    public $RefIDLeague;
    private $players;


    public function __construct($name, $logo, $url)
    {
        $this->Name = $name;
        $this->Logo = $logo;
        $this->Url  = $url;
    }

    public function addPlayer($player) {
        $this->players[] = $player;
    }

    public function asArray() {
        return get_object_vars($this);
    }
}