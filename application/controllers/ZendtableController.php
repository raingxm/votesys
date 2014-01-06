<?php

require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Student.php';
require_once APPLICATION_PATH.'/models/Course.php';
class ZendtableController extends BaseController
{

    public function testAction(){
    	
    	//这里...
    	
    	//显示前三个学生信息，按照年龄排序
//     	$where = '1=1';
//     	$order = 'sage';
//     	$count = 3;
//     	$offset = 0;
    	
//     	//创建表模型
//     	$studentModel = new Student();
//     	$res = $studentModel->fetchAll($where,$order,$count,$offset)->toArray();
    	
//     	print "<pre>";
//     	print_r($res);
//     	print "</pre>";
// 		exit();
		
// 		//*****显示计算机系前三个学生信息，按照年龄排序
// 		$where = "sdept='计算机系'";
// 		$order = 'sage';
// 		$count = 3;
// 		$offset = 0;
		 
		//创建表模型
// 		$studentModel = new Student();
// 		$res = $studentModel->fetchAll($where,$order,$count,$offset)->toArray();

// 		echo "<h1>显示计算机系前三个学生信息，按照年龄排序</h1>";
// 		print "<pre>";
// 		print_r($res);
// 		print "</pre>";
// 		exit();
		
    	$order = 'sage';
    	$count = 3;
    	$offset = 0;
    	
		//*****显示计算机系前三个学生信息，按照年龄排序(考虑sql注入问题)

		//创建表模型
		$studentModel = new Student();
		//创建数据库适配器
		$db = $studentModel->getAdapter();
		$where = $db->quoteInto("sdept=?", '计算机系');
		
		$res = $studentModel->fetchAll($where,$order,$count,$offset)->toArray();
		
		echo "<h1>显示计算机系前三个学生信息，按照年龄排序(考虑sql注入问题)</h1>";
		print "<pre>";
		print_r($res);
		print "</pre>";
		
		
		//*****显示计算机系并且是男生的前三个学生信息，按照年龄排序(考虑sql注入问题)
	
		//创建数据库适配器
		$db = $studentModel->getAdapter();
		//两个?的情况
		$where = $db->quoteInto("sdept=?", '计算机系').$db->quoteInto(" AND ssex=?", 'F');
	
		$res = $studentModel->fetchAll($where,$order,$count,$offset)->toArray();
		
		echo "<h1>显示计算机系并且是男生的前三个学生信息，按照年龄排序</h1>";
		print "<pre>";
		print_r($res);
		print "</pre>";
		
		//取出所有学生的名字和性别
		$db = $studentModel->getAdapter();
		//$sql = $db->quoteInto("select sname,ssex from student");
		
		$res = $db->query("select sname,ssex from student where ssex=:abc AND sdept=:ddd"
		,array(
			'abc'=>'F',
			'ddd'=>'计算机系'
		))->fetchAll();
		
		echo "<h1>取出所有学生的名字和性别</h1>";
		print "<pre>";
		print_r($res);
		print "</pre>";
		
		//如何增加、修改、删除某张表的记录
		
// 		echo "<h1>增加课程</h1>";
		
// 		$data = array(
// 			'cid'=>'55',
// 			'cname'=>'php编程',
// 			'ccredit'=>100			
// 		);
// 		$courseModel = new Course();
// 		$courseModel->insert($data);
		
// 		echo "<h1>修改课程学分 100->99 </h1>";
		
// 		$set = array(
// 			'ccredit'=>99
// 		);
// 		$where = "cid='55'";
		
// 		$courseModel->update($set, $where);

// 		echo "<h1>删除记录</h1>";
// 		$courseModel = new Course();
// 		$courseModel->delete("cid='55'");

		//查询学号为20040001这个学生
// 		echo "<h1>通过主键查找学生</h1>";
// 		//$stu = $studentModel->find('20040001')->toArray();
// 		$stu = $studentModel->find(array('20040001','20040003'))->toArray();
		
// 		print "<pre>";
// 		print_r($stu);
// 		print "</pre>";
		
		//如何只取回一条记录
		
// 		echo "<h1>取回一条记录</h1>";
// 		$stu = $studentModel->fetchRow("sdept='计算机系'")->toArray();
// 		print "<pre>";
// 		print_r($stu);
// 		print "</pre>";

		echo "<h1>distinct,我们一共有多少个系</h1>";
		$res = $db->query("select distinct sdept from student")->fetchAll();
		
		print "<pre>";
		print_r($res);
		print "共有".count($res)."个系";
	 	print "</pre>";
	 	
	 	echo "<h1>查询计算机系和外语系的学生信息</h1>";
	 	$res = $db->query("select * from student where sdept in ('外语系','计算机系')")->fetchAll();
	 	
	 	print "<pre>";
	 	print_r($res);
	 	print "共有".count($res)."个系";
	 	print "</pre>";
	 	
	 	
	 	echo "<h1>显示各个系的学生的平均年龄</h1>";
	 	$res = $db->query("select sdept,avg(sage) from student group by sdept")->fetchAll();
	 	 
	 	print "<pre>";
	 	print_r($res);
	 	print "</pre>";
	 	
	 	echo "<h1>显示人数大于3的系的名称</h1>";
	 	$res = $db->query("select sdept from student group by sdept having 
	 			count(sdept)>1")->fetchAll();
	 	
	 	print "<pre>";
	 	print_r($res);
	 	print "</pre>";
	 	
	 	echo "<h1>查询女生大于1的系的名称</h1>";
	 	$res = $db->query("select count(*) girls,sdept from student
	 			where ssex='F' group by sdept having girls>1")->fetchAll();
	 	 
	 	print "<pre>";
	 	print_r($res);
	 	print "</pre>";
	 	
	 	echo "<h1>查询计算机系有多少人</h1>";
	 	$res = $db->query("select count(*) num from student where sdept='计算机系'")->fetchAll();
	 	
	 	print "<pre>";
	 	print_r($res);
	 	print "</pre>";
	 	
	 	echo "<h1>查询总学分</h1>";
	 	$res = $db->query("select sum(grade) from studcourse")->fetchAll();
	 	 
	 	print "<pre>";
	 	print_r($res);
	 	print "</pre>";
	 	
	 	echo "<h1>查询选修11号课程的最高分和最低分</h1>";
	 	$res = $db->query("select max(grade),min(grade) from studcourse 
	 			where cid='11'")->fetchAll();
	 	 
	 	print "<pre>";
	 	print_r($res);
	 	print "</pre>";
	 	
	 	echo "<h1>显示各科考试不及格的学生姓名，科目和分数</h1>";
	 	$res = $db->query("select student.sname,course.cname,studcourse.grade from course,student,studcourse where 
	 			studcourse.sid=student.sid AND studcourse.cid=course.cid AND 
	 			studcourse.grade<60")->fetchAll();
	 	
	 	print "<pre>";
	 	print_r($res);
	 	print "</pre>";
	 	
	 	echo "<h1>计算各个科目不及格的学生数量</h1>";
	 	$res = $db->query("select count(*),course.cname from course,studcourse 
	 			where studcourse.grade<60 AND course.cid=studcourse.cid 
	 			group by studcourse.cid")->fetchAll();
	 	 
	 	print "<pre>";
	 	print_r($res);
	 	print "</pre>";
	 	
		exit();
		
    	$this->render('show');
    }

}

