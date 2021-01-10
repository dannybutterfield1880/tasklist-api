<?php

namespace Core\Controller;

/**
 * Abstract controller containing common functionality
 */
abstract class BaseController {

    public function getRepository() {
        echo 'getting repo';
    }
}