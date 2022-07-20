<table class="table" width="100%">
	<tr>
		<th>#</th>
		<th>Kategori</th>
		<th>Sub Kategori</th>
		<th>Reporter</th>
		<th>Progress</th>
	</tr>
	<?php $no = 0; foreach($dataassigment as $row) { $no++;?>
		<tr>
			<td><?php echo $no;?></td>
			<td><?php echo $row->nama_kategori;?></td>
			<td><?php echo $row->nama_sub_kategori;?></td>
			<td><?php echo $row->nama;?></td>
			<td><?php echo $row->progress;?></td>
		</tr>
	<?php }?>

</table>

<div class="form-group">
	<input class="form-control" name="nama" rows="3" value="<?php echo $nama?>" hidden></input>
	<input class="form-control" name="email" rows="3" value="<?php echo $email?>" hidden></input>
</div>