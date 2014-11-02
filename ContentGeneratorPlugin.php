<?php
namespace Craft;

class ContentGeneratorPlugin extends BasePlugin
{
    function getName()
    {
         return Craft::t('Content Generator');
    }

    function getVersion()
    {
        return '1.0';
    }

    function getDeveloper()
    {
        return 'Moin Qidwai';
    }

    function getDeveloperUrl()
    {
        return 'http://moinqidwai.com';
    }

    function hasCpSection()
    {
        return true;
    }
}