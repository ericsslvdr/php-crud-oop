<?php
class Read extends DatabaseConn {

    public function readEmp() {
        $sql = "SELECT * FROM empTbl";
        $results = $this->connect()->query($sql);
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $record[] = $row;
            }
        } else {
            $record = null;
        }
        return $record;
    }
}

class ReadView extends Read {
    public $isUpdate = false;

    public function showEmp() {
        $records = $this->readEmp();
        $empID = $this->isUpdate ? $_GET['updID'] : null;
        if (!empty($records)) {
            foreach ($records as $record) {
                if ($empID == $record['id']) {
                    $rowFname = '<input type="text" name="fNameUpd" value="' . $record['firstName'] . '" class="textField tfTbl">';
                    $rowLname = '<input type="text" name="lNameUpd" value="' . $record['lastName'] . '" class="textField tfTbl">';
                    $rowPnum = '<input type="text" name="pNumUpd" value="' . $record['pNum'] . '" class="textField tfTbl">';
                    $rowAddr = '<input type="text" name="addrUpd" value="' . $record['address'] . '" class="textField tfTbl">';
                    $rowBtns = '<a href="./index.php"><button type="button" class="btn btnCan">Cancel</button></a>
                                <input type="submit" class="btn btnUpd" name="updBtnConfirm" value="Update">';
                } else {
                    $rowFname = $record['firstName'];
                    $rowLname = $record['lastName'];
                    $rowPnum = $record['pNum'];
                    $rowAddr = $record['address'];
                    $rowBtns = '<a href="./index.php?delID=' . $record['id'] . '"><button type="button" class="btn btnDel">Delete</button></a>
                                <a href="./index.php?updID=' . $record['id'] . '"><button type="button" class="btn btnUpd">Update</button></a>';
                }
                echo '<form method="POST">
                        <tr>
                            <td>' . $record['id'] . '</td>
                            <td>' . $rowFname . '</td>
                            <td>' . $rowLname . '</td>
                            <td>' . $rowPnum . '</td>
                            <td>' . $rowAddr . '</td>
                            <td>
                                ' . $rowBtns . '
                                <input type="hidden" name="empID" value="' . $record['id'] . '">
                                <input type="hidden" name="fName" value="' . $record['firstName'] . '">
                                <input type="hidden" name="lName" value="' . $record['lastName'] . '">
                                <input type="hidden" name="pass" value="' . $record['pNum'] . '">
                                <input type="hidden" name="addr" value="' . $record['address'] . '">
                            </td>
                        </tr>
                    </form>';
            }
        } else {
            echo '<tr>
                    <td colspan="6">No Records Found!</td>
                </tr>';
        }
    }

    public function setValues($true) {
        $this->isUpdate = $true;
    }
}

$upd = new ReadView();

if (isset($_GET['updID'])) {
    $isUpdate = true;
    $upd->setValues($isUpdate);
}