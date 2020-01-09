<?
namespace App\Validation;

use MicrosoftAzure\Storage\Blob\BlobRestProxy;

class Validation{
    protected $data;
    protected $error = [];
    public function __construct($data){
        $this->data = $data;
    }
    public function requiredCol($col){
        foreach ($col as $val) {
            if(!array_key_exists($val,$this->data) || $this->data[$val] == ''){
                $this->error($val,'필수 항목 입니다.');
            }
        }
    }
    public function error($col,$msg){
        $this->error[$col] = ['message'=>$msg];
    }
    public function isError(){
        return count($this->error) > 0 ? true : false;
    }
    public function getError(){
        $this->error;
    }
    public function ifErrorEndApi(){
        if($this->isError() || true){
            $result['error'] = $this->error;
            $result['success'] = false;
            apiEnd($result);
        }
    }
}
