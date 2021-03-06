<?php
namespace Kartenmacherei\RestFramework;

use Kartenmacherei\RestFramework\Router\RouterChain;

class Factory
{
    /**
     * @return RouterChain
     */
    public function createRouterChain(): RouterChain
    {
        return new RouterChain();
    }

    /**
     * @return ActionMapper
     */
    public function createActionMapper(): ActionMapper
    {
        return new ActionMapper();
    }
}
