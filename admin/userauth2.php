<?php
if(!file_exists("../include/config.inc.php"))
{   
	header("location:/install/install.php");
}
require_once '../include/user.class.php';
session_start();

$uid = $_SESSION["adminid"];
$uid = (isset($uid) && is_numeric($uid)) ? $uid : 0;

$userdata = new User;
$adminuserinfo = $userdata->GetUser($uid);
if($adminuserinfo == null)
{
    exit("您没有权限执行管理,请<a href=\"login.php\">登录</a>!");    
}





function checkregular($rid)
{
    global $adminuserinfo;
    $userregular = explode("|",$adminuserinfo->regular);    
    if(in_array($rid,$userregular))
    {
        return true;
    }
    else
    {
        return false;
    }
}
?>