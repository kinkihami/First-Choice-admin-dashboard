<?php
require_once '../database.php';

class Functions extends Database
{

  protected $tableName = 'orders';

  /**
   * function is used to get records
   * @param int $stmt
   * @param int @limit
   * @return array $results
   */

  public function getRows($start = 0, $limit = 15)
  {
    $sql = "SELECT orders.id, orders.orderdate, orders.totalamount, orders.area, orders.status , dealers.ownername , dealers.shopname, dealers.mobile, dealers.whatsappnumber, dealers.shopaddress FROM {$this->tableName} INNER JOIN dealers ON orders.username=dealers.username ORDER BY id DESC LIMIT {$start},{$limit}";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {

      $results = [];
    }
    return $results;
  }



  // //add data
  // /**
  //  * Function to add a record
  //  * @param array $data
  //  * @return int $lastInsertedId
  //  */
  // public function addarea($data)
  // {
  //   if (!empty($data)) {
  //     $fields = $placeholders = [];
  //     foreach ($data as $field => $value) {
  //       $fields[] = $field;
  //       $placeholders[] = ":{$field}";
  //     }

  //     $sql = "INSERT INTO {$this->tableName} (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
  //     $stmt = $this->conn->prepare($sql);
  //     try {
  //       $this->conn->beginTransaction();
  //       $stmt->execute($data);
  //       $lastInsertedId = $this->conn->lastInsertId();
  //       $this->conn->commit();
  //       return $lastInsertedId;
  //     } catch (PDOException $e) {
  //       $this->conn->rollBack();
  //       error_log($e->getMessage(), 3, 'error.log');
  //       return false;
  //     }
  //   }
  //   return false;
  // }

  // //update fields 

  // public function update($data, $id)
  // {
  //   if (!empty($data)) {
  //     $fileds = '';
  //     $x = 1;
  //     $filedsCount = count($data);
  //     foreach ($data as $field => $value) {
  //       $fileds .= "{$field}=:{$field}";
  //       if ($x < $filedsCount) {
  //         $fileds .= ", ";
  //       }
  //       $x++;
  //     }
  //   }
  //   $sql = "UPDATE {$this->tableName} SET {$fileds} WHERE id=:id";
  //   $stmt = $this->conn->prepare($sql);
  //   try {
  //     $this->conn->beginTransaction();
  //     $data['id'] = $id;
  //     $stmt->execute($data);
  //     $this->conn->commit();
  //   } catch (PDOException $e) {
  //     echo "Error: " . $e->getMessage();
  //     $this->conn->rollback();
  //   }

  // }

  //get fields from table
  public function getRow($field, $value)
  {

    $sql = "SELECT * FROM {$this->tableName}  WHERE {$field}=:{$field}";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([":{$field}" => $value]);
    if ($stmt->rowCount() > 0) {
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      $result = [];
    }

    return $result;
  }



  public function getCount()
    {
        $sql = "SELECT count(*) as pcount FROM {$this->tableName}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['pcount'];
    }
}



?>