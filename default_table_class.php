<?php
include 'ChromePhp.php';
class Default_Table
{
  var $tablename;         // table name
  var $dbname;            // database name
  var $rows_per_page;     // used in pagination
  var $pageno;            // current page number
  var $lastpage;          // highest page number
  var $fieldlist;         // list of fields in this table
  var $data_array;        // data from the database
  var $errors;            // array of error messages
  function Default_Table ()
  {
    $this->tablename       = 'default';
    $this->dbname          = 'default';
    $this->rows_per_page   = 10;

    $this->fieldlist = array('column1', 'column2', 'column3');
    $this->fieldlist['column1'] = array('pkey' => 'y');
  } // constructor
   function getData ($where)
   {
      $this->data_array = array();
      $pageno          = $this->pageno;
      $rows_per_page   = $this->rows_per_page;
      $this->numrows   = 0;
      $this->lastpage  = 0;

      global $conn, $query;
      if (is_array($where)){
        $special = $where[1];
        $where = $where[0];

      }

      $conn = OpenCon($this->dbname) or trigger_error("SQL", E_USER_ERROR);
      //$where = str_replace("'", "", $where);
      if (empty($where)) {
         $where_str = NULL;
      } else {
         $where_str = "WHERE $where";
      } // if

      if (empty($special)) {
         $query = "SELECT * FROM $this->tablename $where_str";
      } else {
         $query = "SELECT $special FROM $this->tablename $where_str";
      }
      if(preg_match("/WHERE(.+)=\W+([A-Za-zäöåÄÖÅ0-9 %-]+)\W+/",
       $where_str, $output)){
        $variable = $output[1];
        $value = $output[2];

      $query = "SELECT * FROM $this->tablename WHERE $variable = ?";

      }

      else if(preg_match("/WHERE(.+)LIKE\W+([A-Za-zäöåÄÖÅ0-9 %-]+)\W+/",
       $where_str, $output)){
        $variable = $output[1];
        $value = $output[2];
      $query = "SELECT * FROM $this->tablename WHERE $variable LIKE ?";

    }else{
      trigger_error("SQL", E_USER_ERROR);
    }
      $stmt = $conn->prepare($query);
      $stmt->bind_param('s', $value);
      $stmt->execute() or trigger_error("SQL", E_USER_ERROR);
      $stmt->store_result();
      $meta = $stmt->result_metadata();

      while ($field = $meta->fetch_field()) {
        $parameters[] = &$row[$field->name];
      }

      call_user_func_array(array($stmt, 'bind_result'), $parameters);

      while ($stmt->fetch()) {
        foreach($row as $key => $val) {
          $x[$key] = $val;
        }
        $this->data_array[] = $x;
      }

      if($where === "ID LIKE '%'" && $this->tablename == "Kund"){
      $count = $stmt->num_rows();
      //print_r("count: ".$count);
      return $count;
    }
      $stmt->close();
      $conn->close();
      return $this->data_array;

   }
   function insertData ($fieldarray)
   {
      $this->errors = array();

      global $conn, $query;
      //$dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);
      $conn = OpenCon($this->dbname) or trigger_error("SQL", E_USER_ERROR);
       //ChromePhp::log($fieldarray);
      $fieldlist = $this->fieldlist;
      foreach ($fieldarray as $field => $fieldvalue) {
         if (!in_array($field, $fieldlist)) {
            unset ($fieldarray[$field]);
         } // if
      } // foreach

      $query = "INSERT INTO $this->tablename (";
       $data = array();
      foreach ($fieldarray as $item => $value) {

         $query .= $item.", ";
         $value = str_replace("/", "", $value);
         $value = str_replace("\\", "", $value);
         $value = mysqli_real_escape_string($conn, $value);

        if(preg_match('/^[A-Za-zäöåÄÖÅ0-9 -]+$/', $value) ||
        strpos($value, '') !== false){
          array_push($data, $value);
        }else{
          trigger_error("SQL", E_USER_ERROR);
        }
      } // foreach
      $query = rtrim($query, ', ');
      $query = $query.") VALUES (";
      foreach ($fieldarray as $item => $value) {
         $query .= "?, ";
      } // foreach
      $query = rtrim($query, ', ');
      $query = $query.")";
     $stmt = $conn->prepare($query);
     for($i = 0; $i < substr_count($query, '?'); $i++){
       //echo($args);
       $args.="s";
     }
     $params = array_merge(array($args), $data);
     foreach( $params as $key => $value ) {
         $params[$key] = &$params[$key];
     }

     call_user_func_array(array($stmt, "bind_param"), $params);
     $stmt->execute() or trigger_error("SQL", E_USER_WARNING);
     //$result = $stmt->get_result() or trigger_error("SQL", E_USER_ERROR);
      $result = $stmt->get_result();
      $stmt->close();
      $conn->close();
      if (mysql_errno() <> 0) {

            trigger_error("SQL", E_USER_WARNING);
             echo "<p style='color:red;'>$query: Var god kontrollera informationen du försökte lägga in var korrekt inmatad och försök igen.</p>";

      } // if

      return;

   } // insertData


   function updateData ($fieldarray)
   {
      $this->errors = array();

      global $dbconnect, $query;
      $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);

      $fieldlist = $this->fieldlist;
      foreach ($fieldarray as $field => $fieldvalue) {
         if (!in_array($field, $fieldlist)) {
            unset ($fieldarray[$field]);
         } // if
      } // foreach

      $where  = NULL;
      $update = NULL;
      foreach ($fieldarray as $item => $value) {

         if (isset($fieldlist[$item]['pkey'])) {
            $where .= "$item='$value' AND ";
         } else {
            $update .= "$item='$value', ";
         } // if
      } // foreach

      $where  = rtrim($where, ' AND ');
      $update = rtrim($update, ', ');

      $query = "UPDATE $this->tablename SET $update WHERE $where";
      $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_WARNING);

      return;

   } // updateData

   function deleteData ($fieldarray)
   {
      $this->errors = array();

      global $dbconnect, $query;
      $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_WARNING);

      $fieldlist = $this->fieldlist;
      $where  = NULL;
      foreach ($fieldarray as $item => $value) {
         if (isset($fieldlist[$item]['pkey'])) {
            $where .= "$item='$value' AND ";
         } // if
      } // foreach

      $where  = rtrim($where, ' AND ');

      $query = "DELETE FROM $this->tablename WHERE $where";
      $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_WARNING);

      return;

   } // deleteData
   function alterClass ($what)
   {
      $this->errors = array();

      global $dbconnect, $query;
      $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);

      $fieldlist = $this->fieldlist;
      $what  = rtrim($what, ' AND ');
      $query = "ALTER TABLE $this->tablename $what";
      $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);

      return;

   } // alterClass
} // end class
?>
