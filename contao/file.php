<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5.3
 * @copyright  Leo Feyer 2005-2012
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Backend
 * @license    LGPL
 */


/**
 * Initialize the system
 */
define('TL_MODE', 'BE');
require_once '../system/initialize.php';


/**
 * Class FilePicker
 *
 * Back end page picker.
 * @copyright  Leo Feyer 2005-2012
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class FilePicker extends Backend
{

	/**
	 * Current Ajax object
	 * @var object
	 */
	protected $objAjax;


	/**
	 * Initialize the controller
	 * 
	 * 1. Import the user
	 * 2. Call the parent constructor
	 * 3. Authenticate the user
	 * 4. Load the language files
	 * DO NOT CHANGE THIS ORDER!
	 */
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		parent::__construct();

		$this->User->authenticate();
		$this->loadLanguageFile('default');
	}


	/**
	 * Run the controller and parse the template
	 * @return void
	 */
	public function run()
	{
		$this->Template = new BackendTemplate('be_picker');
		$this->Template->main = '';

		// Ajax request
		if ($_POST && $this->Environment->isAjaxRequest)
		{
			$this->objAjax = new Ajax($this->Input->post('action'));
			$this->objAjax->executePreActions();
		}

		$strTable = $this->Input->get('table');
		$strField = $this->Input->get('field');

		$this->loadDataContainer($strTable);
		$objDca = new DC_Table($strTable);

		// AJAX request
		if ($_POST && $this->Environment->isAjaxRequest)
		{
			$this->objAjax->executePostActions($objDca);
		}

		$objFileTree = new $GLOBALS['BE_FFL']['fileSelector'](array(
			'strId'    => $strField,
			'strTable' => $strTable,
			'strField' => $strField,
			'strName'  => $strField,
			'varValue' => explode(',', $this->Input->get('value'))
		), $objDca);

		$this->Template->main = $objFileTree->generate();
		$this->Template->theme = $this->getTheme();
		$this->Template->base = $this->Environment->base;
		$this->Template->language = $GLOBALS['TL_LANGUAGE'];
		$this->Template->title = $GLOBALS['TL_CONFIG']['websiteTitle'];
		$this->Template->headline = $GLOBALS['TL_LANG']['MSC']['ppHeadline'];
		$this->Template->charset = $GLOBALS['TL_CONFIG']['characterSet'];
		$this->Template->options = $this->createPageList();
		$this->Template->expandNode = $GLOBALS['TL_LANG']['MSC']['expandNode'];
		$this->Template->collapseNode = $GLOBALS['TL_LANG']['MSC']['collapseNode'];
		$this->Template->loadingData = $GLOBALS['TL_LANG']['MSC']['loadingData'];
		$this->Template->search = $GLOBALS['TL_LANG']['MSC']['search'];
		$this->Template->action = ampersand($this->Environment->request);
		$this->Template->value = $this->Session->get('file_selector_search');

		$this->Template->output();
	}
}


/**
 * Instantiate the controller
 */
$objFilePicker = new FilePicker();
$objFilePicker->run();
