<?php

    function getInformation($table_name, $column_name, $val, $opt)
    {
        return \DB::table($table_name)->where([
            "$column_name" => $val
        ])->$opt();
    }

    function getDoubleCondition($table_name, $column_one, $value1, $column_two, $value2, $opt)
    {
        return \DB::table($table_name)->where([
            "$column_one" => $value1, "$column_two" => $value2
        ])->$opt();
    }

?>
