 <?php
     function changeKey($array, $key){
         $i = 1;
         while(in_array($key,$array)){
             $key = substr($key,0,-1);
             $key = $key . $i;
             $i++;

         }
         return $key;
     }