<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace tests\unit\Util;

use Magento\FunctionalTestingFramework\Test\Objects\ActionGroupObject;
use Magento\FunctionalTestingFramework\Test\Objects\ActionObject;

class ActionGroupObjectBuilder
{
    const DEFAULT_ACTION_OBJECT_NAME = 'action1';

    /**
     * Action Group Object Builder default name
     *
     * @var string
     */
    private $name = "testActionGroupObject";

    /**
     * Action Group Object Builder default action objects (set by constructor).
     *
     * @var array
     */
    private $actionObjects = [];

    /**
     * Action Group Object Builder default arguments.
     *
     * @var array
     */
    private $arguments = ['arg1' => 'data1'];

    /**
     * Setter for the Action Group Object name
     *
     * @param string $name
     * @return ActionGroupObjectBuilder
     */
    public function withName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Setter for the Action Group Object arguments
     *
     * @param array $args
     * @return ActionGroupObjectBuilder
     */
    public function withArguments($args)
    {
        $this->arguments = $args;
        return $this;
    }

    /**
     * Setter for the Action Group Object action objects
     *
     * @param array $actionObjs
     * @return ActionGroupObjectBuilder
     */
    public function withActionObjects($actionObjs)
    {
        $this->actionObjects = $actionObjs;
        return $this;
    }

    /**
     * ActionGroupObjectBuilder constructor.
     */
    public function __construct()
    {
        $this->actionObjects = [
            new ActionObject(self::DEFAULT_ACTION_OBJECT_NAME, 'testAction', ['userInput' => 'literal'])
        ];
    }

    /**
     * Function which takes builder parameters and returns a new ActionGroupObject.
     *
     * @return ActionGroupObject
     */
    public function build()
    {
        return new ActionGroupObject(
            $this->name,
            $this->arguments,
            $this->actionObjects
        );
    }
}
