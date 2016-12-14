<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teams extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function persistTeams($teams, $withPlayers = true) {
        foreach ($teams as $team) {
            $this->persistTeam($team, $withPlayers);
        }
    }

    public function persistTeam(Team $team, $withPlayers = true) {
        if($this->getTeamByName($team->Name)) {
            return;
        }
        $teamArr = $team->asArray();
        unset($teamArr['players']);
        $this->db->insert("Team",$teamArr);
        $team->IDTeam = $this->db->insert_id();

        return $team;
    }

    public function getTeamByName($name) {
        $where = array("Name" => $name);

        $query = $this->db->get_where("Team",$where);

        if($query->num_rows() == 0) {
            return false;
        }

        return $query->row();
    }
}