<?php
$phpMySQLAutoBackup_version = '1.5.5';

$link = mysql_connect($db_server,$mysql_username,$mysql_password);
if($link) mysql_select_db($db);
if(mysql_error() AND DEBUG) echo '<hr />MySQL ERROR: '.mysql_error().'<hr />';
if(mysql_error()) exit();

//add new phpmysqlautobackup table if not there...
if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'phpmysqlautobackup' ")) == 0) {
   $query = "
    CREATE TABLE phpmysqlautobackup (
    id int(11) NOT NULL,
    version varchar(6) default NULL,
    time_last_run int(11) NOT NULL,
    PRIMARY KEY (id)
    ) TYPE=MyISAM;";
   $result=mysql_query($query);
   $query="INSERT INTO phpmysqlautobackup (id, version, time_last_run)
             VALUES ('1', '$phpMySQLAutoBackup_version', '0');";
   $result=mysql_query($query);
}
//check time last run - to prevent malicious over-load attempts
$query="SELECT * from phpmysqlautobackup WHERE id=1 LIMIT 1 ;";
$result=mysql_query($query);
$row=mysql_fetch_array($result);
if (time() < ($row['time_last_run']+$time_interval)) exit();// exit if already run within last time_interval

$query="UPDATE phpmysqlautobackup SET time_last_run = '".time()."' WHERE id=1 LIMIT 1 ;";
$result=mysql_query($query);

if (!isset($table_select))
{
  $t_query = mysql_query('show tables');
  $i=0;
  $table="";
  while ($tables = mysql_fetch_array($t_query, MYSQL_ASSOC) )
        {
         list(,$table) = each($tables);
         $exclude_this_table = isset($table_exclude)? in_array($table, $table_exclude) : false;
         if(!$exclude_this_table) $table_select[$i]=$table;
         $i++;
        }
}

$recordBackup = new record();

$thedomain = $_SERVER['HTTP_HOST'];
if (substr($thedomain,0,4)=="www.") $thedomain=substr($thedomain,4,strlen($thedomain));

$buffer = '# MySQL backup version: '.$phpMySQLAutoBackup_version . "\n" .
          '# ' . "\n" .
          '# Database: '. $db . "\n" .
          '# Domain name: ' . $thedomain . "\n" .
          '# (c)' . date('Y') . ' ' . $thedomain . "\n" .
          '#' . "\n" .
          '# Backup START time: ' . strftime("%H:%M:%S",time()) . "\n".
          '# Backup END time: #phpmysqlautobackup-endtime#' . "\n".
          '# Backup Date: ' . strftime("%d %b %Y",time()) . "\n";

$i=0;
$lines_exported=0;
foreach ($table_select as $table)
        {
          $i++;
          $export = " \n" .'DROP TABLE IF EXISTS `' . $table . '`; ' . "\n";

          //export the structure
          $query='SHOW CREATE TABLE `' . $table . '`';
          $rows_query = mysql_query($query);
          $tables = mysql_fetch_array($rows_query);
          $export.= $tables[1] ."; \n";

          $table_list = array();
          $fields_query = mysql_query('SHOW FIELDS FROM  `' . $table . '`');
          while ($fields = mysql_fetch_array($fields_query))
           {
            $table_list[] = $fields['Field'];
           }

          $buffer.=$export;
          // dump the data
          $query='SELECT * FROM `' . $table . '` LIMIT '. $limit_from .', '. $limit_to.' ';
          $rows_query = mysql_query($query);
          while ($rows = mysql_fetch_array($rows_query)) {
            $export = 'INSERT INTO `' . $table . '` (`' . implode('`, `', $table_list) . '`) values (';
            $lines_exported++;
            reset($table_list);
            while (list(,$i) = each($table_list)) {
              if (!isset($rows[$i])) {
                $export .= 'NULL, ';
              } elseif (has_data($rows[$i])) {
                $row = addslashes($rows[$i]);
                $row = str_replace("\n#", "\n".'\#', $row);

                $export .= '\'' . $row . '\', ';
              } else {
                $export .= '\'\', ';
              }
            }
            $export = substr($export,0,-2) . "); \n";
            $buffer.= $export;
          }
        }
$backup_info.=$recordBackup->save(time(), strlen($buffer), $lines_exported);

$buffer = str_replace('#phpmysqlautobackup-endtime#', strftime("%H:%M:%S",time()), $buffer);
?>