<?php
/*
 * Banana : The PHP Framework that rocks
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

/** Empty class for type definition
 */
class BananaTemplateNotFound extends Exception {

}

/** Emtpy class for type definition
 */
class BananaTemplateNotDefined extends Exception {

}

/**
 * Description of template
 *
 * @author regis
 */
class BananaTemplate {

    var $content = null;
    var $templateFile = null;

    public function load($file) {
        foreach (BananaConfig::getInstance()->templatesDirectory as $templatesDir) {
            $file = $templatesDir . $file;
            if (file_exists($file)) {
                if (isset(BananaConfig::getInstance()->templateEngine)) {
                    $this->templateFile = $file;
                } else {
                    $this->content = file_get_contents($file);
                }
                return $this;
            }
        }

        throw new BananaTemplateNotFound("The template '$file' was not found");
    }

    public function render($context = []) {
        if ($this->content === null && $this->templateFile === null) {
            throw new BananaTemplateNotDefined();
        }

        if (isset(BananaConfig::getInstance()->templateEngine)) {
            return BananaConfig::getInstance()->templateEngine->render($this->templateFile, $context);
        }

        ob_start();
        extract($context);
        eval("?>$this->content");
        $buffer = ob_get_contents();
        ob_clean();
        return $buffer;
    }

}
