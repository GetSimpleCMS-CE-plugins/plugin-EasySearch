<style>
    .easySearchForm {
        background: #fafafa;
        border: solid 1px #ddd;
        padding: 10px;
        box-sizing: border-box;
    }

    .easySearchForm label {
        display: block;
        margin: 10px 0;
    }

    .easySearchForm input,
    select {
        width: 100%;
        padding: 10px;
        border: solid 1px #ddd;
        background-color: #fff;
    }

    .easySearchForm input[type="submit"] {
        background-color: #000;
        color: #fff;
        margin-top: 10px;
        width: auto;
        padding: 10px 20px;
    }

    .easySearchFormHowToUse {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: solid 1px #ddd;
        background-color: #fafafa;
    }

    .easySearchFormHowToUse code {
        border: solid 1px #ddd;
        padding: 5px 5px;
        margin: 2px;
        font-style: italic;
    }

    .easySearchFormHowToUse p {
        margin: 0;
    }
</style>

<h3>Easy Search Settings</h3>


<div class="easySearchFormHowToUse">
    <p><?php echo i18n_r('easySearch/JUSTPLACE');?> <code>&lt;?php easySearch();?&gt;</code> <?php echo i18n_r('easySearch/ONTEMPLATE');?></p>
</div>

<form class="easySearchForm" method="POST">

    <label for="">Search on:</label>
    <select name="searchon" id="">
        <option value="all"><?php echo i18n_r('easySearch/TITLEANDCONTENT');?></option>
        <option value="title"><?php echo i18n_r('easySearch/ONLYTITLES');?></option>
        <option value="content"><?php echo i18n_r('easySearch/ONLYCONTENT');?></option>
    </select>

    <script>
        document.querySelector('.easySearchForm select').value = "<?php echo $fileSetJson->search_results_option; ?>";
    </script>

    <label for=""><?php echo i18n_r('easySearch/SEARCHRESULTSNAME');?></label>
    <input type="text" name="searchResultsName" value="<?php echo $fileSetJson->search_results_name; ?>">

    <label for=""><?php echo i18n_r('easySearch/SEARCHREADMORENAME');?></label>
    <input type="text" name="searchReadMoreLink" value="<?php echo $fileSetJson->search_readmore_name; ?>">

    <label for=""><?php echo i18n_r('easySearch/SEARCHPLACEHOLDERNAME');?></label>
    <input type="text" name="searchPlaceholderName" value="<?php echo $fileSetJson->search_placeholder_name; ?>">

    <label for=""><?php echo i18n_r('easySearch/SEARCHBUTTONNAME');?></label>
    <input type="text" name="searchBtnName" value="<?php echo $fileSetJson->button_placeholder_name; ?>">



    <input type="submit" name="submit" value="<?php echo i18n_r('easySearch/SAVEOPTIONS');?>">
</form>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="box-sizing:border-box; display:grid; align-items:center;width:100%;grid-template-columns:1fr auto; padding:10px !important;background:#fafafa;border:solid 1px #ddd;margin-top:20px;">
    <p style="margin:0;padding:0;"><?php echo i18n_r('easySearch/PAYPAL');?></p>
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="KFZ9MCBUKB7GL">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" border="0">
    <img alt="" src="https://www.paypal.com/en_PL/i/scr/pixel.gif" width="1" height="1" border="0">
</form>


<?php

# runfunction after save

if (isset($_POST['submit'])) {
    $searchon = $_POST['searchon'];
    $searchResultsName = $_POST['searchResultsName'];
    $searchReadMoreLink = $_POST['searchReadMoreLink'];
    $searchPlaceholderName = $_POST['searchPlaceholderName'];
    $searchBtnName = $_POST['searchBtnName'];


    $settings = new stdClass();
    $settings->search_results_option = $searchon;
    $settings->search_results_name =   $searchResultsName;
    $settings->search_readmore_name =  $searchReadMoreLink;
    $settings->search_placeholder_name = $searchPlaceholderName;
    $settings->button_placeholder_name =  $searchBtnName;

    $json = json_encode($settings);
    file_put_contents($dataFolder . 'settings.json', $json);
    echo '<META HTTP-EQUIV="Refresh" Content="0">';
}; ?>