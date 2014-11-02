<?php
namespace Craft;

class ContentGenerator_SectionsService extends BaseApplicationComponent
{
    public function getSections()
    {
        return craft()->sections->getAllSections();
    }
    
}