<?
namespace App\Model;

use Mysqli;

class Builder{
    protected static $_MYSQLI;
    public static function find($idx,$col = '*',$pk,$table){
        if(getType($col) == 'array'){
            $col = join($col,',');
        }
        $sql = "select {$col} from {$table} where {$pk} = {$idx}";
        return self::first($sql);
    }
    public static function insert($data,$table){
        $key = join(',',array_keys($data));
        $value = array_values($data);
        $temp = '\''.join("','",$value).'\'';
        $sql = "insert into {$table}({$key}) value({$temp})";
        self::query($sql);
    }
    public static function update($data,$table,$where){
        $sql = 'update '.$table.' set ';
        foreach ($data as $key => $value) {
            if(preg_match('/^[+,-]\d{1,100}$/',$value)){
                $sql.=$key.' = '.$key.$value;
            }else{
                $sql.=$key.' = \''.$value.'\'';
            }
        }
        $sql.= ' where '.$where;
        self::query($sql);
    }
    public static function insertGetId($data,$table){
        self::insert($data,$table);
        return self::value('SELECT LAST_INSERT_ID()');
    }
    public static function query($sql){
        return self::getDBConn()->query($sql);
    }
    public static function first($sql){
        $result = self::getDBConn()->query($sql.' limit 1');
        if($result->num_rows > 0)
            return $result->fetch_assoc();
        return null;
    }
    public static function value($sql){
        $result = self::first($sql);
        if($result != null)
            return array_values($result)[0];
        return null;
    }
    public static function getDBConn(){
        if(self::$_MYSQLI) return self::$_MYSQLI;
        self::$_MYSQLI = new Mysqli(getenv('DB_host'),getenv('DB_id'),getenv('DB_pw'),getenv('DB_name'));
        return self::$_MYSQLI;
    }
    public static function paging($sql,$pageRow,$page = 1){
        --$page;
        $offset = $pageRow * $page;
        $sql.= ' limit '.$offset.', '.$pageRow;
        return self::query($sql);
    }
}
