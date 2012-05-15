<?php
//表单数据验证类

/*php自身的检测函数
*bool is_numeric ( mixed var)
*bool is_bool ( mixed var)
*bool is_null ( mixed var)
*bool is_float ( mixed var)
*bool is_int ( mixed var)
*bool is_string ( mixed var)
*bool is_object ( mixed var)
*bool is_array ( mixed var)
*bool is_scalar ( mixed var)
*string gettype ( mixed var)
*/

/*新添加的检测函数
isDate()       日期检查
isTime()       时间检查
isInt()          整数检查
isNum()        数字检查
isEmail()      邮件检查
isUrl()          url检查
isPost()        邮政编码检查
isPhone()     电话号码检查
isMobile()    移动电话检查
isLen()         长度检查
isIdCard()   身份证检查
isEnglish()   英文检查
isGB2312()  简体中文检查
isIP()           IP检查
isQQ()         QQ检查
checkFileType() 文件后缀名检查
*/
class class_validator
{
   function class_validator()
   {
    
   }

    /*
         *方法：bool isDate($str,$format="")
         *作用：检验日期的合法性
         *说明：默认的合法日期格式是以"-"分割的"年-月-日"
         *         当参数$format设置格式时则按照这个格式检验
         *例子：isDate("2006-12-1");isDate("2006-12-1","Y-m-d h:i:s")
         */
    function isDate($str,$format="")
	{
        if($format=="")
		{
            $str=explode("-",$str);
            return @checkdate($str[1],$str[2],$str[0]);
        }
		else
		{
            //按规定的格式检验
            $unixTime=strtotime($str);//转为时间戳
            $checkDate= date($format,$unixTime);
            if($checkDate==$str)
			{
			    return true;
			}
			else
			{
			    return false;
			}
        }
    }
    
    //时间检查
    function isTime($str,$format="")
	{
        if(!$format)
		{
            $str=explode(":",$str);
            if(count($str)!=3) return false;
            for($i=0;$i<=2;$i++)
			{
                //echo $str[$i];
                if(!@preg_match("/^[0-9]{1,2}$/",$str[$i])) return false;
                //数字要小于或等于59
                if($str[$i]>59) return false;
                //小时要<24
                if($str[0]>=24) return false;
            }
        }
		else
		{
            //按规定的格式检验
            $unixTime=strtotime($str);//转为时间戳
            $checkDate=date($format,$unixTime);
            if($checkDate!=$str) return false;
        }
        return true;
    }
	
    //验证表单数据是否是整数(用is_int()验证不了的)
    //前面可以加上可选的符号（- 或者 +）
    function isInt($str)
	{
        $pattern="/^[-|+]?(([0-9]{1})|([1-9]{1}[0-9]+))$/";
        if(@preg_match($pattern,$str))
		{
		    return true;
		}
        return false;
    }
	
    //验证是否由数字组成,is_numeric()验证包括整数和浮点数
    function isNum($str,$pattern="")
	{
        if($pattern)
		{
            return @preg_match($pattern,$str);
        }
		else
		{
            $pattern="/^\d+$/";
            return @preg_match($pattern,$str);
        }
    }

    function isFloat()
	{
	}
	
    //email检测
    function isEmail($str)
	{
        $pattern="/^[_0-9a-z]+@[0-9a-z-]+(\.[0-9a-z-]+)*\.[a-z]+$/i";
        if(@preg_match($pattern,$str)){return true;}
        return false;
    }
	
    //URL检测，只检查http形式
    function isUrl($str,$pattern="")
	{
        if($pattern)
		{
            if(@preg_match($pattern,$str)){return true;}
        }
		else
		{
            $pattern="/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"])*$/";
            if(@preg_match($pattern,$str)){return true;}
        }
        return false;
    }

    //邮政编码,中国邮政编码是6位数字组成
    function isPost($str,$pattern="")
	{
        if($pattern)
		{
           if(@preg_match($pattern,$str)){return true;}
        }
		else
		{
           if(@preg_match("/^\d{6}$/",$str)){return true;}
        }
        return false;
    }
	
    //电话号码 区号-号码 或 号码 或区号号码
    //0751-8120917||07518120917||8120917
    function isPhone($str,$pattern="")
	{
        if($pattern)
		{
            if(@preg_match($pattern,$str)){return true;}
        }
		else
		{
            $pattern="/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/";
            if(@preg_match($pattern,$str)){return true;}
        }
        return false;
    }
	
    //手机号码区号-号码 或 号码 或区号号码
    function isMobile($str,$pattern="")
	{
       if($pattern)
	    {
            if(@preg_match($pattern,$str)){return true;}
        }
		else
		{
            $pattern="/^((\(\d{3}\))|(\d{3}\-))?13\d{9}$/";
            if(@preg_match($pattern,$str)){return true;}
        }
        return false;
    }

    //字符串长度是否在l1和l2之间,即l1<$str<l2
    function isLen($str,$l1,$l2)
	{
       if(strlen($str)>$l1&&strlen($str)<$l2){return true;}
       return false;
    }
	
    //身份证号码
    //可以验证15和18位的身份证号码
    function isIdCard($str)
	{
	    //前两位的省级代码
        $pro=array("11","12","13","14","15","21","22","23","31","32","33","34","35","36","37","41","42","43","44","45","46","50","51","52","53","54","61","62","63","64","65","71","81","82","91");
        //验证前两位
	    if(!in_array(substr($str,0,2),$pro))return false;
        if(strlen($str)==15)
		{
            if(!@preg_match("/^\d+$/",$str))return false;
            //检查年-月-日（年前面加19）
            return @checkdate(substr($str,8,2),substr($str,10,2),"19".substr($str,6,2));
        }
        if(strlen($str)==18)
		{
		    //前17位是否是数字
            if(!@preg_match("/^\d+$/",substr($str,0,17)))return false;
            //检查年-月-日
            if(!@checkdate(substr($str,10,2),substr($str,12,2),substr($str,6,4)))return false;
            //加权因子Wi=2^（i-1）(mod 11)计算得出
            $Wi_arr=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2,1);
            //校验码对应值
            $VN_arr=array(1,0,'x',9,8,7,6,5,4,3,2);
            //计算校验码总值(计算前17位的，最后一位为校验码)
            for($i=0;$i<strlen($str)-1;$i++)
			{
                $t+=substr($str,$i,1) * $Wi_arr[$i];
            }
            //得到校验码
            $VN=$VN_arr[($t % 11)];
            //判断最后一位的校验码
            if($VN==substr($str,-1)){return true;}else{return false;}
        }
        return false;
    }
	
    //字符串是否全部是英文
    function isEnglish($str)
	{
        $pattern="/^[a-z]+$/i";
        if(@preg_match($pattern,$str)){return true;}
        return false;
    }
	
    //是否是简体中文
    function isGB2312($str,$pattern="")
	{
        if($pattern)
		{
           if(@preg_match($pattern,$str)){return true;}
        }
		else
		{
            $pattern="/^[".chr(0xa1)."-".chr(0xff)."]+$/";
            if(preg_match($pattern,$str)){return true;}
        }
        return false;
    }
	
    //是否是繁体中文
    function isBIG5()
	{
	}
	
    //是否GBK
    function isGBK()
	{
	}
	
    //是否是ip
    function isIP($str)
	{
        $s=explode(".",$str);
        if(count($s)!=4) return false;
        foreach($s as $v)
		{
            if(!is_numeric($v)) return false;
            //if(!is_int($v)) return false;
            //不用检查是否带小数,因为小数带小数点"."
            //正则检测是否存在192.168.01.02 以0开头的小数
            if(preg_match("/^0[0-9]+$/",$v)) return false;
            if($v<0 || $v>255) return false;
        }
        return false;
    }
	
    //是否是QQ 5-10位
    function isQQ($str,$pattern="")
	{
        if($pattern){
        if(@preg_match($pattern,$str)){return true;}
        }
		else
		{
            $pattern="/^[1-9]\d{4,9}$/";
            if(@preg_match($pattern,$str)){return true;}
        }
        return false;
    }
	
    //检查文件的扩展名是否符合,$filetype可以是字符串或数组,而且传递的数据要全部为小写
    //使用1:checkFileType("gif|rar|jpeg|jpg","lsflkjs.jpeg") return true
    //使用2:checkFileType(array("rar","bmp","gif"),"lsflkjs.jpeg") return false
    function checkFileType($filetype,$file)
	{
        $f=(is_array($filetype))?$filetype:explode("|",$filetype);
        $n=strrchr($file,'.');//截取字符串，找不到则返回""
        $n=(!$n)?"":strtolower(substr($n,1));
        //in_array(),是区分大小写的
        return in_array($n,$f);
    }
	
    //判断是否在字符串中出现某些字符
    function isInStr($str1,$str2)
	{
	}

    //检查数据提交，有post,get两种方式，是否所有都不为空
    //注意:检测不了多选项.没有使用trim()去掉首尾空格
    function checkRequest($post_or_get,$emptyitems="")
    {
        if(!is_array($post_or_get)){return false;}
        if(count($post_or_get)==0){return false;}
        $items=explode("|",$emptyitems);
        foreach($post_or_get as $key=>$value)
		{
            if($_REQUEST[$key]=="")
			{
                if(in_array($key,$items)){continue;}else{return false;}
            }
        }
         return true;
    }
	
    //显示所有接收到的数据列表
    function showRequest($_request,$leftnum,$post_or_get="\$_POST")
    {
        if(!$this->isInt($leftnum) || !$_request)return false;
        if(!is_array($_request)){echo $_request;return;}
        foreach($_request as $key=>$value)
		{
            $str="\$".$key;
            if($leftnum>strlen($key))
			{
                for($i=0;$i<=$leftnum-strlen($key);$i++){$str.="&nbsp;";}
            }
            $str.="=&nbsp;&nbsp;".$post_or_get."['".$key."']";
            if(is_array($_REQUEST[$key])) $str.="&nbsp;&nbsp;<b>数组</b>";
             echo $str."\n";
        }
    }

    //每个类都带有一个o($info) 输出(output)函数
     function o($info="")
	 {
        $cssstyle="style=\"";
        $cssstyle.="font:bold 12px 150%,'Arial';border:1px solid #CC3366;";
        $cssstyle.="width:50%;color:#990066;padding:2px;\"";
        $str="\n<ul ".$cssstyle."><li>".$info."</li></ul>\n";
        echo $str;
    }
	
    //每个类都带有一个showInfo($info,$type) 输出函数
    function showInfo($info,$type=0,$url="")
	{
        switch($type){
        case 0:$this->o($info);break;
        case 1:echo "<script>alert(".chr(34).str_replace("\"","\\\"",$info).chr(34).");</script>";break;
        case 2:if($url==""){$this->o("showInfo(\$info,\$type=0,\$url=\"\") 错误:需要\$url参数");break;} echo "<script>location.href='$url';</script>";break;
        case 3:echo "<script>history.go(-1);</script>";
        case 4:header("Location:$url");break;
        case 5:$this->showInfo($info,1);$this->showInfo("",3);
        case 6:$this->showInfo($info,1);$this->showInfo("",2,$url);
        default:$this->o($info);
   }
}
}
?>