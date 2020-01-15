<?
namespace App\Validation;

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use App\Model\Builder;

class Validation{
    public $data = [];
    protected $error = [];
    public function __construct($data,$col = null){
        if($col == null){
            $this->data = $data;
            return;
        }
        foreach ($col as $key) {
            $this->data[$key] = $data[$key];
        }
    }
    public function append($key,$value){
        $this->data[$key] = $value;
    }
    public function requiredCol($col = null){
        if($col == null || getType($col) == 'array'){
            $keys = $col == null ? array_keys($this->data) : $col;
            foreach ($keys as $key) {
                $this->requiredCol($key);
            }
        }else{
            if(!array_key_exists($col,$this->data) || $this->data[$col] == ''){
                $this->error($col,'필수 항목 입니다.');
            }
        }
    }
    public function error($col,$msg){
        if(!isset($this->error[$col]))
            $this->error[$col] = ['message'=>$msg];
    }
    public function isError(){
        return count($this->error) > 0 ? true : false;
    }
    public function getError(){
        $this->error;
    }
    public function confirmation($col){
        $confCol = $col.'_confirmation';
        if($this->data[$confCol] != $this->data[$col]){
            $this->error($confCol,'비밀번호가 일치하지 않습니다.');
        }
        unset($this->data[$confCol]);
    }
    public function length($min,$max,$col = null){
        if($col == null || getType($col) == 'array'){
            $keys = $col == null ? array_keys($this->data) : $col;
            foreach ($keys as $key) {
                $this->length($min,$max,$key);
            }
        }else{
            if(mb_strlen($this->data[$col],'utf-8') < $min
            || mb_strlen($this->data[$col],'utf-8') > $max){
                $this->error($col,"{$min}글자 이상 {$max}글자 이하여야 합니다.");
            }
        }
    }
    public function disallowedChar($char,$col = null){
        if($col == null || getType($col) == 'array'){
            $keys = $col == null ? array_keys($this->data) : $col;
            foreach ($keys as $key) {
                $this->disallowedChar($char,$key);
            }
        }else{
            if(strposa($this->data[$col],$char)){
                $char = getType($char) == 'array' ? join(', ',$char) : $char;
                $this->error($col,"\" {$char} \"는 사용할 수 없는 문자 입니다.");
            }
        }
    }
    public function regexp($reg,$col = null){
        if($col == null || getType($col) == 'array'){
            $keys = $col == null ? array_keys($this->data) : $col;
            foreach ($keys as $key) {
                $this->regexp($reg,$key);
            }
        }else{
            if(preg_match($reg,$this->data[$col])){
                $this->error($col,"형식에 맞지 않습니다.");
            }
        }
    }
    public function uniqueKey($table,$col = null){
        if($col == null || getType($col) == 'array'){
            $keys = $col == null ? array_keys($this->data) : $col;
            foreach ($keys as $key) {
                $this->uniqueKey($table,$key);
            }
        }else{
            $cnt = Builder::value('select count(*) from '.$table.' where BINARY '.$col.' = \''.$this->data[$col].'\'');
            if($cnt > 0){
                $this->error($col,"중복된 데이터가 있습니다.");
            }
        }
    }
    public function hashing($col = null){
        if($col == null || getType($col) == 'array'){
            $keys = $col == null ? array_keys($this->data) : $col;
            foreach ($keys as $key) {
                $this->hashing($key);
            }
        }else{
            $this->data[$col] = password_hash($this->data[$col],PASSWORD_DEFAULT);
        }
    }
    public function isNumber($col = null){
        if($col == null || getType($col) == 'array'){
            $keys = $col == null ? array_keys($this->data) : $col;
            foreach ($keys as $key) {
                $this->isNumber($key);
            }
        }else{
            if(!is_numeric($this->data[$col])){
                $this->error($col,'이 항목은 숫자여야 합니다.');
            }
        }
    }
    public function escape($col = null){
        if($col == null || getType($col) == 'array'){
            $keys = $col == null ? array_keys($this->data) : $col;
            foreach ($keys as $key) {
                $this->escape($key);
            }
        }else{
            $this->data[$col] = htmlentities($this->data[$col]);
        }
    }
    public function ifErrorEndApi(){
        if($this->isError()){
            $result['error'] = $this->error;
            $result['success'] = false;
            apiEnd($result);
        }
    }
}
