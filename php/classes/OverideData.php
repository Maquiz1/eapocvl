<?php
class OverideData
{
    private $_pdo;
    function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host=' . config::get('mysql/host') . ';dbname=' . config::get('mysql/db'), config::get('mysql/username'), config::get('mysql/password'));
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    public function unique($table, $field, $value)
    {
        if ($this->get($table, $field, $value)) {
            return true;
        } else {
            return false;
        }
    }

    public function getNo($table)
    {
        $query = $this->_pdo->query("SELECT * FROM $table");
        $num = $query->rowCount();
        return $num;
    }

    public function getCount($table, $field, $value)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $field = '$value'");
        $num = $query->rowCount();
        return $num;
    }

    public function getCount1($table, $field, $value, $field1, $value1)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $field = '$value' AND $field1 = '$value1'");
        $num = $query->rowCount();
        return $num;
    }

    public function countData($table, $field, $value, $field1, $value1)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $field = '$value' AND $field1 = '$value1'");
        $num = $query->rowCount();
        return $num;
    }

    public function countData1($table, $field, $value, $field1, $value1, $field2, $value2)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $field = '$value' AND $field1 = '$value1' AND $field2 = '$value2'");
        $num = $query->rowCount();
        return $num;
    }

    public function countData2($table, $field, $value, $field1, $value1)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $field < '$value' AND $field1 = '$value1'");
        $num = $query->rowCount();
        return $num;
    }

    public function countData3($table, $field, $value, $field1, $value1, $field2, $value2)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $field < '$value' AND $field1 = '$value1' AND $field2 = '$value2'");
        $num = $query->rowCount();
        return $num;
    }

    public function getData($table)
    {
        $query = $this->_pdo->query("SELECT * FROM $table");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getData2($table, $field, $value)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $field = '$value'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getNews($table, $where, $id, $where2, $id2)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $where = '$id' AND $where2 = '$id2'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getNewsAsc($table, $where, $id, $where2, $id2)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $where = '$id' AND $where2 = '$id2' ORDER id ASC ");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNewsAsc1($table, $where, $id, $where2, $id2)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $where < '$id' AND $where2 = '$id2' ORDER id ASC ");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNewsAsc2($table, $where, $id, $where2, $id2, $where3, $id3)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $where < '$id' AND $where2 = '$id2' AND $where3 = '$id3' ORDER id ASC ");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get3($table, $where, $id, $where2, $id2, $where3, $id3)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $where = '$id' AND $where2 = '$id2' AND $where3 = '$id3'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getSumD($table, $variable)
    {
        $query = $this->_pdo->query("SELECT SUM($variable) FROM $table");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getSumD1($table, $variable, $field, $value)
    {
        $query = $this->_pdo->query("SELECT SUM($variable) FROM $table WHERE $field = '$value' ");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get($table, $where, $id)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $where = '$id'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRQ1($table)
    {
        $query = $this->_pdo->query("SELECT * FROM $table");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get_new($table, $where, $id, $where1, $type)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $where = '$id' AND $where1 = '$type'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function delete($table, $field, $value)
    {
        return $this->_pdo->query("DELETE FROM $table WHERE $field = $value");
    }

    public function lastRow($table, $value)
    {
        $query = $this->_pdo->query("SELECT * FROM $table ORDER BY $value DESC LIMIT 1");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getlastRow($table, $where, $value, $id)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE  $where='$value' ORDER BY $id DESC LIMIT 1");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getlastRow1($table, $where, $value, $where1, $value1, $id)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE  $where='$value' AND $where1='$value1' ORDER BY $id DESC LIMIT 1");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getWithLimit4($table, $field, $value, $field1, $value1, $value2, $field2, $page, $numRec)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $field < '$value' AND $field1 = '$value1' AND $value2 = '$field2' limit $page,$numRec");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getWithLimit3($table, $field, $value, $field1, $value1, $page, $numRec)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $field < '$value' AND $field1 = '$value1' limit $page,$numRec");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getWithLimit2($table, $field, $value, $field1, $value1, $value2, $field2, $page, $numRec)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $field = '$value' AND $field1 = '$value1' AND $value2 = '$field2' limit $page,$numRec");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getWithLimit1($table, $where, $id, $where2, $id2, $page, $numRec)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $where = '$id' AND $where2 = '$id2' limit $page,$numRec");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getWithLimit($table, $where, $id, $page, $numRec)
    {
        $query = $this->_pdo->query("SELECT * FROM $table WHERE $where = '$id' limit $page,$numRec");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function tableHeader($table)
    {
        $query = $this->_pdo->query("DESCRIBE $table");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    function UpdateSiteStaus($table, $status, $value)
    {
        $query = $this->_pdo->query("UPDATE $table SET $status = '$value' WHERE 1");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    function FollowUpList0()
    {
        $query = $this->_pdo->query("SELECT t1.id ,t1.enrollment_date,t1.enrollment_id , t1.firstname , t1.lastname, t1.phone_number, t2.client_id, t2.expected_date, t2.visit_date, t2.visit_name,t1.site_id FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id WHERE t1.status = '1' AND t2.expected_date <= '2023-10-05' AND t2.visit_code = 'M6'");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    function FollowUpList()
    {
        $query = $this->_pdo->query("SELECT t1.id AS 'NO.',t1.enrollment_date AS 'ENROLLMENT DATE',t1.enrollment_id AS 'PATIENT ID', t1.firstname AS 'FIRST NAME' , t1.lastname AS 'LAST NAME', t1.phone_number AS 'PHONE NUMBER', t2.client_id 'PATIENT ID', t2.expected_date AS 'EXPECTED DATE', t2.visit_date AS 'VISIT DATE', t2.visit_name AS 'VISIT NAME',t1.site_id AS 'SITE NAME' FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id WHERE t1.status = '1' AND t2.expected_date <= '2023-10-05' AND t2.visit_code = 'M6'");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    function FollowUpList1($date)
    {
        $query = $this->_pdo->query("SELECT t1.id AS 'NO.',t1.enrollment_date AS 'ENROLLMENT DATE',t1.enrollment_id AS 'PATIENT ID', t1.firstname AS 'FIRST NAME' , t1.lastname AS 'LAST NAME', t1.phone_number AS 'PHONE NUMBER', t2.client_id 'PATIENT ID', t2.expected_date AS 'EXPECTED DATE', t2.visit_date AS 'VISIT DATE', t2.visit_name AS 'VISIT NAME',t1.site_id AS 'SITE NAME' FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id WHERE t1.status = '1' AND t2.expected_date <= '$date' AND t2.visit_code = 'M6'");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    function FollowUpList2($site, $date)
    {
        $query = $this->_pdo->query("SELECT t1.id AS 'NO.',t1.enrollment_date AS 'ENROLLMENT DATE',t1.enrollment_id AS 'PATIENT ID', t1.firstname AS 'FIRST NAME' , t1.lastname AS 'LAST NAME', t1.phone_number AS 'PHONE NUMBER', t2.client_id 'PATIENT ID', t2.expected_date AS 'EXPECTED DATE', t2.visit_date AS 'VISIT DATE', t2.visit_name AS 'VISIT NAME',t1.site_id AS 'SITE NAME' FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id WHERE t1.status = '1' AND t1.sitte_id <= '$site' AND t2.expected_date <= '$date' AND t2.visit_code = 'M6'");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    public function FollowUpList3()
    {
        $query = $this->_pdo->query("SELECT t1.id AS NO,
       t1.enrollment_date AS ENROLLMENT_DATE,
       t1.enrollment_id AS PATIENT_ID,
       t1.firstname AS FIRST_NAME ,
       t1.lastname AS LAST_NAME,
       t1.phone_number AS PHONE_NUMBER,
       t2.client_id AS CLIENT_ID,
       t2.expected_date AS EXPECTED_DATE,
       t2.visit_date AS VISIT_DATE,
       t2.visit_name AS VISIT_NAME,
       t1.site_id AS SITE_NAME
FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id
WHERE t1.status = '1' AND t2.expected_date <= '2023-10-05' AND t2.visit_code = 'M6'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function FollowUpList4($date)
    {
        $query = $this->_pdo->query("SELECT t1.id AS NO,
       t1.enrollment_date AS ENROLLMENT_DATE,
       t1.enrollment_id AS PATIENT_ID,
       t1.firstname AS FIRST_NAME ,
       t1.lastname AS LAST_NAME,
       t1.phone_number AS PHONE_NUMBER,
       t2.client_id AS CLIENT_ID,
       t2.expected_date AS EXPECTED_DATE,
       t2.visit_date AS VISIT_DATE,
       t2.visit_name AS VISIT_NAME,
       t1.site_id AS SITE_NAME
FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id
WHERE t1.status = '1' AND t2.expected_date <= '$date' AND t2.visit_code = 'M6' ORDER BY t1.site_id,t2.expected_date");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function FollowUpList4Count($date)
    {
        $query = $this->_pdo->query("SELECT t1.id AS NO,
       t1.enrollment_date AS ENROLLMENT_DATE,
       t1.enrollment_id AS PATIENT_ID,
       t1.firstname AS FIRST_NAME ,
       t1.lastname AS LAST_NAME,
       t1.phone_number AS PHONE_NUMBER,
       t2.client_id AS CLIENT_ID,
       t2.expected_date AS EXPECTED_DATE,
       t2.visit_date AS VISIT_DATE,
       t2.visit_name AS VISIT_NAME,
       t1.site_id AS SITE_NAME
FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id
WHERE t1.status = '1' AND t2.expected_date <= '$date' AND t2.visit_code = 'M6' ORDER BY t1.site_id,t2.expected_date");
        $num = $query->rowCount();
        return $num;
    }


    public function FollowUpList5($site, $date)
    {
        $query = $this->_pdo->query("SELECT t1.id AS NO,
       t1.enrollment_date AS ENROLLMENT_DATE,
       t1.enrollment_id AS PATIENT_ID,
       t1.firstname AS FIRST_NAME ,
       t1.lastname AS LAST_NAME,
       t1.phone_number AS PHONE_NUMBER,
       t2.client_id AS CLIENT_ID,
       t2.expected_date AS EXPECTED_DATE,
       t2.visit_date AS VISIT_DATE,
       t2.visit_name AS VISIT_NAME,
       t1.site_id AS SITE_NAME
FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id
WHERE t1.status = '1' AND t1.site_id = '$site'  AND t2.expected_date <= '$date' AND t2.visit_code = 'M6'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function FollowUpList5Count($site, $date)
    {
        $query = $this->_pdo->query("SELECT t1.id AS NO,
       t1.enrollment_date AS ENROLLMENT_DATE,
       t1.enrollment_id AS PATIENT_ID,
       t1.firstname AS FIRST_NAME ,
       t1.lastname AS LAST_NAME,
       t1.phone_number AS PHONE_NUMBER,
       t2.client_id AS CLIENT_ID,
       t2.expected_date AS EXPECTED_DATE,
       t2.visit_date AS VISIT_DATE,
       t2.visit_name AS VISIT_NAME,
       t1.site_id AS SITE_NAME
FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id
WHERE t1.status = '1' AND t1.site_id = '$site'  AND t2.expected_date <= '$date' AND t2.visit_code = 'M6'");
        $num = $query->rowCount();
        return $num;
    }

    public function FollowUpList6($date, $date2)
    {
        $query = $this->_pdo->query("SELECT t1.id AS NO,
       t1.enrollment_date AS ENROLLMENT_DATE,
       t1.enrollment_id AS PATIENT_ID,
       t1.firstname AS FIRST_NAME ,
       t1.lastname AS LAST_NAME,
       t1.phone_number AS PHONE_NUMBER,
       t2.client_id AS CLIENT_ID,
       t2.expected_date AS EXPECTED_DATE,
       t2.visit_date AS VISIT_DATE,
       t2.visit_name AS VISIT_NAME,
       t1.site_id AS SITE_NAME
        FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id
        WHERE t1.status = '1' AND t2.expected_date >= '$date' AND t2.expected_date <= '$date2' AND t2.visit_code = 'M6'");  
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function FollowUpList6Count($date, $date2)
    {
        $query = $this->_pdo->query("SELECT t1.id AS NO,
       t1.enrollment_date AS ENROLLMENT_DATE,
       t1.enrollment_id AS PATIENT_ID,
       t1.firstname AS FIRST_NAME ,
       t1.lastname AS LAST_NAME,
       t1.phone_number AS PHONE_NUMBER,
       t2.client_id AS CLIENT_ID,
       t2.expected_date AS EXPECTED_DATE,
       t2.visit_date AS VISIT_DATE,
       t2.visit_name AS VISIT_NAME,
       t1.site_id AS SITE_NAME
        FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id
        WHERE t1.status = '1' AND t2.expected_date >= '$date' AND t2.expected_date <= '$date2' AND t2.visit_code = 'M6'");
        $num = $query->rowCount();
        return $num;
    }

    public function FollowUpList7($date, $date2, $site)
    {
        $query = $this->_pdo->query("SELECT t1.id AS NO,
       t1.enrollment_date AS ENROLLMENT_DATE,
       t1.enrollment_id AS PATIENT_ID,
       t1.firstname AS FIRST_NAME ,
       t1.lastname AS LAST_NAME,
       t1.phone_number AS PHONE_NUMBER,
       t2.client_id AS CLIENT_ID,
       t2.expected_date AS EXPECTED_DATE,
       t2.visit_date AS VISIT_DATE,
       t2.visit_name AS VISIT_NAME,
       t1.site_id AS SITE_NAME
        FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id
        WHERE t1.status = '1' AND t1.site_id = '$site' AND t2.expected_date >= '$date' AND t2.expected_date <= '$date2' AND t2.visit_code = 'M6'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function FollowUpList7Count($date, $date2,$site )
    {
        $query = $this->_pdo->query("SELECT t1.id AS NO,
       t1.enrollment_date AS ENROLLMENT_DATE,
       t1.enrollment_id AS PATIENT_ID,
       t1.firstname AS FIRST_NAME ,
       t1.lastname AS LAST_NAME,
       t1.phone_number AS PHONE_NUMBER,
       t2.client_id AS CLIENT_ID,
       t2.expected_date AS EXPECTED_DATE,
       t2.visit_date AS VISIT_DATE,
       t2.visit_name AS VISIT_NAME,
       t1.site_id AS SITE_NAME
        FROM clients AS t1 INNER JOIN visit AS t2 ON t1.id = t2.client_id
        WHERE t1.status = '1' AND t1.site_id = '$site' AND t2.expected_date >= '$date' AND t2.expected_date <= '$date2' AND t2.visit_code = 'M6'");
        $num = $query->rowCount();
        return $num;
    }
}
