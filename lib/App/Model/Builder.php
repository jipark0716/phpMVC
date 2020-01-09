<?
namespace App\Model;

class Builder{
    protected $table;
    protected $primaryKey;
    public function __construct($tbl,$pk = 'id'){
        $this->table = $tbl;
        $this->primaryKey = $pk;
    }
    public function find($idx,$col = '*'){
        if(getType($col) == 'array'){
            $col = join($col,',');
        }
        $sql = "select {$col} from {$this->table} where {$this->primaryKey} = {$idx}";
        return self::first($sql);
    }
    public function insert($data){
        $key = join(',',array_keys($data));
        $value = array_values($data);
        $temp = '?'.str_repeat(',?',count($key)-1);
        $sql = "insert into {$this->table}({$key}) value({$temp})";

        $stmt = self::getDBConn()->stmt_init();
        $stmt = self::getDBConn()->prepare($sql);

        $stmt->bind_param(str_repeat('s',count($key)),$value);

        $stmt->execute();
    }
    //static
    protected static $_MYSQLI;
    public static function query($sql){
        return self::getDBConn()->query($sql);
    }
    public static function first($sql){
        $result = self::getDBConn()->query($sql.' limit 1');
        return $result->fetch_assoc();
    }
    public static function getDBConn(){
        if(self::$_MYSQLI) return self::$_MYSQLI;
        self::$_MYSQLI = new mysqli(getenv('DB_host'),getenv('DB_id'),getenv('DB_pw'),getenv('DB_name'));
        return $_MYSQLI;
    }
}
