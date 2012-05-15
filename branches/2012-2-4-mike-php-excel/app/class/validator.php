<?php
//��������֤��

/*php����ļ�⺯��
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

/*����ӵļ�⺯��
isDate()       ���ڼ��
isTime()       ʱ����
isInt()          �������
isNum()        ���ּ��
isEmail()      �ʼ����
isUrl()          url���
isPost()        ����������
isPhone()     �绰������
isMobile()    �ƶ��绰���
isLen()         ���ȼ��
isIdCard()   ���֤���
isEnglish()   Ӣ�ļ��
isGB2312()  �������ļ��
isIP()           IP���
isQQ()         QQ���
checkFileType() �ļ���׺�����
*/
class class_validator
{
   function class_validator()
   {
    
   }

    /*
         *������bool isDate($str,$format="")
         *���ã��������ڵĺϷ���
         *˵����Ĭ�ϵĺϷ����ڸ�ʽ����"-"�ָ��"��-��-��"
         *         ������$format���ø�ʽʱ���������ʽ����
         *���ӣ�isDate("2006-12-1");isDate("2006-12-1","Y-m-d h:i:s")
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
            //���涨�ĸ�ʽ����
            $unixTime=strtotime($str);//תΪʱ���
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
    
    //ʱ����
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
                //����ҪС�ڻ����59
                if($str[$i]>59) return false;
                //СʱҪ<24
                if($str[0]>=24) return false;
            }
        }
		else
		{
            //���涨�ĸ�ʽ����
            $unixTime=strtotime($str);//תΪʱ���
            $checkDate=date($format,$unixTime);
            if($checkDate!=$str) return false;
        }
        return true;
    }
	
    //��֤�������Ƿ�������(��is_int()��֤���˵�)
    //ǰ����Լ��Ͽ�ѡ�ķ��ţ�- ���� +��
    function isInt($str)
	{
        $pattern="/^[-|+]?(([0-9]{1})|([1-9]{1}[0-9]+))$/";
        if(@preg_match($pattern,$str))
		{
		    return true;
		}
        return false;
    }
	
    //��֤�Ƿ����������,is_numeric()��֤���������͸�����
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
	
    //email���
    function isEmail($str)
	{
        $pattern="/^[_0-9a-z]+@[0-9a-z-]+(\.[0-9a-z-]+)*\.[a-z]+$/i";
        if(@preg_match($pattern,$str)){return true;}
        return false;
    }
	
    //URL��⣬ֻ���http��ʽ
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

    //��������,�й�����������6λ�������
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
	
    //�绰���� ����-���� �� ���� �����ź���
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
	
    //�ֻ���������-���� �� ���� �����ź���
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

    //�ַ��������Ƿ���l1��l2֮��,��l1<$str<l2
    function isLen($str,$l1,$l2)
	{
       if(strlen($str)>$l1&&strlen($str)<$l2){return true;}
       return false;
    }
	
    //���֤����
    //������֤15��18λ�����֤����
    function isIdCard($str)
	{
	    //ǰ��λ��ʡ������
        $pro=array("11","12","13","14","15","21","22","23","31","32","33","34","35","36","37","41","42","43","44","45","46","50","51","52","53","54","61","62","63","64","65","71","81","82","91");
        //��֤ǰ��λ
	    if(!in_array(substr($str,0,2),$pro))return false;
        if(strlen($str)==15)
		{
            if(!@preg_match("/^\d+$/",$str))return false;
            //�����-��-�գ���ǰ���19��
            return @checkdate(substr($str,8,2),substr($str,10,2),"19".substr($str,6,2));
        }
        if(strlen($str)==18)
		{
		    //ǰ17λ�Ƿ�������
            if(!@preg_match("/^\d+$/",substr($str,0,17)))return false;
            //�����-��-��
            if(!@checkdate(substr($str,10,2),substr($str,12,2),substr($str,6,4)))return false;
            //��Ȩ����Wi=2^��i-1��(mod 11)����ó�
            $Wi_arr=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2,1);
            //У�����Ӧֵ
            $VN_arr=array(1,0,'x',9,8,7,6,5,4,3,2);
            //����У������ֵ(����ǰ17λ�ģ����һλΪУ����)
            for($i=0;$i<strlen($str)-1;$i++)
			{
                $t+=substr($str,$i,1) * $Wi_arr[$i];
            }
            //�õ�У����
            $VN=$VN_arr[($t % 11)];
            //�ж����һλ��У����
            if($VN==substr($str,-1)){return true;}else{return false;}
        }
        return false;
    }
	
    //�ַ����Ƿ�ȫ����Ӣ��
    function isEnglish($str)
	{
        $pattern="/^[a-z]+$/i";
        if(@preg_match($pattern,$str)){return true;}
        return false;
    }
	
    //�Ƿ��Ǽ�������
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
	
    //�Ƿ��Ƿ�������
    function isBIG5()
	{
	}
	
    //�Ƿ�GBK
    function isGBK()
	{
	}
	
    //�Ƿ���ip
    function isIP($str)
	{
        $s=explode(".",$str);
        if(count($s)!=4) return false;
        foreach($s as $v)
		{
            if(!is_numeric($v)) return false;
            //if(!is_int($v)) return false;
            //���ü���Ƿ��С��,��ΪС����С����"."
            //�������Ƿ����192.168.01.02 ��0��ͷ��С��
            if(preg_match("/^0[0-9]+$/",$v)) return false;
            if($v<0 || $v>255) return false;
        }
        return false;
    }
	
    //�Ƿ���QQ 5-10λ
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
	
    //����ļ�����չ���Ƿ����,$filetype�������ַ���������,���Ҵ��ݵ�����Ҫȫ��ΪСд
    //ʹ��1:checkFileType("gif|rar|jpeg|jpg","lsflkjs.jpeg") return true
    //ʹ��2:checkFileType(array("rar","bmp","gif"),"lsflkjs.jpeg") return false
    function checkFileType($filetype,$file)
	{
        $f=(is_array($filetype))?$filetype:explode("|",$filetype);
        $n=strrchr($file,'.');//��ȡ�ַ������Ҳ����򷵻�""
        $n=(!$n)?"":strtolower(substr($n,1));
        //in_array(),�����ִ�Сд��
        return in_array($n,$f);
    }
	
    //�ж��Ƿ����ַ����г���ĳЩ�ַ�
    function isInStr($str1,$str2)
	{
	}

    //��������ύ����post,get���ַ�ʽ���Ƿ����ж���Ϊ��
    //ע��:��ⲻ�˶�ѡ��.û��ʹ��trim()ȥ����β�ո�
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
	
    //��ʾ���н��յ��������б�
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
            if(is_array($_REQUEST[$key])) $str.="&nbsp;&nbsp;<b>����</b>";
             echo $str."\n";
        }
    }

    //ÿ���඼����һ��o($info) ���(output)����
     function o($info="")
	 {
        $cssstyle="style=\"";
        $cssstyle.="font:bold 12px 150%,'Arial';border:1px solid #CC3366;";
        $cssstyle.="width:50%;color:#990066;padding:2px;\"";
        $str="\n<ul ".$cssstyle."><li>".$info."</li></ul>\n";
        echo $str;
    }
	
    //ÿ���඼����һ��showInfo($info,$type) �������
    function showInfo($info,$type=0,$url="")
	{
        switch($type){
        case 0:$this->o($info);break;
        case 1:echo "<script>alert(".chr(34).str_replace("\"","\\\"",$info).chr(34).");</script>";break;
        case 2:if($url==""){$this->o("showInfo(\$info,\$type=0,\$url=\"\") ����:��Ҫ\$url����");break;} echo "<script>location.href='$url';</script>";break;
        case 3:echo "<script>history.go(-1);</script>";
        case 4:header("Location:$url");break;
        case 5:$this->showInfo($info,1);$this->showInfo("",3);
        case 6:$this->showInfo($info,1);$this->showInfo("",2,$url);
        default:$this->o($info);
   }
}
}
?>