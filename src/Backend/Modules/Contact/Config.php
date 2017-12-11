<?php

namespace Backend\Modules\Contact;

use Backend\Core\Engine\Base\Config as BackendBaseConfig;
 
/**
 * This is the configuration-object for the Contact module
 *
 * @author Jacob van Dam <j.vandam@jvdict.nl>
 */
class Config extends BackendBaseConfig
{
    /**
     * The default action
     *
     * @var string
     */
    protected $defaultAction = 'Index';

    /**
     * The disabled actions
     *
     * @var array
     */
    protected $disabledActions = array();
}
