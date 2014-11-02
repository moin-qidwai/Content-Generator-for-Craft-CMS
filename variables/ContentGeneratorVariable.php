<?php
namespace Craft;

class ContentGeneratorVariable
{
    public function returnSections()
    {
        return craft()->contentGenerator_sections->getSections();
    }

    
}