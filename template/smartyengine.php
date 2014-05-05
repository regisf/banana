<?php
/*
 * Banana : The PHP Framework that tastes good
 * (c) Régis FLORET 2013 and Later
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 *  * The above copyright notice and this permission notice shall be included
 *    in all copies or substantial portions of the Software.
 *
 *  * The Software is provided "as is", without warranty of any kind, express
 *    or implied, including but not limited to the warranties of
 *    merchantability, fitness for a particular purpose and noninfringement. In
 *    no event shall the authors or copyright holders be liable for any claim,
 *    damages or other liability, whether in an action of contract, tort or
 *    otherwise, arising from, out of or in connection with the software or the
 *    use or other dealings in the Software.
 */

namespace Banana\Template;

use \Banana\Conf\Config;

include_once(BANANA_DIR . DIRECTORY_SEPARATOR . 'libs'. DIRECTORY_SEPARATOR .'smarty3' . DIRECTORY_SEPARATOR . 'Smarty.class.php');

/**
 * Exception when a named URL was not found
 */
class SmartyURLException extends \Exception  {}

/**
 * Smarty template engine support.
 */
class SmartyEngine implements ITemplateEngine {
    private $smarty;
    // Plugins are defined here. Don't forget the namespace
    private $helpers = [
        'url' => '\Banana\Template\get_url'
    ];

    /**
     * Constructor.
     * Create the smarty engine and install plugins, modifier, and manage configuration
     */
    public function __construct() {
        $this->smarty = new \Smarty();
        //$this->installPlugins();
        // TODO: Here cache stuff and directory stuff
	$this->smarty->setTemplateDir(Config::getInstance()->templatesDirectory);
    }

    /**
     * Install all plugins.
     * @todo Add plugins defined in configuration
     */
    private function installPlugins() {
        foreach($this->helpers as $key => $func) {
            $this->smarty->registerPlugin('function', $key, $func);
        }
    }

    /**
     * Render the template
     * @param String $templateFile The template file in the template directory
     * @param Array $contet The array for variable for the template
     * @return String The rendered page
     */
    public function render($templateFile, $context) {
	$this->smarty->assign($context);
	return $this->smarty->display($templateFile);
    }

    /**
     * Add a plugin dir
     */
    public function addPluginDir($dirName) {
	$this->smarty->addPluginsDir($dirName);
    }
}
