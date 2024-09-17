<?php
require_once '../database.php';

class Functions extends Database
{

  protected $tableName = 'item';

  /**
   * function is used to get records
   * @param int $stmt
   * @param int @limit
   * @return array $results
  **/

  public function getRows($start = 0, $limit = 15)
  {
    $sql = "SELECT * FROM {$this->tableName} WHERE isactive=0 ORDER BY id DESC LIMIT {$start},{$limit}";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {

      $results = [];
    }
    return $results;
  }


  // public function searchPlayer($searchText, $start = 0, $limit = 15)
  // {

  // $sql = "SELECT * FROM {$this->tableName} WHERE isactive=0 AND (name LIKE :searchText OR itemcode like :searchText) ORDER BY id DESC LIMIT {$start},{$limit}";

      

  //     $stmt = $this->conn->prepare($sql);
  //     // Add wildcard characters for the LIKE clause
  //   $searchText = "%$searchText%";

  //   // Bind the parameters
  //   $stmt->bindParam(':searchText', $searchText, PDO::PARAM_STR);
  //   $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
  //   $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
  //    $stmt->execute();
     
  //     if ($stmt->rowCount() > 0) {
  //         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  //     } else {
  //         $results = [];
  //     }

  //     return $results;
  // }

  public function searchPlayer($searchText)
{
    // Correct SQL query with placeholders for LIMIT values
    $sql = "SELECT * FROM {$this->tableName} WHERE isactive=0 AND (name LIKE '%$searchText%' OR itemcode LIKE '%$searchText%') ORDER BY id DESC";

    $stmt = $this->conn->prepare($sql);

       // Execute the statement
    $stmt->execute();

    // Fetch results
    if ($stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $results = [];
    }

    return $results;
}




  //update fields 

  public function update($id)
  {
    
    $sql = "UPDATE {$this->tableName} SET isactive=1 WHERE id=:id";
    $stmt = $this->conn->prepare($sql);
    try {
      $this->conn->beginTransaction();
      $data['id'] = $id;
      $stmt->execute($data);
      $this->conn->commit();
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
      $this->conn->rollback();
    }

  }

  // delete row using id
  public function deleteRow($id)
  {
    $sql = "DELETE FROM {$this->tableName}  WHERE id=:id";
    $stmt = $this->conn->prepare($sql);
    try {
      $stmt->execute([':id' => $id]);
      if ($stmt->rowCount() > 0) {
        return true;
      }
    } catch (PDOException $e) {
      error_log($e->getMessage(), 3, 'error.log');
      return false;
    }

  }

  public function getCount()
    {
        $sql = "SELECT count(*) as pcount FROM {$this->tableName} WHERE isactive=0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['pcount'];
    }
}



?>