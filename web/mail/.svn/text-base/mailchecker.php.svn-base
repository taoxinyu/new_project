<?
/**
 * 
 *
 */
class  email_validation_class
{
           var  $timeout=0;  
           var  $localhost="";  
           var  $localuser="";
           var  $email="";  
 			
           function __construct($email, $timeout=10)
           {
           		$this->timeout = $timeout;
				$this->email = $email;
           }
           
           function  GetLine($connection)  
           {  
                       for($line="";;)  
                       {  
                                   if(feof($connection))  
                                               return(0);  
                                   $line.=fgets($connection,100);  
                                   $length=strlen($line);  
                                   if($length>=2  &&  substr($line,$length-2,2)=="\r\n")  
                                               return(substr($line,0,$length-2));  
                       }  
           }  
 
           function  PutLine($connection,$line)  
           {  
                       return(fputs($connection,"$line\r\n"));  
           }  
 
           function  ValidateEmailAddress($email)  
           {  
                       //return(eregi($this->email_regular_expression,$email)!=0);  
                       $rt = eregi("^[a-zA-Z0-9]+[_a-zA-Z0-9-]*(\.[_a-z0-9-]+)*@[a-z0-9]+(-[a-z0-9]+)*(\.[a-z0-9-]+)*(\.[a-z]{2,4})$",$email);
                       return($rt);  
           }  
 
           function  ValidateEmailHost($email,$hosts=0)  
           {  
                       if(!$this->ValidateEmailAddress($email))  
                                   return(0);  
                       $user=strtok($email,"@");  
                       $domain=strtok("");  
                       if(getmxrr($domain,&$hosts,&$weights))  
                       {  
                                   $mxhosts=array();  
                                   for($host=0;$host<count($hosts);$host++)  
                                               $mxhosts[$weights[$host]]=$hosts[$host];  
                                   KSort($mxhosts);  
                                   for(Reset($mxhosts),$host=0;$host<count($mxhosts);Next($mxhosts),$host++)  
                                               $hosts[$host]=$mxhosts[Key($mxhosts)];  
                       }  
                       else  
                       {  
                                   $hosts=array();  
                                   if(strcmp(@gethostbyname($domain),$domain)!=0)  
                                   $hosts[]=$domain;  
                       }  
                       return(count($hosts)!=0);  
           }  
 
           function  VerifyResultLines($connection,$code)  
           {  
                       while(($line=$this->GetLine($connection)))  
                       {  
                                   if(!strcmp(strtok($line,"  "),$code))  
                                               return(1);  
                                   if(strcmp(strtok($line,"-"),$code))  
                                               return(0);  
                       }  
                       return(-1);  
           }  
 
           function  ValidateEmailBox($email)  
           {  
                       if(!$this->ValidateEmailHost($email,&$hosts))  
                                   return(0);  
                       if(!strcmp($localhost=$this->localhost,"")  &&  !strcmp($localhost=getenv("SERVER_NAME"),"")  &&  !strcmp($localhost=getenv("HOST"),""))  
                                   $localhost="localhost";  
                       if(!strcmp($localuser=$this->localuser,"")  &&  !strcmp($localuser=getenv("USERNAME"),"")  &&  !strcmp($localuser=getenv("USER"),""))  
                                   $localuser="root";  
                       for($host=0;$host<count($hosts);$host++)  
                       {  
                                   if(($connection=($this->timeout  ?  fsockopen($hosts[$host],25,&$errno,&$error,$this->timeout)  :  fsockopen($hosts[$host],25))))  
                                   {  
                                               if($this->VerifyResultLines($connection,"220")>0  &&  $this->PutLine($connection,"HELO  $localhost")  &&  $this->VerifyResultLines($connection,"250")>0  &&  $this->PutLine($connection,"MAIL  fROM:  <$localuser@$localhost>")  &&  $this->VerifyResultLines($connection,"250")>0  &&  $this->PutLine($connection,"RCPT  TO:  <$email>")  &&  ($result=$this->VerifyResultLines($connection,"250"))>=0)  
                                               {  
                                                           fclose($connection);  
                                                           return($result);  
                                               }  
                                               fclose($connection);  
                                   }  
                       }  
                       return(-1);  
           }

           function check(){
           		if ($this->email != ""){
           		       if(($result = $this->ValidateEmailBox($this->email))<0)  
			           {  
			                       return false;  
			           }  
			           else  
			           {    
			                       if(!$result)  
			                       {    
			                                   return false;  
			                       }  
			                       else
			                       {    
			                                   return true;
			                       } 
			           }
           		}
           		return false;
           }
};  

/*
$em = new email_validation_class("sdfsdf@mail.com");
$rs = $em->check();
*/
?>