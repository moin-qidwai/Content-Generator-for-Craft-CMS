<?php
namespace Craft;

class ContentGenerator_EntriesService extends BaseApplicationComponent
{
    public function genEntries($sections)
    {
    	foreach ($sections as $sectiondata)
    	{
    		$section = craft()->sections->getSectionByHandle($sectiondata['handle']);
    		$amount = $sectiondata['amount'];

    		/* find a way to avoid looping through each time for every entry. just clone the entry somehow with different ID */

    		for ($j=0;$j<$amount;$j++)
    		{
    			$entrytypes = $section->getEntryTypes();
	    		foreach ($entrytypes as $entrytype)
	    		{
	    			$entry = new EntryModel();
	    			$entry->sectionId = $section->id;
	    			$entry->typeId     = $entrytype->id;
					$entry->enabled    = true;

					$fieldlayout = $entry->getFieldLayout();
					$fields = $fieldlayout->getFields();
					$attributes = array();
					$attributes['title'] = "This is a dummy entry";
					foreach ($fields as $fielddata)
					{
						$field = craft()->fields->getFieldById($fielddata->fieldId);
						if($field->type == "PlainText")
						{
							$attributes[$field->handle] = "This is some Plain text";
						}
						elseif($field->type == "RichText")
						{
							$attributes[$field->handle] = "This is some Rich text";
						}
						elseif($field->type == "Entries") /* give the user the choice of entry source and how many entries */
						{
							$count = 0;
							$indeces = array();
							for($i=0;$count<5;$i++)
							{
								$t = craft()->entries->getEntryById($i);
								if($t)
								{
									$count++;
									array_push($indeces, $t->id);
								}
									
							}
							$attributes[$field->handle] = $indeces;
						}
						elseif($field->type == "Assets") /* give the user choice of asset source */
						{
							$fileIds = array();
							foreach(craft()->assetSources->getAllSourceIds() as $source)
							{
								foreach(craft()->assets->getFilesBySourceId($source) as $file)
								{
									array_push($fileIds, $file->id);
								}
							}

							$attributes[$field->handle] = $fileIds;
						}
						elseif($field->type == "Categories") /* give the user choice of certain level restrictions */
						{
							$count = 0;
							$indeces = array();
							for($i=0;$count<5;$i++)
							{
								$t = craft()->categories->getCategoryById($i);
								if($t)
								{
									$count++;
									array_push($indeces, $t->id);
								}
									
							}
							$attributes[$field->handle] = $indeces;
						}
						elseif($field->type == "Checkboxes") /* give the user choice of random or some modulo (like even) */
						{
							$i = 0;
							$values = array();
							$options = $field->settings;
							$options = $options['options'];
							foreach($options as $setting)
							{
								if($i % 3 == 0)
									array_push($values, $setting['value']);
								$i++;
							}
							$attributes[$field->handle] = $values;
						}
						elseif($field->type == "Color") /* give the user the choice of color for all entries */
						{
							$attributes[$field->handle] = "#009ee8";
						}
						elseif($field->type == "Date") /* give the user choice of min and max dates */
						{
							$attributes[$field->handle] = "2014-08-14";
						}
						/* Give the user choice of specific option or random */
						elseif($field->type == "Dropdown" || $field->type == "MultiSelect"  || $field->type == "RadioButtons" )
						{
							$options = $field->settings;
							$options = $options['options'];
							$setting = $options[1];
							$value = $setting['value'];

							$attributes[$field->handle] = $value;
						}
						elseif($field->type == "Lightswitch") /* give the user choice of true or false */
						{
							$attributes[$field->handle] = true;
						}
						elseif($field->type == "Matrix") 
						{
							/* to be done in the end (using matrixblockmodel just like an entry type and entry model above) */
						}
						elseif($field->type == "Number") /* give the user the chocie to set a particular number or random */
						{
							$attributes[$field->handle] = 10;
						}
						elseif($field->type == "Table")
						{
							/* To be done after Matrix */
						}
						elseif($field->type == "Tags") /* give the user a choice of using predifiend tags or defining random new ones */
						{

							$count = 0;
							$indeces = array();
							for($i=0;$count<2;$i++)
							{
								$t = craft()->tags->getTagById($i, 0);
								if($t)
								{
									$count++;
									array_push($indeces, $t->id);
								}
									
							}
							$attributes[$field->handle] = $indeces;
						}
						elseif($field->type == "Users") /* give the user a choice to select some specific user or random */
						{
							$count = 0;
							$indeces = array();
							for($i=0;$count<1;$i++)
							{
								$t = craft()->users->getUserById($i);
								if($t)
								{
									$count++;
									array_push($indeces, $t->id);
								}
									
							}
							$attributes[$field->handle] = $indeces;
						}
					}

					$entry->getContent()->setAttributes($attributes);

					/* Do the same as above for the rest of the fields */

					$success = craft()->entries->saveEntry($entry);

					if (!$success)
					{
					    Craft::log('Couldn’t save the entry "'.$entry->title.'"', LogLevel::Error);
					}
					
	    		}
    		}
    		
    	}
    }
}