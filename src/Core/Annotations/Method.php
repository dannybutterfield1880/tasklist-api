<?php

namespace Core\Annotations;

/**
 * @Annotation
 * @Target({"METHOD","PROPERTY"})
 */
class Method {

    /**
     * @var array $allowedMethods
     */
    public $allowedMethods;
}
