<?php

require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Item.php';
class IndexController extends BaseController
{

    public function indexAction()
    {
        // action body
        //创建一个item表模型
        $itemModel = new Item();
        $items = $itemModel->fetchAll()->toArray();
        
        //把查询出来的结果分配给下一个视图
        $this->view->items = $items;
    }

}

