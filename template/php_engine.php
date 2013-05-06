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

/**
 * It seems a little bit weird to implement a PHP template engine with PHP itself
 * Here for consistency
 */
class PHP_Engine implements ITemplate_Engine {
    public function __construct() {
        foreach(\Banana\Conf\Config::getInstance()->templatesDirectory as $dir) {
            set_include_path($dir);
        }
    }

    /**
     * Render the template
     * @param String $templateFile The template file in the template directory
     * @param Array $contet The array for variable for the template
     * @return String The rendered page
     */
	public function render($templateFile, $context) {
        $content = file_get_contents($templateFile);
        ob_start();
        extract($context);
        eval("?>$content");
        $buffer = ob_get_contents();
        ob_clean();
        echo $buffer;
    }

}

