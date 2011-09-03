<?php
/* SVN FILE: $Id$ */

/**
 * Methods for displaying presentation data
 *
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright (c) 2005, Cake Software Foundation, Inc.
 *                     1785 E. Sahara Avenue, Suite 490-204
 *                     Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright    Copyright (c) 2005, Cake Software Foundation, Inc.
 * @link         http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @version      1.0.0.7
 * @package      cake
 * @subpackage   cake.app.views
 * @since        CakePHP v 0.10.4.1693
 * @version      $Revision$
 * @modifiedby   $LastChangedBy$
 * @lastmodified $Date$
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * update: 10/03/07 by tclineks

/**
 * Include Smarty. By default expects it at ( VENDORS.'smarty'.DS.'Smarty.class.php' )
 * vendor('smarty'.DS.'Smarty.class') has been depreciated
 * use App::import('Vendor', 'Smarty', array('file' => 'smarty'.DS.'Smarty.class.php'))
 */
App::import('Vendor', 'Smarty', array('file' => 'smarty'.DS.'Smarty.class.php'));
/**
 * CakePHP Smarty view class
 *
 * This class will allow using Smarty with CakePHP
 *
 * @version      1.0.0.7
 * @package      cake
 * @subpackage   cake.app.views
 * @since        CakePHP v 0.10.0.1693
 */
class SmartyView extends View
{
/**
 * SmartyView constructor
 *
 * @param  $controller instance of calling controller
 */
	function __construct (&$controller)
	{
		parent::__construct($controller);
		$this->Smarty = &new Smarty();
		// requires views be in a 'smarty' subdirectory, you can remove this limitation if you aren't using other inherited views that use .tpl as the extension
		//$this->subDir = 'smarty'.DS;		
		$this->ext= '.tpl';
		$this->Smarty->plugins_dir[] = VIEWS.'smarty_plugins'.DS;
		$this->Smarty->compile_dir = TMP.'smarty'.DS.'compile'.DS;
		$this->Smarty->cache_dir = TMP.'smarty'.DS.'cache'.DS;
		$this->Smarty->template_dir = VIEWS.DS;
		$this->Smarty->cache=true;
		$this->Smarty->config_dir = 'config';
		$this->Smarty->allow_php_tag = true;
	}

/**
 * Overrides the View::_render()
 * Sets variables used in CakePHP to Smarty variables
 *
 * @param string $___viewFn
 * @param string $___data_for_view
 * @param string $___play_safe
 * @param string $loadHelpers
 * @return rendered views
 */
	function _render($___viewFn, $___data_for_view, $___play_safe = true, $loadHelpers = true)
	{
		if ($this->helpers != false && $loadHelpers === true)
		{
			$loadedHelpers =  array();
			$loadedHelpers = $this->_loadHelpers($loadedHelpers, $this->helpers);

			foreach(array_keys($loadedHelpers) as $helper)
			{
				$replace = strtolower(substr($helper, 0, 1));
				$camelBackedHelper = preg_replace('/\\w/', $replace, $helper, 1);

				${$camelBackedHelper} =& $loadedHelpers[$helper];
				if(isset(${$camelBackedHelper}->helpers) && is_array(${$camelBackedHelper}->helpers))
				{
					foreach(${$camelBackedHelper}->helpers as $subHelper)
					{
						${$camelBackedHelper}->{$subHelper} =& $loadedHelpers[$subHelper];
					}
				}
				$this->loaded[$camelBackedHelper] = (${$camelBackedHelper});
				//$this->Smarty->assign_by_ref($camelBackedHelper, ${$camelBackedHelper});
				$this->Smarty->assignByRef($camelBackedHelper, ${$camelBackedHelper});
			}
		}

		$this->register_functions();

		foreach($___data_for_view as $data => $value)
		{
			if(!is_object($data))
			{
				$this->Smarty->assign($data, $value);
			}
		}
		//$this->Smarty->assign_by_ref('view', $this);
		$this->Smarty->assignByRef('view', $this);
		return $this->Smarty->fetch($___viewFn);
	}
	
/**
 * Returns layout filename for this template as a string.
 *
 * @return string Filename for layout file (.ctp).
 * @access private
 */
	function _getLayoutFileName() {
		if (isset($this->webservices) && !is_null($this->webservices)) {
			$type = strtolower($this->webservices) . DS;
		} else {
			$type = null;
		}

		if (isset($this->plugin) && !is_null($this->plugin)) {
			if (file_exists(APP . 'plugins' . DS . $this->plugin . DS . 'views' . DS . 'layouts' . DS . $this->layout . $this->ext)) {
				$layoutFileName = APP . 'plugins' . DS . $this->plugin . DS . 'views' . DS . 'layouts' . DS . $this->layout . $this->ext;
				return $layoutFileName;
			}
		}
        $paths = App::path('views'); 

        foreach($paths as $path) { 
            if (file_exists($path . 'layouts' . DS . $this->subDir . $type . $this->layout . $this->ext)) { 
                $layoutFileName = $path . 'layouts' . DS . $this->subDir . $type . $this->layout . $this->ext; 
                return $layoutFileName; 
            } 
        } 

        // added for .ctp viewPath fallback 
        foreach($paths as $path) { 
            if (file_exists($path . 'layouts' . DS  . $type . $this->layout . '.ctp')) { 
                $layoutFileName = $path . 'layouts' . DS . $type . $this->layout . '.ctp';
                return $layoutFileName; 
            } 
        }

		if($layoutFileName = fileExistsInPath(LIBS . 'view' . DS . 'templates' . DS . 'layouts' . DS . $type . $this->layout . '.ctp')) {
		} else {
			$layoutFileName = LAYOUTS . $type . $this->layout.$this->ext;
		}
		return $layoutFileName;
	}

/**
 * Returns filename of given action's template file (.tpl) as a string. CamelCased action names will be under_scored! This means that you can have LongActionNames that refer to long_action_names.ctp views.
 *  - added: will also return .ctp templates in viewPath paths for fallback
 *
 * @param string $action Controller action to find template filename for
 * @return string Template filename
 * @access private
 */
	function _getViewFileName($action) {
		$action = Inflector::underscore($action);
		$paths = App::path('views');

		if (isset($this->webservices) && !is_null($this->webservices)){
			$type = strtolower($this->webservices) . DS;
		} else {
			$type = null;
		}

		if (empty($action)) {
			$action = $this->action;
		}

		$position = strpos($action, '..');

		if ($position === false) {
		} else {
			$action = explode('/', $action);
			$i = array_search('..', $action);
			unset($action[$i - 1]);
			unset($action[$i]);
			$action='..' . DS . implode(DS, $action);
		}

		foreach($paths as $path) {
			if (file_exists($path . $this->viewPath . DS . $this->subDir . $type . $action . $this->ext)) {
				$viewFileName = $path . $this->viewPath . DS . $this->subDir . $type . $action . $this->ext;
				return $viewFileName;
			}
		}

		// added for .ctp viewPath fallback
		foreach($paths as $path) {
			if (file_exists($path . $this->viewPath . DS . $type . $action . '.ctp')) {
				$viewFileName = $path . $this->viewPath . DS . $type . $action . '.ctp';
				return $viewFileName;
			}
		}

		if ($viewFileName = fileExistsInPath(LIBS . 'view' . DS . 'templates' . DS . 'errors' . DS . $type . $action . '.ctp')) {
		} elseif($viewFileName = fileExistsInPath(LIBS . 'view' . DS . 'templates' . DS . $this->viewPath . DS . $type . $action . '.ctp')) {
		} else {
			$viewFileName = VIEWS . $this->viewPath . DS . $this->subDir . $type . $action . $this->ext;
		}

		return $viewFileName;
	}

	/**
	 * checks for existence of special method on loaded helpers, invoking it if it exists
	 * this allows helpers to register smarty functions, modifiers, blocks, etc.
	 */
	function register_functions() {
		foreach(array_keys($this->loaded) as $helper) {
			if (method_exists($this->loaded[$helper], '_register_smarty_functions')) {
				$this->loaded[$helper]->_register_smarty_functions($this->Smarty);
			}
		}
	}
}
?>
