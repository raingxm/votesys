<?php

require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Item.php';
require_once APPLICATION_PATH.'/models/Filter.php';
/**
 * 
 * @author zhang
 *这个控制器专门用来管理后台
 */
class AdminController extends BaseController
{

    public function indexAction()
    {
        // action body
    }

    //进入到增加选项的页面
	public function additemuiAction()
	{
		
	}
	
	//完成一添加的任务
	public function additemAction()
	{
		//获取用户输入的内容
		
		$name = $this->getRequest()->getParam('name');
		
		if($name == ""){
			$this->view->info = '你的名字输入为空';
			$this->_forward('err','global');
			return ;
		}
		
		$description = $this->getRequest()->getParam('description');
		//$vote_count = $this->getRequest()->getParam('vote_count');
		
		$vote_count = !empty($_REQUEST['vote_count'])?$_REQUEST['vote_count']:0;
		
		//在服务器端对输入进行一个验证
		
		
		$data=array(
			'name'=>$name,
			'description'=>$description,
			'vote_count'=>$vote_count		
		);
		
		//创建一个表模型对象
		$itemModel = new Item();
		$itemModel->insert($data);
		
		$this->render('ok');
	}
	
	//跳转到增加过滤ip的页面
	public function addfilteripuiAction()
	{
		
	}
	
	//响应增加ip的请求
	public function addfilteripAction()
	{
		//获取用户输入ip是多少
		$ip = $this->getRequest()->getParam('ip');
	
		$filterModel = new Filter();
		
		//添加
		$data = array(
			'ip'=>$ip	
		);
		
		if($filterModel->insert($data) > 0){
			//成功，这里我们跳转到一个全局的视图(即所有控制器可以共享的视图)
			//下面这句话表示我们要跳转到GlobalController下的okAction方法
			//对应的视图
			$this->view->info = '增加过滤ip成功';
			$this->_forward('ok','global');
		}else{
			
			//跳转到失败页面
			$this->_forward('err','global');
		}
	}
	
	
}

