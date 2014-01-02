<?php
	
	//这里必须继承zend_db_table，否则就不是表模型
	class Item extends Zend_Db_Table  {
		
		protected $_name = 'item';
	}