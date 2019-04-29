<?php
namespace Admin\Model;
use Think\Model;

class AddressModel extends Model{
	protected $insertFields=array('shr_name','shr_province','shr_city','shr_area','shr_address','shr_tel');
	protected $updateFields=array('id','shr_name','shr_name','shr_city','shr_area','shr_address','shr_tel');
	//添加管理员验证规则

	protected $_validate=array(
		array('shr_name','require','收货人不能为空！'), 
		array('shr_province','require','配送省不能为空'), 
		array('shr_tel','require','联系电话不能为空'), 
		array('shr_city','require','配送城市不能为空'), 
		array('shr_area','require','配送地区不能为空'), 
		array('shr_address','require','配送地址不能为空'), 
		
	);

	protected function _before_insert(&$data,$option){
		//添加会员id至表单
		$mid=session('mid');
		$data['member_id']=$mid;
	}

}