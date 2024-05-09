<?php

class lighting extends connection
{
    private $currentFilter;
    public function __construct()
    {
        session_start();
        parent::connect();
        if (isset($_POST["filter"])) {
            $this->currentFilter =  $_POST["filter"];
            $_SESSION["currentFilter"] = $_POST["filter"];
        } elseif (isset($_SESSION["currentFilter"])) {
            $this->currentFilter = $_SESSION["currentFilter"];
        } else {
            $this->currentFilter = "all";
            $_SESSION["currentFilter"] = $this->currentFilter;
        }
    }
}



    public function importarLamps($file)
    {
        $fichero = 'lighting.csv';
        $gestor = fopen($fichero, "r");
        $query = "INSERT INTO lamps (lamp_Id, lamp_name, lamp_Model, lamp_zone, lamp_On) VALUES (?, ?, ?, ?, ?)";

        $statement = $this->conn->prepare($query);

        if ($gestor !== false) {
            while (($element = fgetcsv($gestor)) !== false) {
                $statement->bind_param("issss", $element[0], $element[1], $element[2],  $element[3],  $element[4]);
                $statement->execute();
            }
            fclose($gestor);
        }
    }

    function deleteList()
    {
        $conn = $this->getConn();
        $query = "DELETE FROM lighting ";
        $conn->query($query);
    }

    function init()
    {
        $this->deleteList();
        $this->importarLamps();
    }





    private function getModelId($modelPartNumber)
    {
        $sql = "SELECT model_id FROM lamp_models WHERE model_part_number = '$modelPartNumber'";
        return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC)["model_id"];
    }

    private function getZoneId($zoneName)
    {
        $sql = "SELECT zone_id FROM zones WHERE zone_name = '$zoneName'";
        return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC)["zone_id"];
    }



    function getAllLamps()
    {
        $query = "SELECT * FROM lamps";
        $result = $this->conn->query($query);

        $tareas = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tareas[] = $row;array_push($lamps, new Lamp(
                    $lamp["lamp_id"],
                    $lamp["lamp_name"],
                    ($lamp["lamp_on"] == 1 ? true : false),
                    $lamp["model_part_number"],
                    $lamp["model_potencia"],
                    $lamp["zone_name"]
                ));
        }

        return $tareas;
    }


    public function changeStatus($id, $status)
    {
        try {
            $stmtInsert = $this->conn->prepare("UPDATE lamps SET lamp_on = ? WHERE lamp_id = ?");
            $stmtInsert->bindParam(1, $status, PDO::PARAM_BOOL);
            $stmtInsert->bindParam(2, $id, PDO::PARAM_INT);

            $stmtInsert->execute();
            $stmtInsert->debugDumpParams();
            return $stmtInsert->rowCount();
        } catch (Exception | PDOException $e) {
            echo 'Falló la actualización: ' . $e->getMessage();
        }
    }


    public function drawLampsList()
    {
        $lamps = $this->getAllLamps();
        $output = "";
        foreach ($lamps as $lamp) {
            $state = $lamp->getLampOn() ? "on" : "off";
            $changeState = $lamp->getLampOn() ? "off" : "on";
            $output .= "<div class='element $state'>";
            $output .= "<h4><a href='changestatus.php?id=" . $lamp->getLampId() . "&status=$changeState'><img src='img/bulb-icon-$state.png'></a> " . $lamp->getLampName() . "</h4>";
            $output .= "<h1>" . $lamp->getModelPotencia() . " W.</h1>";
            $output .= "<h4>" . $lamp->getZoneName() . "</h4>";
            $output .= "</div>";
        }
        return $output;
    }



    public function drawZonesOptions()
    {
        $selectedZone =  $this->currentFilter;
        $sql = "SELECT * FROM zones";
        $zones = $this->conn->query($sql)->fetchAll();
        $output = "<option value='all'>All</option>";
        foreach ($zones as $zone) {
            $selected = ($zone["zone_id"] == $selectedZone) ? "selected='selected'" : "";
            $output .= "<option value='" . $zone["zone_id"] . "' $selected>" . $zone["zone_name"] . "</option>";
        }
        return $output;
    }

}





/*  FUNCIÓ importLamps amb PDO per si acas

public function importLamps($file)
    {
        try {
            $this->conn->beginTransaction();
            $sqlDelete = "DELETE FROM lamps";
            $rowsDeleted = $this->conn->exec($sqlDelete);

            echo "Filas borradas " . $rowsDeleted . "<br>";
            $lampId = "";
            $lampName = "";
            $lampModel = "";
            $lampzone = "";
            $lampOn = "";
            $stmtInsert = $this->conn->prepare("INSERT INTO lamps VALUES(?,?,?,?,?)");
            $stmtInsert->bindParam(1, $lampId, PDO::PARAM_INT);
            $stmtInsert->bindParam(2, $lampName, PDO::PARAM_STR);
            $stmtInsert->bindParam(3, $lampModel, PDO::PARAM_INT);
            $stmtInsert->bindParam(4, $lampzone, PDO::PARAM_INT);
            $stmtInsert->bindParam(5, $lampOn, PDO::PARAM_BOOL);

            $gestor = fopen($file, "r");
            $linesCount = 0;
            while (($element = fgetcsv($gestor)) !== false) {
                $lampId = $element[0];
                $lampName = $element[1];
                $lampModel = $this->getModelId($element[2]);
                $lampzone = $this->getZoneId($element[3]);
                $lampOn = ($element[4] == 'on') ? true : false;

                $stmtInsert->execute();
                $linesCount++;
            }
            fclose($gestor);
            echo "Filas importadas con éxito " . $linesCount . "<br>";
            $this->conn->commit();
        } catch (Exception | PDOException $e) {
            echo 'Falló la importación: ' . $e->getMessage();
            $stmtInsert->debugDumpParams();
        }
    }






