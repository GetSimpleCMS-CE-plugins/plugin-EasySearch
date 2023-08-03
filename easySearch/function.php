<?php


#search only on title

function searchOnlyTitle($file, $limit, $link)
{
    global $hereInfo;
    global $SITEURL;
    global $content;
    $grabData = simplexml_load_file($file);
    $slug = pathinfo($file)['filename'];
    $getTitleSmall = strtolower($_GET['search']);
    $titleDataSmall = strtolower($grabData->title[0]);
    $titleData = $grabData->title[0];
    $contentData = $grabData->content[0];
    $contentDataSmall = strtolower($contentData);
    $finalExcerpt = implode(" ", array_slice(explode(" ", $contentData), 0, $limit));
    $finalExcerptStrip = strip_tags(html_entity_decode($finalExcerpt));


    $readFile = file_get_contents(GSDATAOTHERPATH . 'easySearch/settings.json');
    $readFileJson = json_decode($readFile, false);

    if (str_contains($titleDataSmall, $getTitleSmall)) {
        $content .= '<a href="' . $SITEURL . $slug . '"><h3>' . $titleData . '</h3></a><br>
<p>' . $finalExcerptStrip . ' [...]</p>
<a href="' . $link . $slug . '">' . $readFileJson->search_readmore_name . '</a>
<hr>';
        $hereInfo++;
    };
};



function searchOnlyContent($file, $limit, $link)
{
    global $hereInfo;
    global $SITEURL;
    global $content;
    $grabData = simplexml_load_file($file);
    $slug = pathinfo($file)['filename'];
    $getTitleSmall = strtolower($_GET['search']);
    $titleDataSmall = strtolower($grabData->title[0]);
    $titleData = $grabData->title[0];
    $contentData = $grabData->content[0];
    $contentDataSmall = strtolower($contentData);
    $finalExcerpt = implode(" ", array_slice(explode(" ", $contentData), 0, $limit));
    $finalExcerptStrip = strip_tags(html_entity_decode($finalExcerpt));


    $readFile = file_get_contents(GSDATAOTHERPATH . 'easySearch/settings.json');
    $readFileJson = json_decode($readFile, false);

    if (str_contains($contentDataSmall, $getTitleSmall)) {
        $content .= '<a href="' . $SITEURL . $slug . '"><h3>' . $titleData . '</h3></a><br>
<p>' . $finalExcerptStrip . ' [...]</p>
<a href="' . $link . $slug . '">' . $readFileJson->search_readmore_name . '</a>
<hr>';
        $hereInfo++;
    };
};


function searchAll($file, $limit, $link)
{

    $readFile = file_get_contents(GSDATAOTHERPATH . 'easySearch/settings.json');
    $readFileJson = json_decode($readFile, false);
    global $hereInfo;
    global $content;
    global $SITEURL;
    $grabData = simplexml_load_file($file);
    $slug = pathinfo($file)['filename'];
    $getTitleSmall = strtolower($_GET['search']);
    $titleDataSmall = strtolower($grabData->title[0]);
    $titleData = $grabData->title[0];
    $contentData = $grabData->content[0];
    $contentDataSmall = strtolower($contentData);

    $finalExcerpt = implode(" ", array_slice(explode(" ", $contentData), 0, $limit));
    $finalExcerptStrip = strip_tags(html_entity_decode($finalExcerpt));

    if (str_contains($titleDataSmall, $getTitleSmall) || str_contains($contentDataSmall, $getTitleSmall)) {
        $content .= '<a href="' . $SITEURL . $slug . '"><h3>' . $titleData . '</h3></a><br>
<p>' . $finalExcerptStrip . ' [...]</p>
<a href="' . $link . $slug . '">' . $readFileJson->search_readmore_name . '</a>
<hr>';
        $hereInfo++;
    };
};



#function after submit search form

function runSearch()
{
    global $content;
    global $title;
    global $SITEURL;
    global $hereInfo;

    $readFile = file_get_contents(GSDATAOTHERPATH . 'easySearch/settings.json');
    $readFileJson = json_decode($readFile, false);

    $title = $readFileJson->search_results_name;
    $files = glob(GSDATAPAGESPATH . '*.xml');
    $filesNM = glob(GSDATAPATH . 'posts/*.xml');
    $content = '';
    $limit = 60;

    foreach ($files as $file) {

        if ($readFileJson->search_results_option == 'title') {
            searchOnlyTitle($file, $limit, $SITEURL);
        } elseif ($readFileJson->search_results_option == 'content') {
            searchOnlyContent($file, $limit, $SITEURL);
        } elseif ($readFileJson->search_results_option == 'all') {
            searchAll($file, $limit, $SITEURL);
        };
    };

    if (file_exists(GSDATAPATH . 'posts/')) {

        foreach ($filesNM  as $file) {

            if ($readFileJson->search_results_option == 'title') {
                searchOnlyTitle($file, $limit, $SITEURL . '?post=');
            } elseif ($readFileJson->search_results_option == 'content') {
                searchOnlyContent($file, $limit, $SITEURL . '?post=');
            } elseif ($readFileJson->search_results_option == 'all') {
                searchAll($file, $limit, $SITEURL . '?post=');
            };
        };
    };

    if ($hereInfo == 0) {
        $content .=  i18n_r('easySearch/NORESULTS');
    };
};;
