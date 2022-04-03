<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
include("conf.php");
include("DB.php");
include("Task.php");
include("Template.php");

// Membuat objek dari kelas task
$otask = new Task($db_host, $db_user, $db_password, $db_name);
$otask->open();

// Memanggil method getTask di kelas Task
$otask->getTask();

// Proses pengecekan apakah submit bernilai true atau tidak
if(isset($_POST['add'])){
	// value value di html akan ditampung 
	$nama = $_POST['tname'];
	$detail = $_POST['tdetails'];
	$subject = $_POST['tsubject'];
	$priority = $_POST['tpriority'];
	$deadline = $_POST['tdeadline'];
	$otask->add($nama, $deadline, $detail, $subject, $priority);
	header("location:index.php");
}

// cek apakah parameter kosong lalu eksekusi
if(isset($_GET['id_hapus'])){
	$otask->del($_GET['id_hapus']);
	header("location:index.php");
}
if(isset($_GET['id_status'])){
	$otask->setfinish($_GET['id_status']);
	header("location:index.php");
}
// Sorting
if(isset($_POST['sortingpriority'])){
	$otask->sortprior();
}
if(isset($_POST['sortingsubject'])){
	$otask->sortelse("subject_td");
}
if(isset($_POST['sortingdeadline'])){
	$otask->sortelse("deadline_td");
}
if(isset($_POST['sortingstatus'])){
	$otask->sortelse("status_td");
}
// Mereset hasil sorting sebelumnya
if(isset($_POST['sortingreset'])){
	$otask->getTask();
}
// Proses mengisi tabel dengan data
$data = null;
$no = 1;

while (list($id, $tname, $tdetails, $tsubject, $tpriority, $tdeadline, $tstatus) = $otask->getResult()) {
	// Tampilan jika status task nya sudah dikerjakan
	if($tstatus == "Sudah"){
		$data .= "<tr>
		<td>" . $no . "</td>
		<td>" . $tname . "</td>
		<td>" . $tdetails . "</td>
		<td>" . $tsubject . "</td>
		<td>" . $tpriority . "</td>
		<td>" . $tdeadline . "</td>
		<td>" . $tstatus . "</td>
		<td>
		<button class='btn btn-danger' name='hapus' ><a href='index.php?id_hapus=" . $id . "' style='color: white; font-weight: bold;'>Hapus</a></button>
		
		</td>
		</tr>";
		$no++;
	}

	// Tampilan jika status task nya belum dikerjakan
	else{
		$data .= "<tr>
		<td>" . $no . "</td>
		<td>" . $tname . "</td>
		<td>" . $tdetails . "</td>
		<td>" . $tsubject . "</td>
		<td>" . $tpriority . "</td>
		<td>" . $tdeadline . "</td>
		<td>" . $tstatus . "</td>
		<td>
		<button class='btn btn-danger' name='hapus' ><a href='index.php?id_hapus=" . $id . "' style='color: white; font-weight: bold;'>Hapus</a></button>
		<button class='btn btn-success' ><a href='index.php?id_status=" . $id .  "' style='color: white; font-weight: bold;'>Selesai</a></button>
		</td>
		</tr>";
		
		$no++;
	}
}
// Menutup koneksi database
$otask->close();

// Membaca template skin.html
$tpl = new Template("templates/skin.html");

// Mengganti kode Data_Tabel dengan data yang sudah diproses
$tpl->replace("DATA_TABEL", $data);

// Menampilkan ke layar
$tpl->write();