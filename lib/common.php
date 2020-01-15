<?
include getenv('autoload');

use voku\db\DB;
use voku\helper\Session2DB;

DB::getInstance(getenv('DB_host'),getenv('DB_id'),getenv('DB_pw'),getenv('DB_name'));
new Session2DB();
