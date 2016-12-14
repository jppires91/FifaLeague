<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'models/League.php');
require_once(APPPATH.'models/Team.php');

define('FIFA_INDEX_URL',"https://www.fifaindex.com");

class Index extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $this->load->helper('simple_html_dom');
        $this->load->helper('url');
    }
    /** @Deprecated
     * */
    public function getTeams() {

		$i = 1;
		$teamName = "";
		while($this->getTeam($i)) {
			$i++;
		}
	}

	public function getTeamsAJAX() {
        $data['url'] = 'http://localhost:8080/getTeam/';
        $data['urlToPersist'] = 'http://localhost:8080/persistTeams/';
        $this->load->view('get_teams', $data);
    }

    public function persistTeams() {
        $leagueCache = $this->getLeaguesFromCache();

        $this->load->model('leagues');
        $this->leagues->persistLeagues($leagueCache);

        $this->cache->delete('leagues');

        echo 'true';
    }

    public function getTeam($i = 1) {

        $leagueCache = $this->getLeaguesFromCache();

        $url = FIFA_INDEX_URL . "/pt/teams/" . $i;
        if($this->check404($url)) {
            echo 'false';
            return;
        }

        $html = file_get_html($url);

        $div = $html->getElementById("no-more-tables");
        $tableTeams = $div->find("table",0);

        foreach ($tableTeams->find("tr[!class]") as $line) {
            $aTeamName = $line->find("td",0);
            if(!isset($aTeamName) || !isset($aTeamName->children)) {
                continue;
            }
            $aTeamName = $aTeamName->children[0];

            $urlTeam = $aTeamName->href;
            $nomeTeam = $aTeamName->title;

            if($nomeTeam == 'None') {
                continue;
            }

            $logoTeamUrl = $this->uploadTeamImage(FIFA_INDEX_URL . $aTeamName->children[0]->src);
            //$logoTeamUrl = ($aTeamName->children[0]->src);

            $team = new Team($nomeTeam,$logoTeamUrl,$urlTeam);

            $leagueName = $line->find("td[data-title=Liga]",0);
            if(!isset($leagueName) || !isset($leagueName->children)) {
                continue;
            }
            $leagueName = $leagueName->children[0]->title;

            if(!isset($leagueCache[$leagueName])) {
                $league = new League($leagueName);
            } else {
                $league = $leagueCache[$leagueName];
            }
            $league->addTeam($team);
            $leagueCache[$leagueName] = $league;

        }

        $this->saveLeaguesInCache($leagueCache);
        echo 'true';
        return;
    }

	private function check404($url) {
		$headers = get_headers($url);
		/*echo '<pre>';
		print_r($headers);
		echo '</pre>';*/
		return in_array('HTTP/1.1 404 NOT FOUND', $headers);
	}

	private function uploadTeamImage($url) {

	    $url = str_replace('crest/50/', 'crest/256/', $url);
	    $new = "images/teams/" . sha1($url) . '.png';
        $data = $this->get_data($url);
	    file_put_contents($new, $data);
	    return $new;
    }

    private function get_data($url)
    {

        $userAgent = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Encoding: gzip, deflate, sdch, br',
            'Accept-Language: pt-PT,pt;q=0.8,en-US;q=0.6,en;q=0.4',
            'Referer: https://www.fifaindex.com/pt/teams/',
            'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36',
            'Connection: Keep-Alive'
        ));

        $html = curl_exec($ch);
        if (!$html) {
            echo "<br />cURL error number:" . curl_errno($ch);
            echo "<br />cURL error:" . curl_error($ch);
            exit;
        } else {
            return $html;
        }
    }

    private function getLeaguesFromCache() {
        $leagues = $this->cache->get('leagues');

        if(!$leagues) {
            return array();
        } else {
            return $leagues;
        }

    }

    private function saveLeaguesInCache($leagues) {
        $this->cache->save('leagues', $leagues, 500);
    }
}

