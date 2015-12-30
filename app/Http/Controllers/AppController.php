<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Site;
use App\Variable;
use DB;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Cameras;

class AppController extends Controller
{	
	
	// Client side of the exhibit to display 'Coming Soon'
	// The route is /
	public function comingsoon() {
		return view('comingsoon');
	}
	
	// Client side of the exhibit
	// The route is /app, but could be swapped with comingsoon
	public function app() {
		return view('app');
	}
	
	
	// Used for development, and an easy way 
	// to try out new code / test in a web browser
	// The route /test runs this.
	public function test() {
/*
		// This is a test of manipulating timestamps in UTC v TZ mode
		$ts = 1439581500;
		echo Carbon::createFromTimeStamp($ts)->toDateTimeString(), "<br>";
		echo Carbon::createFromTimeStamp($ts)->timestamp, "<br>";
		echo Carbon::createFromTimeStamp($ts, 'America/Denver')->timestamp, "<br>";
		echo Carbon::createFromTimeStampUTC($ts)->toDateTimeString(), "<br>";
		echo Carbon::createFromTimeStampUTC($ts)->format('Y-m-d\TH:i:s'), "<br>";
*/

		// This is a test of parsing a remote file listing...
		// Get the remote directory listing
		$url = "http://data.iutahepscor.org/gamutphotos/UU_RB_KF_BA/";
		$html = file_get_contents($url);
		preg_match_all('/\/([^\/"]+\.jpg)/', $html, $uu);
		//preg_match_all('/\/(([0-9_]+)([A-Z_]+)([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+).jpg)/', $html, $uu);
		$files = $uu[1];
		print_r($files);
		
		if(!($li = array_search("1902_RB_KF_BA_2015_10_16_04_00_12.jpg", $files))) $li = -1;
		$li++;
		
		for(;$li < count($files); $li++) {
					echo "<br>" . $files[$li];
				}
	}
	
	// This is the JSON data source the server provides for the 
	// backbone.js client side code.
	// The route /pages gets this.
    public function pages() {
        // Enumerate all the pages
		// $pages = [$this->gsl(), $this->gamut(), $this->rbc(), $this->lr(), $this->pr(), $this->bio()];
		$pages = [$this->gsl(), $this->gamut(), $this->rbc()]; //, $this->bio()
		// Send back as JSON
		return response()->json($pages);
    }
    
    public function gsl() {
	    $page = [];
	    $page['type'] = "Photos";
	    $page['id'] = "gsl";
	    $page['img'] = "/img/bubbles/gsl.jpg";
	    $page['bubblescale'] = .25;
	    $page['name'] = "Explore the Great Salt Lake Watershed";
	    $page['text'] = [];
	    $page['text'][] = "The Great Salt Lake watershed is enormous&mdash;it covers nearly 35,000 square miles. Most of its water comes from three watersheds east of the Lake: Bear River, Weber River, and Jordan River watersheds. Each of these watersheds is fed by smaller watersheds. It’s a converging system of drainages all flowing to the Great Salt Lake.";
	    $page['topics'] = [
		    [
			    'name' => 'What is a watershed?',
			    'text' => ['A watershed is an area of land that drains into a particular stream, river, lake, or even an ocean. Wherever you are, you are in a watershed. Some watersheds are hilly; some are flat. Some are wild, while others are developed. Some watersheds are quite small, and some are huge. Large bodies of water are typically fed by many tributaries, and each tributary has its own watershed.'],
			    'default' => 0,
			    'photos' => [
				    [
					    'img' => '/img/gsl/1Watershed_0_GSL_v11_Roads.png',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ]
				]
		    ],
		    [
			    'name' => 'Watersheds are dynamic',
			    'text' => ['Every watershed is unique and change is ever present. Watershed boundaries and characteristics depend on interactions among the geology and topography of the region, climate, vegetation cover, habitats available for animals and other organisms, human impacts, and of course, the water cycle.'],
			    'default' => 0,
			    'photos' => [
				    [
					    'img' => '/img/gsl/wasatchback.jpg',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ],
				]
		    ],
		    [
			    'name' => 'Jordan River watershed',
			    'text' => ['Most of Salt Lake County falls within the boundaries of the Jordan River watershed, a 3,805 square mile basin. From its outlet at Utah Lake, the Jordan River flows north for 51 miles to the Great Salt Lake. Bounded by the Wasatch and Oquirrh Mountains, it meanders along the Salt Lake valley floor and is fed by seven tributary streams originating in the Wasatch Mountains.'],
			    'default' => 0,
			    'photos' => [
				    [
					    'img' => '/img/gsl/1Watershed_1c_Jordan_v12_Roads.png',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ]
				]
		    ],
		    [
			    'name' => 'Jordan River Tributaries',
			    'text' => ['Seven major tributaries feed the Jordan River in Salt Lake County: City Creek, Red Butte Creek, Emigration Creek, Parley’s Creek, Mill Creek, Big Cottonwood Creek and Little Cottonwood Creek. The high elevation watersheds of these seven tributaries are primarily uninhabited forest. In the Salt Lake Valley, the water passes through private land where residential, commercial, and industrial development have replaced vegetation and agriculture. Each of the tributaries is impacted by a variety of both natural and human impacts.'],
			    'default' => 0,
			    'photos' => [
				    [
					    'img' => '/img/gsl/1Watershed_2_SLValley_v12_LUCC.png',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ],
				    [
					    'img' => '/img/gsl/1Watershed_2_SLValley_v12_MajorRoads.png',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ],
				    [
					    'img' => '/img/gsl/1Watershed_2_SLValley_v12_Streams.png',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ],
				    [
					    'img' => '/img/gsl/1Watershed_2_SLValley_v13_Hwys.png',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ]
				]
		    ],
		    [
			    'name' => 'Red Butte Creek',
			    'text' => ['Look out the window and you’ll see the Bonneville Shoreline trail just in front of the Museum. Take a stroll heading north, and you’ll arrive at Red Butte Creek as it leaves Red Butte Garden and enters the built environment of Salt Lake City. Like the other Jordan River Tributaries, Red Butte Creek is a very different creek once it flows into the city.'],
			    'default' => 0,
			    'photos' => [
				    [
					    'img' => '/img/gsl/1Watershed_3_RBC_Oblique_v1.png',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ],
				    [
					    'img' => '/img/gsl/1Watershed_3_RBC_Oblique_v2.png',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ],
				    [
					    'img' => '/img/gsl/1Watershed_3_RBC_Oblique_v3.png',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ],
				    [
					    'img' => '/img/gsl/1950s.png',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ],
				    [
					    'img' => '/img/gsl/1950sleveled.png',
					    'label' => "",
					    'caption' => '',
					    'type' => 'hidden'
				    ]
				]
		    ]
	    ];
	    return $page;
    }
    
    public function gamut() {
	    $page = [];
	    $page['id'] = "gamut";
	    $page['img'] = "/img/bubbles/gamut.jpg";
	    $page['bubblescale'] = .22;
	    $page['name'] = "The Whole GAMUT";
	    $page['text'] = ["iUTAH Scientists and technicians have designed and installed a network of aquatic and climate monitoring stations along the Wasatch Front. Built to study water in “<strong>G</strong>radients <strong>A</strong>long <strong>M</strong>ountain-to-<strong>U</strong>rban <strong>T</strong>ransitions” (<strong>GAMUT</strong>) the network measures climate, hydrology, and water quality in three watersheds: Red Butte Creek, Logan River, and Provo River watersheds. Although alike in their primary source of water—winter snow—these three watersheds are very different in terms of human use of the land. GAMUT is providing baseline data to inform research about a wide range of issues related to water quality and quantity along the Wasatch Front."];
	    $page['type'] = "Photos";
	    $page['topics'] = [
		    [
			    'name' => 'Instruments',
			    'text' => ['Six aquatic stations along Red Butte Creek use state-of-the-art sensors to carry out real-time monitoring and reporting day in and day out.  Each station is solar powered and self-contained.'],
			    'default' => 0,
			    'photos' => [
				    [
					    'img' => '/img/gamut/RB_KF_BA.jpg',
					    'label' => "Knowlton Fork",
					    'caption' => 'This is the highest monitoring station on the creek: Knowlton Fork.',
					    'type' => 'polaroid'
				    ],
				    [
					    'img' => '/img/gamut/RB_ARBR_AA.jpg',
					    'label' => "Above Red Butte Reservoir",
					    'caption' => 'Above Red Butte Reservoir',
					    'type' => 'polaroid'
				    ],
				    [
					    'img' => '/img/gamut/RB_RBG_BA.jpg',
					    'label' => "Red Butte Gate",
					    'caption' => 'This is the site near the gate that prevents access to the Red Butte Creek protected area.',
					    'type' => 'polaroid'
				    ],
				    [
					    'img' => '/img/gamut/RB_CG_BA.jpg',
					    'label' => "Cottams Grove",
					    'caption' => 'Cottams Grove.',
					    'type' => 'polaroid'
				    ],
				    [
					    'img' => '/img/gamut/RB_FD_AA.jpg',
					    'label' => "Foothill Drive",
					    'caption' => 'Foothill Drive.',
					    'type' => 'polaroid'
				    ]
			    ]
		    ],
		    [
			    'name' => 'Solar Panel',
			    'text' => ['The sun generates power to run each station. A photovoltaic panel collects energy while the sun shines and stores it in a battery. This way, the system can run no matter the weather.'],
			    'default' => 0,
			    'photos' => [
				    [
					    'img' => '/img/gamut/solar.jpg',
					    'label' => '',
					    'caption' => '',
					    'type' => 'hidden'
				    ]
				]
		    ],
		    [
			    'name' => 'Datalogger',
			    'text' => ['A Campbell Scientific datalogger at the monitoring station collects data from each of the sensors, stores it, and transmits it to the computing center at Utah State University.'],
			    'default' => 0,
			    'photos' => [
				    [
					    'img' => '/img/gamut/datalogger.jpg',
					    'label' => '',
					    'caption' => '',
					    'type' => 'hidden'
				    ]
				]
		    ],
		    [
			    'name' => 'Multiparameter Water Quality Sonde',
			    'text' => ['This multi-port probe provides a state-of-the-art platform for the sensors used at each of the GAMUT water monitoring stations.  It is rugged, corrosion-resistant, and has a built in wiper to clear the sensors.'],
			    'default' => 0,
			    'background' => '/img/gamut/blur.png',
			    'photos' => [
				    [
					    'img' => '/img/gamut/sensors/sonde.png',
					    'label' => 'Sonde',
					    'caption' => '',
					    'type' => 'cutout'
				    ],
				    [
					    'img' => '/img/gamut/sensors/ph.png',
					    'label' => 'pH Sensor',
					    'caption' => 'Special glass in the pH sensor reacts with hydrogen ions in the water. This creates a small difference in voltage between the inside and outside of the bulb, which creates a weak electrical current—the more hydrogen ions in the water, the stronger the current.',
					    'type' => 'cutout'
				    ],
				    [
					    'img' => '/img/gamut/sensors/do.png',
					    'label' => 'Dissolved Oxygen Sensor',
					    'caption' => 'This sensor contains a specially dyed disk that reacts to a beam of blue light by emitting florescence&mdash;the more oxygen in the water, the faster the florescence fades away.',
					    'type' => 'cutout'
				    ],
				    [
					    'img' => '/img/gamut/sensors/alg.png',
					    'label' => 'Total Algae Sensor',
					    'caption' => 'Measuring the amount of algae and the number of algae species present in streams helps to assess water quality. Algae can become over-abundant when pollution from fertilizers, sediments and organic matter introduce too many nutrients into the water. When algae is too abundant, the biological balance of the stream becomes unbalanced causing oxygen levels to drop and fish and other organisms to die.',
					    'type' => 'cutout'
				    ],
				    [
					    'img' => '/img/gamut/sensors/sc.png',
					    'label' => 'Conductivity and Temperature Sensor',
					    'caption' => 'This sensor measures temperature as well as specific conductance. A weak electrical current moves through a hole in this probe. The saltier the water, the more readily the water conducts the current.',
					    'type' => 'cutout'
				    ],
				    [
					    'img' => '/img/gamut/sensors/p.png',
					    'label' => 'Pressure Transducer',
					    'caption' => 'The pressure transducer calculates how deep the water is based on how much pressure the water places on the sensor. Every 15 minutes the pressure transducer outputs an average of 25 measurements made in rapid succession.',
					    'type' => 'cutout'
				    ],
				    [
					    'img' => '/img/gamut/sensors/turb.png',
					    'label' => 'Turbidity Sensor',
					    'caption' => 'This sensor calculates turbidity by emitting light into the water and measuring how much is reflected back. Suspended soil, algae, and other particles make water murky and decrease the passage of light through it. ',
					    'type' => 'cutout'
				    ],
				    [
					    'img' => '/img/gamut/sensors/cdom.png',
					    'label' => 'CDOM Sensor',
					    'caption' => 'The effects of colored dissolved organic matter can be seen in both the color and clarity of water. Known as yellow substances, CDOM is the result of deteriorating organic materials and the tannins they release. Too much CDOM can impact biological activity by limiting light penetration into the water, limiting photosynthesis and negatively impacting plants and other organisms.',
					    'type' => 'cutout'
				    ]
				]
		    ]
	    ];
	    return $page;
    }

    public function lr() {
	    
	    $page = [];
	    $page['id'] = "lr";
	    $page['img'] = "/img/bubbles/lr.png";
	    $page['bubblescale'] = .24;
	    $page['name'] = "Logan River";
	    $page['text'] = ["Text explaining Logan River"];
	    $page['type'] = "Data";

	    $page['sites'] = $this->sites("LR_");
	    $page['variables'] = $this->variables();
	    $page['topics'] = $this->topics();
	    
	    $page['zoom'] = 11;
	    
	    return $page;
    }

    public function pr() {
	    
	    $page = [];
	    $page['id'] = "pr";
	    $page['img'] = "/img/bubbles/lr.png";
	    $page['bubblescale'] = .24;
	    $page['name'] = "Provo River";
	    $page['text'] = ["Text explaining Provo River"];
	    $page['type'] = "Data";

	    $page['sites'] = $this->sites("PR_");
	    $page['variables'] = $this->variables();
	    $page['topics'] = $this->topics();
	    
	    $page['zoom'] = 11;
	    
	    return $page;
    }
    
    public function rbc() {
	    
	    $page = [];
	    $page['id'] = "rbc";
	    $page['img'] = "/img/bubbles/rbc.jpg";
	    $page['bubblescale'] = .24;
	    $page['name'] = "Red Butte Creek";
	    $page['text'] = ["Red Butte Creek watershed, located in narrow Red Butte Canyon, covers just over 11 square miles. It ranges in elevation from approximately 4900 feet to nearly 7900 feet. Red Butte Canyon is a Research Natural Area (RNA), managed by the U.S. Forest Service to preserve its significant natural ecosystems for scientific education and research. It’s a place where natural processes can be observed and compared to other areas where people regularly impact natural systems. And it’s one of three streams where iUTAH is monitoring aquatic data around the clock."];
	    $page['type'] = "Data";

	    $page['sites'] = $this->sites("RB_");
	    $page['variables'] = $this->variables();
	    $page['topics'] = $this->topics();
	    $page['poi'] = [
		    [
			    "name" => "Natural History Museum of Utah",
			    "icon" => "img/logos/nhmu.svg",
			    "latitude" => 40.764131,
			    "longitude" => -111.82279
		    ]
	    ];
	    
	    $page['zoom'] = 13;
	    
	    return $page;
    }
    
    private function sites($like) {
	    $sites = Site::where('sitecode', 'LIKE', "%$like%")->get();	    
	   
		$cameras = Cameras::sites();
	   
	    foreach ($sites as $site) {
		    
		    // Cleanup site name
		    $remove = [' Basic Aquatic', ' Advanced Aquatic', 'Provo River at ', 'Provo River near ', 'Provo River Below ', 'Logan River at ', 'Logan River near '];
			foreach ($remove as $r) {
				$site['sitename'] = str_replace($r, '', $site['sitename']);
			}
		    
		    // Convert Lat/Lon to float
		    $site['latitude'] = floatval($site['latitude']);
		    $site['longitude'] = floatval($site['longitude']);
		    
		    // Check to see if site has a camera
		    $site['camera'] = false;
		    if(in_array($site['sitecode'], $cameras)) {
			    $site['camera'] = true;
		    }
		    
		    // Append array of series at site
		    $series = [];
		    foreach (DB::table('series')->select('variablecode')->where('sitecode', '=', $site->sitecode)->get() as $var) {
			    $series[] = $var->variablecode;
		    }
		    $site->series = $series;
		    
	    }
	    
	    return $sites;
    }
    
    private function variables() {
	    return Variable::get();
    }
    
    private function topics() {
	    return [
	    	// All Varaibles, one site
			[ 	'name' => 'Explore the Data',
				'text' => ["Explore what’s happening in Red Butte Creek’s aquatic system by sliding your finger across the data stream to the right.  Choose a monitoring station from the map to see all the data feeds from that location, or compare data from different locations. You can also look at individual variables to see how they change over time and across stations."],
				'variables' => ['WaterTemp_EXO', 'ODO', 'pH', 'SpCond', 'TurbMed', 'Stage', 'Level'],
				'mode' => 'ONE'
			],
			
			// Curated pairs
/*
			[
				'name' => 'Dissolved Oxygen and Temperature',
				'text' => [''],
				'variables' => ['ODO', 'WaterTemp_EXO'],
				'mode' => 'ONE'
			],
			[
				'name' => 'Turbidity and Water Level',
				'text' => [''],
				'variables' => ['TurbMed', 'Stage', 'Level'],
				'mode' => 'ONE'
			],
*/
			
			// Single Variables
			// These were selected because they are common among all sites
			[
				'name' => 'Water Temperature',
				'text' => ['Temperature impacts the kinds of organisms that can live in streams and rivers. Different species of fish, insects and other aquatic organisms have a preferred temperature range. When temperatures get too far above or below the acceptable range for a given species, their populations will decrease or be eliminated from the ecosystem.'],
			    'variables' => ['WaterTemp_EXO'],
			    'mode' => 'MANY'
		    ],
		    [
			    'name' => 'Dissolved Oxygen',
			    'text' => ['The concentration of oxygen gas incorporated in water is called dissolved Oxygen (DO). Oxygen is absorbed into water from the atmosphere; turbulence in the water increases this aeration.<br><br>
Water also absorbs oxygen released by aquatic plants as they photosynthesize. Dissolved oxygen is necessary for aquatic life, but too much can be a stressor for many organisms.'],
			    'variables' => ['ODO'],
			    'mode' => 'MANY'
		    ],
		    [
			    'name' => 'pH',
			    'text' => ['pH is a measure of how acidic or basic water is. Measured on a scale from 0 (acidic) to 14 (basic), a change of one unit corresponds to a tenfold change in acidity. Neutral water has a pH of 7. Stream water in the Red Butted Creek Watershed ranges between 7 and 9pH units.
<br><br>Most aquatic animals and plants have adapted a specific pH range, so a small change can cause big problems. Very acidic water will kill most fish and insects.
'],
			    'variables' => ['pH'],
			    'mode' => 'MANY'
		    ],
		    [
			    'name' => 'Specific Conductance',
			    'text' => ['The amount of dissolved solids, such as salt, determines the water’s specific conductance—a measure of the ability of water to conduct an electrical current. As water drains through soil, it dissolves salts and minerals increasing its specific conductance. Municipal and industrial uses may also introduce salts to water.<br><br>
The level of saltiness in water impacts cellular functions in aquatic plants and animals. This is an important water quality measure because high levels of salts can negatively impact the suitability of water for consumption by humans and animals, for agricultural use, and for industry. 
'],
			    'variables' => ['SpCond'],
			    'mode' => 'MANY'
		    ],
		    [
			    'name' => 'Turbitdity',
			    'text' => ['Turbidity is a measure of water clarity. Clear water has low turbidity and muddy water has high turbidity. Clay, silt, plant material, microorganisms, and industrial waste can all contribute to turbidity.<br><br>
Turbidity levels vary in streams as conditions change, and turbidity in turn can cause stream conditions to change. High stream flow can cause erosion, which brings more particulate matter into the water.'],
			    'variables' => ['TurbMed'],
			    'mode' => 'MANY'
		    ],
		    [
			    'name' => 'Gauge Height',
			    'text' => ['Water depth is measured with a pressure transducer. It measures the weight of the water above it, which increases with water depth. Together, water depth and stream velocity help us to determine stream flow.<br><br>
When stream flow is high, water can overflow into the stream’s floodplain. This can help to maintain a healthy riparian plant community while also filtering the water as it makes its way through the soil and back to the stream.'],
			    'variables' => ['Stage','Level'],
			    'mode' => 'MANY'
			]			
	    ];
    }
    
    public function bio() {
		$page = [];
	    $page['id'] = "bio";
	    $page['img'] = "/img/bubbles/bio.jpg";
	    $page['bubblescale'] = .21;
	    $page['name'] = "Biodiversity";
	    $page['text'] = ["Learn about the life in the creek. Learn about the life in the creek. Learn about the life in the creek. Learn about the life in the creek. Learn about the life in the creek. Learn about the life in the creek. Learn about the life in the creek. Learn about the life in the creek. Learn about the life in the creek. Learn about the life in the creek. Learn about the life in the creek. Learn about the life in the creek.  Learn about the life in the creek.  Learn about the life in the creek.  Learn about the life in the creek. "];
	    $page['type'] = "Photos";
	    $page['topics'] = [
			[
				'name' => 'River',
				'text' => ['Explore the life along Red Butte Creek. Explore the life along Red Butte Creek. Explore the life along Red Butte Creek. Explore the life along Red Butte Creek. Explore the life along Red Butte Creek. Explore the life along Red Butte Creek.'],
				'default' => '0',
			    'photos' => [
				    [
					 	'type' => 'photo',
					 	'img' => '/img/bio/bio.jpg',
					 	'label' => 'The Creek',
					 	'type' => 'hidden'
				    ],
				    [
					    'img' => '/img/bio/icons/fish.png',
					    'label' => 'Certain Trout',
					    'type' => 'icon'
				    ],
				    [
					    'img' => '/img/bio/icons/grass.png',
					    'label' => 'Particular Grass',
					    'type' => 'icon'
				    ],
				    [
					    'img' => '/img/bio/icons/flies.png',
					    'label' => 'Type of Fly',
					    'type' => 'icon'
				    ],
				    [
					    'img' => '/img/bio/icons/rodent.png',
					    'label' => 'Breed of Mouse',
					    'type' => 'icon'
				    ],
				    [
					    'img' => '/img/bio/icons/snakes.png',
					    'label' => 'Specific Snake',
					    'type' => 'icon'
				    ]
			    ]	
			],
		    [
			    'name' => 'Fish',
			    'text' => ['Small fish in a big pond.']
		    ],
		    [
			    'name' => 'Birds',
			    'text' => ['Birds of a feather...']
		    ],
		    [
			    'name' => 'Mammals',
			    'text' => ['Mammals Mammals Mammals!']
		    ],
		    [
			    'name' => 'Amphibians',
			    'text' => ["It's not easy being green."]
		    ],
		    [
			    'name' => 'Reptiles',
			    'text' => ["Snakes. Why'd it have to be snakes?"]
		    ],
		    [
			    'name' => 'Crustaceans',
			    'text' => ['Crusty?']
		    ],
		    [
			    'name' => 'Insects',
			    'text' => ['Lots of bugs!']
		    ],
		    [
			    'name' => 'Plants',
			    'text' => ['Lots of plants.']
		    ]
	    ];
	    return $page;
    }

}
