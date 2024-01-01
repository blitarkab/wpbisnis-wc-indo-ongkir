<?php 

$data = array();

$term = isset( $_GET['term'] ) ? htmlspecialchars( strip_tags( $_GET['term'] ) ) : '';
$term = trim( $term );

if ( !empty( $term ) && strlen( $term ) >= 3 ) {
	$term = strtolower( $term );
	if ( extension_loaded('pdo_sqlite') && class_exists('PDO') ) {
		if ( file_exists( dirname(__FILE__ ) . '/data.sqlite3') ) {
			try {
				$file_db = new PDO('sqlite:data.sqlite3');
				$file_db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$results = $file_db->query("SELECT * FROM kecamatan WHERE lower(kecamatan) LIKE '%$term%' LIMIT 30");
				foreach( $results as $row ) {
					$data[] = array(
						'id' => $row['kecamatan'].', '.$row['kota'],
						'text' => $row['kecamatan'].', '.$row['kota'].', '.$row['provinsi_kode'],
					);
				}
				if ( count( $data ) < 6 ) {
					$results = $file_db->query("SELECT * FROM kecamatan WHERE lower(kota) LIKE '%$term%' LIMIT 20");
					foreach( $results as $row ) {
						$data[] = array(
							'id' => $row['kecamatan'].', '.$row['kota'],
							'text' => $row['kecamatan'].', '.$row['kota'].', '.$row['provinsi_kode'],
						);
					}
				}
			}
			catch( PDOException $e ) {
			}
		}
	}
}

header('Content-Type: application/json');
echo json_encode( $data );
exit;
