<?php

require_once(APP_ROOT . '/libraries/Database.php');

class MainModel {

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllRecords() {
        $this->db->setQuery("SELECT * FROM students");
        return $this->db->getResultSet();
    }

    public function register($data = []) {

        // get array keys (field names)
        $arrayKeys = array_keys($data);
 
        // get field name paramaters (:fieldname)
        $arrayOfParams = array_map(
                            function($val) {
                                return ':' . $val;
                            }, 
                            $arrayKeys
                        );

        // join parameters (:fn1, :fn2 ...)
        $paramString = implode(', ', $arrayOfParams);
        
        // set query string
        $this->db->setQuery("INSERT INTO students(student_fname,student_mname,student_lname,student_gender)
                                VALUES($paramString)");
        
        // bind values
        for($i=0 ; $i<count($arrayOfParams) ; $i++) {
            $this->db->bindValue($arrayOfParams[$i], $data[$arrayKeys[$i]]);
        }

        // execute
        return $this->db->execute();
    }

    public function getStudentData($id) {
        $this->db->setQuery("SELECT * FROM students WHERE student_id=:id");
        $this->db->bindValue(':id', $id);

        $data = $this->db->getSingleRecord();

        return $data;
    }

    public function edit($data = []) {

        // get field names (fname)
        $fieldNames = array_keys($data);

        // get db field name (student_fname)
        $dbFieldNames = array_map(function($field) {
            return 'student_' . $field;
        }, $fieldNames);

        // generate field params (:fieldname)
        $fieldParams = array_map(function($field) {
            return ':' . $field;
        }, $fieldNames);

        // generate param array
        $paramArray = [];
        $studID = '';
        foreach ($fieldNames as $key => $value) {
            // exclude student_id
            if(!($value == 'id')) {
                $str = $dbFieldNames[$key] . '=' . $fieldParams[$key];
                array_push($paramArray, $str);
            } else {
                $studID = $dbFieldNames[$key] . '=' . $fieldParams[$key];
            }
        }

        // convert to param string
        $paramString = implode(', ', $paramArray);

        //set query
        $this->db->setQuery("UPDATE students SET $paramString WHERE $studID");

        // echo("UPDATE students SET $paramString WHERE $studID");
        
        for($i=0 ; $i<count($fieldNames) ; $i++) {
            $this->db->bindValue($fieldParams[$i], $data[$fieldNames[$i]]);
        }

        // execute
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->setQuery("DELETE FROM students WHERE student_id=:id");
        $this->db->bindValue(':id', $id);

        // execute
        return $this->db->execute();
    }

}