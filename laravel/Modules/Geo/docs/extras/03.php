<?php



/*
 * Complete the 'slotWheels' function below.
 *
 * The function is expected to return an INTEGER.
 * The function accepts STRING_ARRAY history as parameter.
 */

function slotWheels($history) {
    // Write your code here
    $c=count($history);
    $max=0;
    $next=[]
    for($i=0;$i<$c;$i++){
        $curr=$history[$i];
        $arr=str_split($curr);
        $max_curr=max($arr);
        if($max_curr>$max){
            $max=$max_curr;
        }
        $tmp=array_filter($arr,function($k) use($max_curr){
            return $k!=$max_curr;
        });
        $next[]=implode('',$tmp);
    }
    //echo '<pre>'.print_r($next,true).'</pre>';
    
}

$fptr = fopen(getenv("OUTPUT_PATH"), "w");

$history_count = intval(trim(fgets(STDIN)));

$history = [];

for ($i = 0; $i < $history_count; $i++) {
    $history_item = rtrim(fgets(STDIN), "\r\n");
    $history[] = $history_item;
}

$result = slotWheels($history);

fwrite($fptr, $result . "\n");

fclose($fptr);
