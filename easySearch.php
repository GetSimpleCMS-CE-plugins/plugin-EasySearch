<?php

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

i18n_merge('easySearch') || i18n_merge('easySearch', 'en_US');


# register plugin
register_plugin(
	$thisfile, //Plugin id
	'Easy Search', 	//Plugin name
	'1.0', 		//Plugin version
	'Multicolor',  //Plugin author
	'https://bit.ly/donate-multicolor-plugins', //author website
	'Freakin easy searchbar for your website', //Plugin description
	'plugins', //page type - on which admin tab to display
	'easySearchSettings'  //main function (administration)
);



#backend 
add_action('plugins-sidebar', 'createSideMenu', array($thisfile, i18n_r('easySearch/EASYSEARCHSETTINGS') . ' 🔎'));



#backend
function easySearchSettings()
{
	#logic for file if not exist;
	$dataFolder = GSDATAOTHERPATH . 'easySearch/';

	if (!file_exists($dataFolder . 'settings.json')) {

		mkdir($dataFolder, 0755);

		#structure file
		$settings = new stdClass();
		$settings->search_results_option = "all";
		$settings->search_results_name = "Search Results";
		$settings->search_readmore_name = "Read more...";
		$settings->search_placeholder_name = "Search on the site";
		$settings->button_placeholder_name = "Search";

		$json = json_encode($settings);
		file_put_contents($dataFolder . '.htaccess', 'Deny from all');
		file_put_contents($dataFolder . 'settings.json', $json);
	};

	#load json settings 

	$fileSet = file_get_contents($dataFolder . 'settings.json');
	$fileSetJson = json_decode($fileSet, false);

	require_once(GSPLUGINPATH . 'easySearch/form.php');
};



# functions
add_action('index-pretemplate', 'easySearchLogic');
function easySearchLogic()
{
	$dataFolder = GSDATAOTHERPATH . 'easySearch/';
	$fileSet = file_get_contents($dataFolder . 'settings.json');
	$fileSetJson = json_decode($fileSet, false);


	if (isset($_GET['submit'])) {
		require_once(GSPLUGINPATH . 'easySearch/function.php');
		$hereInfo = 0;
		$content = '';

		runSearch();
	};
}


# function for use on template
function easySearch()
{

	$readFile = file_get_contents(GSDATAOTHERPATH . 'easySearch/settings.json');
	$readFileJson = json_decode($readFile, false);

	echo '
<style>
.easyform{width:300px;display:grid;grid-template-columns:8fr 1fr;gap:5px}
</style>
<form method="GET" class="easyform"  >
<input type="text" placeholder="' . $readFileJson->search_placeholder_name . '" name="search">
<input type="submit" value="' . $readFileJson->button_placeholder_name . '" name="submit">
</form>';
}
