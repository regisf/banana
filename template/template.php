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

use Banana\Conf\Config as Config;


/** Empty class for type definition
 */
class NotFound extends \Exception {}
class EngineNotSet extends \Exception {}


/**
 * Description of template
 *
 * @author regis
 */
class Template {
    var $templateFile = null;

    public function load($file) {
        foreach (Config::getInstance()->templatesDirectory as $templatesDir) {
            $file = $templatesDir . $file;
            if (file_exists($file)) {
                $this->templateFile = $file;
                return $this;
            }
        }

        throw new NotFound("The template '$file' was not found");
    }

    public function render($context = []) {
        if ($this->templateFile === null) {
            throw new \Banana\Template\NotDefined();
        }

        if (isset(Config::getInstance()->templateEngine)) {
            Config::getInstance()->templateEngine->render($this->templateFile, $context);
            return;
        }

        throw new EngineNotSet('The template engine is not set');
    }

}
