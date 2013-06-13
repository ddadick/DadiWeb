<?php
class Apps_Widening_Test
{
    protected $_str=array();
    
    protected $_count=0;
    
    protected $_start=0;
    protected $_rec=0;
    
    public function __construct($options=NULL){
        if(NULL===$options){return NULL;}
        echo '<pre>';
        echo $options.' <br />';
        //var_dump($str=explode("}", $options));
        $this->_str[$this->_count]='';
        $this->recurcive($a=explode("}", $options));
        $this->_str=$this->_str[0].$a[count($a)-1];
        unset($a);
        var_dump($this->_str).' ppp<br />';
        echo '</pre>';
        //echo $options;
    }
    
    protected function recurcive($str=NULL){
        //echo var_dump($str).' 0<br />';
        //echo $this->str.' result<br/>';
        if(NULL===$str){return NULL;}
        if(is_array($str)){
            foreach($str as $key=>$item){
                //echo var_dump($item).' NNN<br/>';
                $count=substr_count($item, '{');
                //echo $count.' - '.$key.' 0<br />';
                if(false!==($pos=strpos($item,'{'))){
                    echo $count.' 1<br/>';
                    if($count>1){
                        $this->_str[$this->_count].=substr($item, 0,($pos));
                    
                        echo substr($item, 0,($pos)). ' ---- '.($str2=substr($item, ($pos+1))).' 1<br/>';
                        $this->_rec=$this->_count+$count;
                        $this->_start=$this->_count+1;
                        //var_dump($this->_str).' 1<br/>';
                        //$str3=explode('{',$str2);
                        self::recurcive(substr($item, ($pos+1)));//.' 1<br/>';
                        echo var_dump($this->_str).' 1<br/>';
                        //echo var_dump(self::recurcive(substr($item, ($pos+1)))).' 1<br/>';
                        //echo substr($item, 0,($pos)). ' ---- '.self::recurcive($str2).' 1-1<br/>';
                    }elseif(false!==($pos2=strpos($item,'|'))){
                        //echo var_dump($this->_str).' 2-2<br/>';
                        $array=explode('|',substr($item, ($pos+1)));
                        //echo var_dump($this->_str).' 2-2<br/>';
                        $this->_str[$this->_count].=substr($item, 0,($pos)).' '.$array[array_rand($array)];
                        echo substr($item, 0,($pos)). ' |||| '. $array[array_rand($array)] .' 2<br/>';
                        //echo var_dump($this->_str).' 2<br/>';//substr($item, 0,($pos)). ' |||| '. $array[array_rand($array)] .' 2<br/>';//substr($item, 0,($pos)). ' |||| '. substr($item, ($pos+1)).' 2<br/>';
                    }else{
                        
                        
                        echo $item.' 3<br/>';
                    }
                }elseif(false!==($pos=strpos($item,'|'))){
                    if($this->_rec>=0){
                        $this->_str[$this->_start].=$item;
                        $this->_rec--;
                    }
                    //echo $item.' 4<br/>';//substr($item, ($pos+1)).'<br/>';
                    
                    if($this->_rec<=0){
                        $this->_str[$this->_count].=self::recurcive($this->_str[$this->_start]);
                        unset($this->_str[$this->_start]);
                    }
                    //echo var_dump($this->_str).' 4<br/>';
                    return $item;
                }else{
                    echo $item.' 5<br/>';

                }
            }
        }elseif(false!==($pos=strpos($str,'{'))){
            
            $count=substr_count($str, '{');
            if($count>1){
                echo substr($str, 0,$pos).' ----- '.substr($str, $pos+1).' 6-count<br />';
                echo var_dump($this->_str).' 6-4<br />';
                echo substr($str, $pos+1).' 6-5<br />';
                self::recurcive(substr($str, $pos+1));
                
                
                
                /**
                foreach(explode('{',$str) as $key=>$item){
                    echo $item.' 6-1<br />';
                    $this->_str[$this->_start]=(isset($this->_str[$this->_start]))?$this->_str[$this->_start]:'';
                    $this->_str[$this->_start].=$item;
                    echo var_dump($str).' 6-1<br />';
                }
                */
            }else{
                echo substr($str, 0,$pos).' ----- '.substr($str, $pos+1).' 6-1<br />';
                
                $this->_str[$this->_start]=($this->_rec>0)?
                    self::recurcive((substr($str,0,$pos).self::recurcive(substr($str, ($pos+1))))):$this->_str[$this->_start];
                $this->_start++;
                echo $this->_start.' 6-1<br />';
                $this->_rec--;
                if($this->_rec<=0){
                    $this->_str[$this->_count].=self::recurcive($this->_str[$this->_start]);
                    unset($this->_str[$this->_start]);
                }
            }
        }elseif(false!==($pos=strpos($str,'|'))){
            echo substr($str, 0,$pos).' |||| '.substr($str, $pos+1).' 7<br />';
                $array=explode('|',$str);
                return $array[array_rand($array)];
                
        }else{
            echo $str.' 8<br/>';
            //return $str;
        }
    }
    
}