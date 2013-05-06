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

namespace Banana\Core;

use Banana\Template\Template as Template;
use Banana\Model as Model;

/**
 * The controller is the Key
 *
 * @author regis
 */
class Controller {
    protected $template;
    private $user;

    public function __construct() {
        if (array_key_exists('sessionid', $_COOKIE)) {
            $sess = new Model\SessionModel($_COOKIE['sessionid']);
        } else {
            $sess = new Model\SessionModel();
        }
        $this->template = new Template();
    }

}
