<?php
/*
* This file is part of EC-CUBE
*
* Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
* http://www.lockon.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Plugin\RelatedProduct;

use Eccube\Common\Constant;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class Event
{
    /**
     * @var $app
     */
    private $app;

    /**
     * @var $legacyEvent
     */
    private $legacyEvent;

    /**
     * Event constructor.
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->legacyEvent = new EventLegacy($app);
    }

    // フロント：商品詳細画面に関連商品を表示
    /**
     * @param FilterResponseEvent $event
     */
    public function showRelatedProduct(FilterResponseEvent $event)
    {
        if ($this->supportNewHookPoint()) {
            return;
        }
        $this->legacyEvent->showRelatedProduct($event);
    }

    /**
     * new hookpoint for save related product
     * @param FilterResponseEvent $event
     */
    public function registerRelatedProduct(FilterResponseEvent $event)
    {
        if ($this->supportNewHookPoint()) {
            return;
        }
        $this->legacyEvent->registerRelatedProduct($event);
    }

    /**
     * new hookpoint for add RelatedProduct to product edit
     * @param FilterResponseEvent $event
     */
    public function addContentOnProductEdit(FilterResponseEvent $event)
    {
        if ($this->supportNewHookPoint()) {
            return;
        }
        $this->legacyEvent->addContentOnProductEdit($event);
    }

    // フロント：商品詳細画面に関連商品を表示
    /**
     * @param FilterResponseEvent $event
     */
    public function onProductDetailRender(FilterResponseEvent $event)
    {
        $this->legacyEvent->showRelatedProduct($event);
    }

    /**
     * new hookpoint for add RelatedProduct to product edit
     * @param FilterResponseEvent $event
     */
    public function onProductEditRender(FilterResponseEvent $event)
    {
        $this->legacyEvent->addContentOnProductEdit($event);
    }

    /**
     * new hookpoint for save related product
     * @param FilterResponseEvent $event
     */
    public function onProductEditRegister(FilterResponseEvent $event)
    {
        $this->legacyEvent->registerRelatedProduct($event);
    }

    /**
     * v3.0.9以降のフックポイントに対応しているのか
     *
     * @return bool
     */
    private function supportNewHookPoint()
    {
        return version_compare('3.0.9', Constant::VERSION, '<=');
    }

}