<?php

/*
 * Banana: The PHP framework that rocks
 * (c) Régis FLORET 2013
 * 
 * {BSD licence}
 */

/**
 * The controller is the Key
 *
 * @author regis
 */
class BananaController {

    protected $template;

    public function __construct() {
        $this->template = new BananaTemplate();
    }

}
