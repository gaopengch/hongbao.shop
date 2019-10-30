<?php


namespace Home\Controller;

//个人资料
class TrueNameController extends BaseController{
    //判断是否登录
     public function __construct()
    {
        parent::__construct();

        $this->isLogin();
    }


    //实名认证
    public function true_name(){
        $active = I('active');
        $this->assign('active',$active);
        $user_id = $_SESSION['user_id'];
        $data = M('true_name')->where(['user_id'=>$user_id])->find();
       $sf_data = M('sf_data')->select();
        $this->assign('data',$data);
        $this->assign('sf_data',$sf_data);
        $this->display();
    }

    public function save_true_name(){
        $data = I('post.');
        $user_id = $_SESSION['user_id'];
        $card_id = I('post.card_id');
        if(substr($card_id,14)%2 == 0){
            $data['sex'] = '女';
        }else{
            $data['sex'] = '男';
        }
        $true_name = M('true_name');
        $age = intval(date("Y")) - intval(substr($card_id,6,4));
       $data['age'] = $age;
        $data['user_id'] = intval($user_id);
        $id = $true_name->where(['user_id'=>$user_id])->getField('id');
        if($id){
            $true_name->where(['user_id'=>$user_id])->save($data);
        }else{
            $true_name->add($data);
        }
            $true_name->where("id= $id")->save(['stats'=>'1']);
            $this->success('添加成功',U('UserSet/security'));

    }

    public function addImg(){
        $img = $_FILES;
        if(($img["img"]["type"]=="image/png"||$img["img"]["type"]=="image/jpeg"||$img["img"]["type"]=="image/jpg")&&$img["img"]["size"]<1024000){
            $imgname = $img['img']['name'];
            $tmp = $img['img']['tmp_name'];
            $server = $_SERVER['DOCUMENT_ROOT'];
            $path2 = "/Uploads/idCard/".date('Y-m').'/';
            $path = $server.$path2;
            if(!file_exists($path)){
                mkdir($path);
            }
            $imgpath = $path.$imgname;
            move_uploaded_file($tmp,$imgpath);
            $this->ajaxReturnData($path2.$imgname,1);
        }
        $this->ajaxReturnData('',0,'操作失败');

    }

}
