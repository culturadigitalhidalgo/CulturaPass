<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'cocineros_view';

// Table's primary key
$primaryKey = 'IDCocinero';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
// , esa_ap_p as , esa_ap_m as apm, estado as Estado, municipio as Municipio,  localidad as Localidad, descorigen as descorig
$columns = array(
    array('db' => 'IDCocinero', 'dt' => 0 ),
    array('db' => 'npart', 'dt' => 1),
    array('db' => 'nom',  'dt' => 2 ),
    array('db' => 'app',     'dt' => 3 ),
    array('db' => 'apm', 'dt'=> 4),
    array('db'  => 'Estado','dt' => 5),
    array('db'  => 'Municipio','dt' => 6),
    array('db'  => 'Localidad','dt' => 7),
    array('db'  => 'descorig','dt' => 8),
    array('db'  => 'idcocinero','dt' => 9),
);

// SQL server connection information
$sql_details = array(
	'user' => 'root',
	'pass' => '',
	'db'   => 'muestragastro',
	'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);


