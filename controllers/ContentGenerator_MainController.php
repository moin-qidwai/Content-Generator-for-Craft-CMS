<?php
namespace Craft;

class ContentGenerator_MainController extends BaseController
{
    public function actionGenerateEntries()
    {

    	$g = $_POST['sect'];
    	$sections = array();
    	foreach ($g as $section) {
    		if($section['amount'])
    		array_push($sections, $section);
    	}
       $result = craft()->contentGenerator_entries->genEntries($sections);
       $this->returnJson($result);
    }
}
