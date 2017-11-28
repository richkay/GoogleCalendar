<?php

namespace Richkay\Gcalendar\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;


class HolidaysController extends Controller
{
    


	public function index()
	{
		
		return view('gc::holidays');
		
	}

	public function getHoliday(){

		$result = array();

		$client = new Client();

        $res = $client->request('GET', 
        	'https://www.googleapis.com/calendar/v3/calendars/id.indonesian%23holiday%40group.v.calendar.google.com/events?key='.Config("gcalendar.googleKey")
        );

        $datas = json_decode($res->getBody(),true);
        
        $dataItem = $datas['items'];

        $i = 0;
        foreach ($dataItem as $value) {

			if (
				
				date('yyyy-mm-dd',strtotime($value['start']['date'])) >= 
				date('yyyy-mm-dd',strtotime('2018-01-01')) 

				) 
			{

				$result[$i]['title'] = $value['summary'];
				$result[$i]['start'] = $value['start']['date'];
				$result[$i]['description'] = $value['start']['date'];
				$result[$i]['color'] = 'red';
				$result[$i]['textColor'] = '#FFF';
				$i++;
			}

			
		}

        return $result;
	}


}
