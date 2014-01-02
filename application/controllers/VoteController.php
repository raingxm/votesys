<?php

require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Item.php';
require_once APPLICATION_PATH.'/models/VoteLog.php';
require_once APPLICATION_PATH.'/models/Filter.php';
/**
 * 
 * @author zhang
 *这个控制器专门处理投票的请求
 */
class VoteController extends BaseController
{

    public function voteAction()
    {
        //获得用户投票的id
        $item_id = $this->getRequest()->getParam('itemid');
        $ip = $this->getRequest()->getServer('REMOTE_ADDR');
        
        //看看这个ip是否被禁用
        $filterModel = new Filter();
        $filters = $filterModel->fetchAll("ip='$ip'")->toArray();
        if(count($filters) >= 1){
			
        	$this->view->info = '你被禁用了';
        	$this->_forward('err','global');
        	return ;
        }
        
        
        
        $today = date('Ymd');
        
        //先看看vote_log这个表中今天是否有投过一次
        $voteLogModel = new VoteLog();
        //先不考虑sql注入漏洞
        $where = "ip='$ip' AND vote_date=$today";
        
        $res = $voteLogModel->fetchAll($where)->toArray();

        
        if(count($res)>0){
        	
        	//如果今天已经投过票了，提示一句话
        	$this->render('error');
        	return ;
        }else{
        	
        	//更新item的vote_count，添加这个人投票的日志vote_log
        	$data = array(
        		'ip'=>$ip,
        		'vote_date'=>$today,
        		'item_id'=>$item_id	
        	);
        	if($voteLogModel->insert($data) >0){
        		
        		//更新vote_count
        		$itemModel = new Item();
        		
        		//通过主键直接获取对应的item
        		$item = $itemModel->find($item_id)->toArray();
        		$newvote_count = $item[0]['vote_count']+1;
        		
        		$set = array(
        			'vote_count'=>$newvote_count		
        		);
        		$where = "id=$item_id";
        		$itemModel->update($set, $where);
        	}
        	
        	$this->render('ok');
        }
        
    }

    
	
}

