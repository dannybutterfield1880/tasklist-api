<?php

namespace Core\Controller;

/**
 * Abstract controller containing common functionality
 * 
 * Controller method naming convention excluding BaseController
 * 
 * methodClassAction() i.e ... loginAuthAction() / loadUserAction() / updateTasklistAction()
 */
abstract class BaseController {

    public function getRepository() {
        echo 'getting repo';
    }
}