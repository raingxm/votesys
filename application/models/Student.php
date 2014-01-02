<?php
	class Student extends Zend_Db_Table{
		
		protected $_name = 'student';	//这个表模型对应的表名
		protected $_primary = 'sid';
	}

?>