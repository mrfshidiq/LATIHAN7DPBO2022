
<?php 

class Task extends DB{
	
	// Mengambil data
	function getTask(){
		// Query mysql select data ke tb_to_do
		$query = "SELECT * FROM tb_to_do";
		// Mengeksekusi query
		return $this->execute($query);
	}
	//metdod input/add
	function add($tname, $tdeadline, $tdetails, $tsubject, $tpriority){
		$query = "INSERT INTO tb_to_do (name_td, details_td, subject_td, priority_td, deadline_td, status_td) values ('$tname', '$tdetails', '$tsubject', '$tpriority', 
		'$tdeadline', 'Belum')";
		return $this->execute($query);
	}
	// method menghapus data
	function del($id){
		// Delete record berdasarkan ID hapus pada index (id Hapus = ID_Data)
		$query = "DELETE FROM tb_to_do where id = $id";
		return $this->execute($query);
	}
	// method ganti status finish
	function setfinish($id){
		// Mengubah status berdasrkan ID Hapus pada Index
		$query = "UPDATE tb_to_do set status_TD = 'Sudah' where id=$id";
		return $this->execute($query);
	}
	function sortprior(){
		// Proses sorting ascending secara normal
		$query = "SELECT * from tb_to_do ORDER BY case when priority_td = 'High' then 3 when priority_td ='Medium' then 2 when priority_td = 'Low' then 1 end asc";
		return $this->execute(($query));
	}
	function sortelse($string){
		$query = "SELECT * from tb_to_do order by $string ASC";
		return $this->execute(($query));
	}
	
}

?>