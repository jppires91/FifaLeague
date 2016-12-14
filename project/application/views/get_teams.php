<?php
/**
 * Created by PhpStorm.
 * User: Joao
 * Date: 07/12/2016
 * Time: 17:10
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hello</title>
</head>
    <body onload="get_team(1)">

    </body>
</html>
<script type="text/javascript">

    function addElementToBody(i) {
        document.getElementsByTagName("BODY")[0].innerHTML += '<p id="pg' + i + '">Fetching page ' + i + '...</p>';
    }

    function setElementDone(i) {
        document.getElementById("pg" + i).innerHTML = 'Fetching page ' + i + '... done';
    }

    function setNoPageToFetch(i) {
        document.getElementById("pg" + i).innerHTML = 'No more pages to fetch...';
    }

    function addElementPersist() {
        document.getElementsByTagName("BODY")[0].innerHTML += '<p id="persist">Persisting entities...</p>';
    }

    function refreshElement(i) {
        var str = document.getElementById("pg" +i).innerHTML;

        var strI = new String(i);

        var points = str.substring(str.indexOf(i)+ strI.length, str.length);
        var fr = str.substring(0,str.indexOf(i)+strI.length);

        var pr = '';

        switch(points) {
            case '':
                pr = '.';
                break;
            case '.':
                pr = '..';
                break;
            case '..':
                pr = '...';
                break;
            case '...':
            default:
                pr = '';
                break;
        }

        document.getElementById("pg" +i).innerHTML = fr + pr;
    }

	function get_team(idx) {
        addElementToBody(idx);
		var url = <?='"' .  $url . '"' ?>;
		url += idx;

		var idInt = setInterval(function(){
            refreshElement(idx);
        }, 500);

		return httpGetAsync(url, function() {
		    clearInterval(idInt);
            setElementDone(idx);
		    get_team(idx+1);
        }, function () {
            clearInterval(idInt);
            setNoPageToFetch(idx);
            persist();
        });

	}

	function persist() {
        var urlToPersist = <?='"' .  $urlToPersist . '"' ?>;

        return httpGetAsync(urlToPersist,function () {
            addElementPersist();
        }, function () {
        });
    }

    function httpGetAsync(theUrl, callbackTrue,callbackFalse)
    {
        var ret = null;
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() {
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                ret = (xmlHttp.responseText === 'true');
                if(ret) {
                    callbackTrue();
                } else {
                    callbackFalse();
                }
            }
        }
        xmlHttp.open("GET", theUrl, true); // true for asynchronous
        xmlHttp.send(null);

    }
    
</script>