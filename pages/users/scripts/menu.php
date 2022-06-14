<?php

    function getMenuList($link) {

        $menu = [];
        $menus = [];
        $index = 0;

        $menu_query = "SELECT 
                    m.id, 
                    m.name, 
                    m.ingridents, 
                    c.name as category, 
                    t.name as type, 
                    m.price, 
                    m.status, 
                    m.created_at 
                FROM rms_menus m 
                JOIN rms_category c ON m.category_id = c.id AND c.status = '1' 
                JOIN rms_types t ON m.type = t.id and t.status = '1'
                WHERE m.status = '1'";
        $category_query = "SELECT * FROM rms_category c WHERE c.status = '1'";
        $foodType_query = "SELECT * FROM rms_types t WHERE t.status = '1'";


        $menuData = getDBData($menu_query, $link);

        $categories = getDBData($category_query, $link);

        $foodTypes = getDBData($foodType_query, $link);

        if (mysqli_num_rows($menuData) > 0) {
            // output data of each menu row
            while($row = mysqli_fetch_assoc($menuData)) {
                $menu[$index] = $row;
                $index += 1;
            }
        }


        if (mysqli_num_rows($foodTypes) > 0) {
            // output data of each menu row
            while($row = mysqli_fetch_assoc($foodTypes)) {
       
                $index = 0;
                for ($i=0; $i < count($menu); $i++) { 

                    if($row['name'] == $menu[$i]['type']){
                        $menus[$row['name']][$index] = $menu[$i];
                        $index++;
                    }
                }
            }
        }

        return $menus;
    }


    function getOrders($link, $userId) {

        $menu = [];
        $index = 0;

        $menu_query = "SELECT 
                        o.sale_id,
                        m.name, 
                        c.name AS category, 
                        t.name AS food_type, 
                        m.price,
                        o.status
                    FROM rms_orders o
                    JOIN rms_booked_tables bt ON bt.id = o.booked_tables_id AND bt.user_id = ".$userId."
                    JOIN rms_menus m ON o.menu_id = m.id 
                    JOIN rms_category c ON m.category_id = c.id
                    JOIN rms_types t ON m.type = t.id";

        $menuData = getDBData($menu_query, $link);
        
        return $menuData;
    }


    function getDBData($query, $link) {
            
        $result = mysqli_query($link, $query);

        return $result;
    }


    


?>