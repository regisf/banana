<?php

/*
 * Banana: The PHP framework that rocks
 * (c) Régis FLORET 2013
 *
 * {BSD licence}
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

    public function load($file) {
        foreach (BananaConfig::getInstance()->templatesDirectory as $templatesDir) {
            $file = $templatesDir . $file;
            if (file_exists($file)) {
                $this->content = file_get_contents($file);
                return $this;
            }
        }

        throw new BananaTemplateNotFound("The template '$file' was not found");
    }

    public function render($context = []) {
        if ($this->content === null) {
            throw new BananaTemplateNotDefined();
        }

        if (isset(BananaConfig::getInstance()->templateEngine)) {
            return BananaConfig::getInstance()->templateEngine->render($context);
        }
        $context['hello'] = 'Hello world';

        ob_start();
        extract($context);
        eval("?>$this->content");
        $buffer = ob_get_contents();
        ob_clean();
        return $buffer;
    }

}
