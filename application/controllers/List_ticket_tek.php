<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_ticket_tek extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Meload model_app
		$this->load->model('model_app');
		$this->load->helper('encrypt');


		//Jika session tidak ditemukan
		if (!$this->session->userdata('id_user')) {
			//Kembali ke halaman Login
			$this->session->set_flashdata('status1', 'kadaluarsa');
			redirect('login');
		}
	}

	/////////////////////////////////////////////////////////////////////////Approval & Pending Ticket/////////////////////////////////////////////////////////////////////////

	public function index_approve()
	{
		//User harus Teknisi, tidak boleh role user lain
		if($this->session->userdata('level') == "Technician"){
			//Menyusun template List Approval
			$data['title'] 	  = "Tiket Ditugaskan";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "ticketTek/listapprove";

        	//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

        	//Daftar semua ticket yang belum di-approval oleh teknisi, get dari model_app (approve_tugas) berdasarkan id_user teknisi, data akan ditampung dalam parameter 'approve'

			$object = array();
            foreach ($this->model_app->approve_tugas($id_user)->result() as $value) {
              array_push($object, (object) array(
                'progress' => $value->progress,
                'status' => $value->status,
                'id_ticket' => $value->id_ticket,
                'reported' => $value->reported,
                'tanggal' => $value->tanggal,
				'id_kondisi' => $value->id_kondisi,
				'deadline' => $value->deadline,
                'problem_detail' => decryptAES_vigenere($value->problem_detail),
                'problem_summary' => decryptAES_vigenere($value->problem_summary),
                'filefoto' => $value->filefoto,
                'nama_sub_kategori' => $value->nama_sub_kategori,
				'nama_kategori' => $value->nama_kategori,
                'nama' => decryptAES_vigenere($value->nama),
                'nama_kondisi' => $value->nama_kondisi,
                'warna' => $value->warna,
                'lokasi' => $value->lokasi,
                'nama_dept' => $value->nama_dept,
              ));
            }
            $data['approve'] = (object) $object;
			
			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}

	public function detail_approve($id)
	{
		//User harus Teknisi, tidak boleh role user lain
		if($this->session->userdata('level') == "Technician"){
			//Menyusun template Detail ticket 
			$data['title']    = "Detail Tiket";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "ticketTek/detailapprove";

        	//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

        	//Detail setiap tiket yang belum di-approve, get dari model_app (detail_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'detail'
			//$data['detail'] = $this->model_app->detail_ticket($id)->row_array();
			//print_r($data['detail']);
			$DataMentah = $this->model_app->detail_ticket($id)->row_array();
			$DataMentah['problem_summary'] = decryptAES_vigenere($DataMentah['problem_summary']);
			$DataMentah['problem_detail'] = decryptAES_vigenere($DataMentah['problem_detail']);
			$DataMentah['nama'] = decryptAES_vigenere($DataMentah['nama']);
			$DataMentah['email'] = decryptAES_vigenere($DataMentah['email']);
            $DataMentah['nama_teknisi'] = decryptAES_vigenere($DataMentah['nama_teknisi']);
			$data['detail'] = $DataMentah;
			
			//Tracking setiap tiket, get dari model_app (tracking_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'tracking'
			//$data['tracking'] = $this->model_app->tracking_ticket($id)->result();
			$object = array();
	        foreach ($this->model_app->tracking_ticket($id)->result() as $value) {
			  array_push($object, (object) array(
			  	'tanggal' => $value->tanggal,
				'status' => $value->status,
				'deskripsi' => decryptAES_vigenere($value->deskripsi),
				'filefoto' => $value->filefoto,
			  	'nama' => decryptAES_vigenere($value->nama),
			  ));
			}
			$data['tracking'] = (object) $object;
			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}

	public function approve($id)
	{
		//User harus teknisi, tidak boleh role user lain
        if($this->session->userdata('level') == "Technician"){
        	//Proses me-approve ticket, menggunakan model_app (approve_tiket) dengan parameter id_ticket yang akan di-approve
        	$this->model_app->approve_tiket($id);

        	//$this->model_app->emaildiproses($id);
        	//Set pemberitahuan bahwa ticket berhasil di-approve
        	$this->session->set_flashdata('status', 'Process');
        	//Kembali ke halaman List approval ticket (Ticket Assigned)
        	redirect('List_ticket_tek/index_approve');
        } else {
        	//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
        }
	}

	public function pending($id)
	{
		//User harus teknisi, tidak boleh role user lain
        if($this->session->userdata('level') == "Technician"){
        	//Proses pending ticket, menggunakan model_app (pending_tugas) dengan parameter id_ticket yang akan di-pending
        	$this->model_app->pending_tugas($id);
        	//$this->model_app->emaildipending($id);
        	//Set pemberitahuan bahwa ticket berhasil di-pending
        	$this->session->set_flashdata('status', 'Ditahan');
        	//Kembali ke halaman List approval ticket (Ticket Assigned)
        	redirect('List_ticket_tek/index_approve');
        } else {
        	//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
        }
	}

	/////////////////////////////////////////////////////////////////////////List Assignment/////////////////////////////////////////////////////////////////////////

	public function index_tugas()
	{
		//User harus Teknisi, tidak boleh role user lain
		if($this->session->userdata('level') == "Technician"){
			//Menyusun template List Assignment
			$data['title'] 	  = "Daftar Tugas";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "ticketTek/listtugas";

        	//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

        	//Daftar semua ticket yang ditugaskan kepada teknisi, get dari model_app (daftar_tugas) berdasarkan id_user teknisi, data akan ditampung dalam parameter 'tugas'

			$object = array();
            foreach ($this->model_app->daftar_tugas($id_user)->result() as $value) {
              array_push($object, (object) array(
                'progress' => $value->progress,
                'status' => $value->status,
                'id_ticket' => $value->id_ticket,
                'reported' => $value->reported,
                'tanggal' => $value->tanggal,
                'tanggal_solved' => $value->tanggal_solved,
                'id_kondisi' => $value->id_kondisi,
                'deadline' => $value->deadline,
                'problem_detail' => decryptAES_vigenere($value->problem_detail),
                'problem_summary' => decryptAES_vigenere($value->problem_summary),
                'filefoto' => $value->filefoto,
                'nama_sub_kategori' => $value->nama_sub_kategori,
                'nama_kategori' => $value->nama_kategori,
                'nama' => decryptAES_vigenere($value->nama),
                'nama_kondisi' => $value->nama_kondisi,
                'warna' => $value->warna,
                'lokasi' => $value->lokasi,
                'nama_dept' => $value->nama_dept,
                'nama_jabatan' => $value->nama_jabatan,
              ));
            }
            $data['tugas'] = (object) $object;

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}

	public function detail_update($id)
	{
		//User harus Teknisi, tidak boleh role user lain
		if($this->session->userdata('level') == "Technician"){
			//Menyusun template Detail ticket
			$data['title']    = "Perbarui Progress";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "ticketTek/detailupdate";

        	//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

	        //Detail setiap tiket yang dikerjakan, get dari model_app (detail_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'detail'
			$DataMentah = $this->model_app->detail_ticket($id)->row_array();
			$DataMentah['problem_summary'] = decryptAES_vigenere($DataMentah['problem_summary']);
			$DataMentah['problem_detail'] = decryptAES_vigenere($DataMentah['problem_detail']);
			$DataMentah['nama'] = decryptAES_vigenere($DataMentah['nama']);
			$DataMentah['email'] = decryptAES_vigenere($DataMentah['email']);
            $DataMentah['nama_teknisi'] = decryptAES_vigenere($DataMentah['nama_teknisi']);
			$data['detail'] = $DataMentah;

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}

	public function update($id)
	{
		//Form validasi untuk deskripsi dengan nama validasi = desk
        $this->form_validation->set_rules('desk', 'Desk', 'required',
            array(
                'required' => '<div class="alert alert-danger alert-dismissable">
                                    <strong>Failed!</strong> Please Describe Your Progress.
                               </div>'
            )
        );

        //Kondisi jika saat proses update tidak memenuhi syarat validasi akan dikembalikan ke halaman update progress
        if($this->form_validation->run() == FALSE){
        	//User harus Teknisi, tidak boleh role user lain
        	if($this->session->userdata('level') == "Technician"){
				//Menyusun template Detail ticket
        		$data['title']    = "Perbarui Progress";
        		$data['navbar']   = "navbar";
        		$data['sidebar']  = "sidebar";
        		$data['body']     = "ticketTek/detailupdate";

        		//Session
        		$id_dept = $this->session->userdata('id_dept');
        		$id_user = $this->session->userdata('id_user');

	        	//Detail setiap tiket yang dikerjakan, get dari model_app (detail_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'detail'
        		$data['detail'] = $this->model_app->detail_ticket($id)->row_array();

				//Load template
        		$this->load->view('template', $data);
        	} else {
			//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
			//Akan dibawa ke Controller Errorpage
        		redirect('Errorpage');
        	}
        } else {
        	//Bagian ini jika validasi terpenuhi
        	//User harus Teknisi, tidak boleh role user lain
        	if($this->session->userdata('level') == "Technician"){
				//Proses update ticket, menggunakan model_app (update) dengan parameter id_ticket yang akan di-update
        		$this->model_app->update($id);
        		
        		//$this->model_app->emailselesai($id);
				//Set pemberitahuan bahwa ticket berhasil di-update
        		$this->session->set_flashdata('status', 'Diperbarui');
				//Kembali ke halaman List ticket (Assignment Ticket)
        		redirect('List_ticket_tek/index_tugas');
        	} else {
				//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
				//Akan dibawa ke Controller Errorpage
        		redirect('Errorpage');
        	}

        }	
	}

	public function changeCategory($id)
	{
		if($this->session->userdata('level') == "Technician"){
			//Menyusun template Detail ticket
			$data['title']    = "Ubah Kategori";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "ticketTek/change";

        	//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Detail setiap tiket yang dikerjakan, get dari model_app (detail_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'detail'
			//$data['detail'] = $this->model_app->detail_ticket($id)->row_array();
			$DataMentah = $this->model_app->detail_ticket($id)->row_array();
			$DataMentah['problem_summary'] = decryptAES_vigenere($DataMentah['problem_summary']);
			$DataMentah['problem_detail'] = decryptAES_vigenere($DataMentah['problem_detail']);
			$DataMentah['nama'] = decryptAES_vigenere($DataMentah['nama']);
			$DataMentah['email'] = decryptAES_vigenere($DataMentah['email']);
            $DataMentah['nama_teknisi'] = decryptAES_vigenere($DataMentah['nama_teknisi']);
			$data['detail'] = $DataMentah;
			$row = $this->model_app->detail_ticket($id)->row();

			//Dropdown pilih kategori, menggunakan model_app (dropdown_kategori), nama kategori ditampung pada 'dd_kategori', data yang akan di simpan adalah id_kategori dan akan ditampung pada 'id_kategori'
			$data['dd_kategori'] = $this->model_app->dropdown_kategori();
			$data['id_kategori'] = $row->id_kategori;

			//Dropdown pilih sub kategori, menggunakan model_app (dropdown_sub_kategori), nama kategori ditampung pada 'dd_sub_kategori', data yang akan di simpan adalah id_sub_kategori dan akan ditampung pada 'id_sub_kategori'
			$data['dd_sub_kategori'] = $this->model_app->dropdown_sub_kategori($row->id_kategori);
			$data['id_sub_kategori'] = $row->id_sub_kategori;

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}

	public function change($id)
	{
		//Form validasi untuk ketgori dengan nama validasi = id_kategori
		$this->form_validation->set_rules('id_kategori', 'Id_kategori', 'required',
			array(
				'required' => '<div class="alert alert-danger alert-dismissable">
									<strong>Failed!</strong> Please Choose the Categoty.
							   </div>'
			)
		);

		//Form validasi untuk sub kategori dengan nama validasi = id_sub_kategori
		$this->form_validation->set_rules('id_sub_kategori', 'id_sub_kategori', 'required',
			array(
				'required' => '<div class="alert alert-danger alert-dismissable">
									<strong>Failed!</strong> Please Choose the Sub Category.
							   </div>'
			)
		);
		
		//Form validasi untuk diagnosa dengan nama validasi = diagnos
		$this->form_validation->set_rules('diagnos', 'diagnos', 'required',
			array(
				'required' => '<div class="alert alert-danger alert-dismissable">
									<strong>Failed!</strong> Please Describe Your Diagnosis.
							   </div>'
			)
		);

		//Kondisi jika proses buat tiket tidak memenuhi syarat validasi akan dikembalikan ke form ganti kategori
        if($this->form_validation->run() == FALSE){
        	if($this->session->userdata('level') == "Technician"){
				//Menyusun template Detail ticket
        		$data['title']    = "Ubah Kategori";
        		$data['navbar']   = "navbar";
        		$data['sidebar']  = "sidebar";
        		$data['body']     = "ticketTek/change";

        		//Session
        		$id_dept = $this->session->userdata('id_dept');
        		$id_user = $this->session->userdata('id_user');

				//Detail setiap tiket yang dikerjakan, get dari model_app (detail_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'detail'
        		$data['detail'] = $this->model_app->detail_ticket($id)->row_array();

        		$row = $this->model_app->detail_ticket($id)->row();

				//Dropdown pilih kategori, menggunakan model_app (dropdown_kategori), nama kategori ditampung pada 'dd_kategori', data yang akan di simpan adalah id_kategori dan akan ditampung pada 'id_kategori'
        		$data['dd_kategori'] = $this->model_app->dropdown_kategori();
        		$data['id_kategori'] = $row->id_kategori;

				//Dropdown pilih sub kategori, menggunakan model_app (dropdown_sub_kategori), nama kategori ditampung pada 'dd_sub_kategori', data yang akan di simpan adalah id_sub_kategori dan akan ditampung pada 'id_sub_kategori'
        		$data['dd_sub_kategori'] = $this->model_app->dropdown_sub_kategori($row->id_kategori);
        		$data['id_sub_kategori'] = $row->id_sub_kategori;

				//Load template
        		$this->load->view('template', $data);
        	} else {
				//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
				//Akan dibawa ke Controller Errorpage
        		redirect('Errorpage');
        	}
        } else {
        	if($this->session->userdata('level') == "Technician"){
        		$this->model_app->changekategori($id);
        		$this->model_app->emailubah($id);

        		$this->session->set_flashdata('status', 'Dikembalikan');
				//Kembali ke halaman List ticket (Assignment Ticket)
        		redirect('List_ticket_tek/index_tugas');
        	} else {
        		//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
				//Akan dibawa ke Controller Errorpage
        		redirect('Errorpage');
        	}
        }
	}
}