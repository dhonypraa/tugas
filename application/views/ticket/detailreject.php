<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800">Tiket Ditolak</h1><hr>

	<?php echo form_error('message'); ?>
	
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">Ditolak <?php echo $detail['id_ticket']?></h6>
		</div>

		<div class="card-body">
			<form method="post" action="<?php echo site_url('List_ticket/reject/'.$detail['id_ticket'])?>" enctype="multipart/form-data">
				<div class="form-group">
					<label class="m-0 font-weight-bold text-gray-800">Penerima</label>
					<input class="form-control" name="reciepent" readonly value="<?php echo $detail['email']?>">
				</div>

				<div class="form-group">
					<label class="m-0 font-weight-bold text-gray-800">Subyek</label>
					<input class="form-control" name="subject" readonly value="<?php echo $detail['id_ticket']?>">
				</div>

				<div class="form-group">
					<h6 class="m-0 font-weight-bold text-gray-800">Pesan</h6>
					<textarea name="message" class="form-control" rows="10" id="desk"></textarea>
				</div>

				<button type="submit" class="btn btn-primary">Kirim</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?php echo site_url('List_ticket/list_approve') ?>'">Cancel</button>
			</form>
		</div>
	</div>
</div>