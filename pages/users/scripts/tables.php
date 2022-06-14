<?php

    $alertFlag =false;

    function getAllTablesCount($link) {
        $query = "SELECT SUM(quantity) as quantity FROM rms_tables WHERE status = '1'";
        $result = mysqli_query($link, $query);

        return $result;
    }

    function getBookedTablesCount($link, $date) {
        $query = "SELECT 
                    SUM(quantity) as quantity
                FROM rms_booked_tables 
                WHERE status = 'booked' 
                AND date(created_at) = '".$date."'";

        $result = mysqli_query($link, $query);

        return $result;
    }

    function getAllTables($link) {
        $query = "SELECT * FROM rms_tables WHERE status = '1'";
        $result = mysqli_query($link, $query);

        return $result;
    }

    function getTotalBookedTableQuantity($link, $date) {
        
        $query = "SELECT 
                    bt.table_id, 
                    t.type, 
                    t.quantity, 
                    sum(bt.quantity) as booked_quantity 
                FROM rms_booked_tables bt
                JOIN rms_tables t on t.id = bt.table_id
                WHERE bt.status = 'booked'
                AND date(bt.created_at) = '".$date."'
                GROUP BY bt.table_id";
        
        $result = mysqli_query($link, $query);

        return $result;
    }

    function getBookedTables($link, $userData, $date) {
        $query = "SELECT bt.table_id, t.type, bt.quantity, bt.status, bt.created_at
                    FROM rms_booked_tables bt
                    JOIN rms_tables t ON t.id = bt.table_id
                    WHERE bt.user_id = ". (int) $userData['id'].
                    " AND bt.status = 'booked' 
                    AND date(bt.created_at) = '".$date."'";

        $result = mysqli_query($link, $query);

        $alertFlag = true;

        return $result;
    }
?>
