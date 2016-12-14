<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leagues extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('teams');
    }

    public function persistLeagues($leagues, $withTeams = true) {
        foreach ($leagues as $league) {
            $this->persistLeague($league, $withTeams);
        }
    }

    public function persistLeague(League $league, $withTeams = true) {
        //$this->db->trans_begin();
        $leagueAux = $this->getLeagueByName($league->Name);

        if(!$leagueAux) {
            $leagueAux = $league->asArray();
            unset($leagueAux['teams']);
            $this->db->insert("League",$leagueAux);
            $league->IDLeague = $this->db->insert_id();;
        } else {
            $league->IDLeague = $leagueAux->IDLeague;
        }
        if($withTeams) {
            foreach ($league->teams as $team) {
                $team->RefIDLeague = $league->IDLeague;
                $team = $this->teams->persistTeam($team,false);

            }
        }

        //$this->db->trans_complete();
    }

    public function getLeagueByName($name) {
        $where = array("Name" => $name);

        $query = $this->db->get_where("League",$where);

        if($query->num_rows() == 0) {
            return false;
        }

        return $query->row();
    }
}