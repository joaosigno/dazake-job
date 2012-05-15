<?php
session_start();
class image{
    var $Width = 59;
    var $Height = 20;
	var $mode = "1";//得到字符模式
	var $v_num=4;//验证码个数
	var $int_pixel_num=10;//干扰像素个数
	var $int_line_num = 0;//干扰线个数
	
	function GetChar($mode){
		if($mode == "1"){
			$ychar = "0,1,2,3,4,5,6,7,8,9";
		}else if($mode == "2"){
	   		$ychar = "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z";
	  	}else if($mode == "3"){
	   		$ychar = "0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z";
	  	}else{
	   		$ychar = "3,4,5,6,7,8,9,A,B,C,D,H,K,P,R,T,W,X,Y,a,b,c,d,h,k,p,r,t,w,x,y";
	  	}
	  	return $ychar;
	 }

		
    function image(){
		if(!isset($_SESSION['vCode'])){
		   session_register('vCode');
		}
		
		$_SESSION['vCode']="";
        header("Content-type: image/png");
        $IM = @imagecreate($this->Width,$this->Height); //创建一个空白图像
		
		$color_bg = imagecolorallocate($IM, 250,250,250); 
		imagefill($IM,0,0,$color_bg);//填充背景

		//生成验证码
		$ychar = $this->GetChar($this->mode);
  		$codeList = explode(",",$ychar);
		$cmax = count($codeList) - 1;
		$code = "";
		$x = mt_rand(2,$this->Width/($this->v_num+2));
		$verifyCode="";
		
		for($i=0;$i<$this->v_num;$i++) {//验证码
			$y = rand(3,3);//让字上下错位
			$rand_color = $this->RandColor(0,200,0,100,0,250);
   			$randcolor = imagecolorallocate($IM,$rand_color[0],$rand_color[1],$rand_color[2]);
			$code = $codeList[rand(0,$cmax)];
			imagestring($IM,5,$x,$y,$code,$randcolor);
			$x = $x + intval($this->Width/($this->v_num+1));
			$verifyCode.=$code;
		}
		
		for($i=0;$i<$this->int_pixel_num;$i++){//干扰像素
		   $rand_color = $this->RandColor(50,250,0,250,50,250);
		   $rand_color_pixel = imagecolorallocate($IM,$rand_color[0],$rand_color[1],$rand_color[2]);
		   imagesetpixel($IM, mt_rand()%$this->Width, mt_rand()%$this->Height, $rand_color_pixel);
		}
		
		for($i=0;$i<$this->int_line_num;$i++){ //干扰线
		   $rand_color = $this->RandColor(0,250,0,250,0,250);
		   $rand_color_line = imagecolorallocate($IM,$rand_color[0],$rand_color[1],$rand_color[2]);
		   imageline($IM, mt_rand(0,intval($this->Width/3)), mt_rand(0,$this->Height), mt_rand(intval($this->Width - ($this->Width/3)),$this->Width), mt_rand(0,$this->Height), $rand_color_line);
		}
		
		$_SESSION['vCode']=strtolower($verifyCode);
		//imageantialias($im,true); //抗锯齿
        imagepng($IM);
        imagedestroy($IM);
    }
    
	function RandColor($rs,$re,$gs,$ge,$bs,$be){
	  $r = mt_rand($rs,$re);
	  $g = mt_rand($gs,$ge);
	  $b = mt_rand($bs,$be);
	  return array($r,$g,$b);
	}
}
new image();
?>