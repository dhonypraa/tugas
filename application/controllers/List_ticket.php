<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_ticket extends CI_Controller
{
    public function __construct()
    {
          parent::__construct();
          //Meload model_app
          $this->load->model('model_app');
          $this->load->library('vigenere');
          $this->load->helper('encrypt');


          //Jika session tidak ditemukan
          if (!$this->session->userdata('id_user')) {
              //Kembali ke halaman Login
              $this->session->set_flashdata('status1', 'expired');
              redirect('login');
          }
    }

    //////////////////////////////////////////////////////////////Bagian List Ticket//////////////////////////////////////////////////////////////
    public function index()
    {
        //User harus admin, tidak boleh role user lain
        if($this->session->userdata('level') == "Admin"){
            //Menyusun template List Ticket
            $data['title']    = "Daftar Semua Tiket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/allticket";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Daftar semua tiket, get dari model_app (all_ticket), data akan ditampung dalam parameter 'listticket'
            $object = array();
            foreach ($this->model_app->all_ticket()->result() as $value) {
              array_push($object, (object) array(
                'id_ticket' => $value->id_ticket,
                'status' => $value->status,
                'tanggal' => $value->tanggal,
                'last_update' => $value->last_update,
                'id_kondisi' => $value->id_kondisi,
                'deadline' => $value->deadline,
                'teknisi' => $value->teknisi,
                'problem_summary' => decryptAES_vigenere($value->problem_summary),
                'filefoto' => $value->filefoto,
                'nama_sub_kategori' => $value->nama_sub_kategori,
                'nama_kategori' => $value->nama_kategori,
                'nama' => decryptAES_vigenere($value->nama),
                'nama_dept' => $value->nama_dept,
                'nama_kondisi' => $value->nama_kondisi,
                'warna' => $value->warna,
                'waktu_respon' => $value->waktu_respon,
                'lokasi' => $value->lokasi,
                'nama_jabatan' => $value->nama_jabatan,
                'nama_teknisi' => decryptAES_vigenere($value->nama_teknisi),
                'warna' => $value->warna,
              ));
            }
            $data['listticket'] = (object) $object;

            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    public function detail_ticket($id)
    {
        //User harus admin, tidak boleh role user lain
        if($this->session->userdata('level') == "Admin"){
            //Menyusun template Detail Ticket
            $data['title']    = "Detail Ticket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/detail";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Detail setiap tiket, get dari model_app (detail_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'detail'
			$DataMentah = $this->model_app->detail_ticket($id)->row_array();
			$DataMentah['problem_summary'] = decryptAES_vigenere($DataMentah['problem_summary']);
			$DataMentah['problem_detail'] = decryptAES_vigenere($DataMentah['problem_detail']);
			$DataMentah['nama'] = decryptAES_vigenere($DataMentah['nama']);
			$DataMentah['email'] = decryptAES_vigenere($DataMentah['email']);
            $DataMentah['nama_teknisi'] = decryptAES_vigenere($DataMentah['nama_teknisi']);
			$data['detail'] = $DataMentah;
            //Tracking setiap tiket, get dari model_app (tracking_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'tracking'
           // $data['tracking'] = $this->model_app->tracking_ticket($id)->result();
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
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    //////////////////////////////////////////////////////////////Bagian Ticket Recieved//////////////////////////////////////////////////////////////
    public function list_approve()
    {
        //User harus admin, tidak boleh role user lain
        if($this->session->userdata('level') == "Admin"){
            //Menyusun template List Approval Ticket
            $data['title']    = "Tiket Diterima";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/listapprove";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Daftar semua tiket yang dalam approval, get dari model_app (approve_ticket) dengan parameter id_user, karena hanya id_user dengan level admin yang dapat melihat daftar ini, data akan ditampung dalam parameter 'approve'
            $data['approve'] = $this->model_app->approve_ticket($id_user)->result();
            //print_r($data['approve']);
            $object = array();
            foreach ($this->model_app->approve_ticket($id_user)->result() as $value) {
              array_push($object, (object) array(
                'status' => $value->status,
                'id_ticket' => $value->id_ticket,
                'tanggal' => $value->tanggal,
                'id_kondisi' => $value->id_kondisi,
                'deadline' => $value->deadline,
                'nama' => decryptAES_vigenere($value->nama),
                'problem_detail' => decryptAES_vigenere($value->problem_detail),
                'problem_summary' => decryptAES_vigenere($value->problem_summary),
                'filefoto' => $value->filefoto,
                'nama_sub_kategori' => $value->nama_sub_kategori,
                'nama_kategori' => $value->nama_kategori,
                'nama' => decryptAES_vigenere($value->nama),
                'nama_dept' => $value->nama_dept,
                'nama_kondisi' => $value->nama_kondisi,
                'warna' => $value->warna,
                'lokasi' => $value->lokasi,
                'nama_jabatan' => $value->nama_jabatan,
              ));
            }
            $data['approve'] = (object) $object;

            //Load template
            $this->load->view('template', $data);
            $this->session->set_flashdata('status');
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    public function detail_approve($id)
    {
        //User harus admin, tidak boleh role user lain
        if($this->session->userdata('level') == "Admin"){
            //Menyusun template Detail Ticket yang belum di-approve
            $data['title']    = "Detail Tiket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/detailapprove";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Detail setiap tiket yang belum di-approve, get dari model_app (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
			$DataMentah = $this->model_app->detail_ticket($id)->row_array();
			$DataMentah['problem_summary'] = decryptAES_vigenere($DataMentah['problem_summary']);
			$DataMentah['problem_detail'] = decryptAES_vigenere($DataMentah['problem_detail']);
			$DataMentah['nama'] = decryptAES_vigenere($DataMentah['nama']);
			$DataMentah['email'] = decryptAES_vigenere($DataMentah['email']);
            $DataMentah['nama_teknisi'] = decryptAES_vigenere($DataMentah['nama_teknisi']);
			$data['detail'] = $DataMentah;
            //print_r($data['detail']);
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
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    public function setPriority($id)
    {
        if($this->session->userdata('level') == "Admin"){
            //Menyusun template Detail Ticket yang belum di-approve
            $data['title']    = "Tetapkan Prioritas dan Teknisi";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/setPriority";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            $nama   = $this->input->post('nama');
            $email  = $this->input->post('email');

            //Detail setiap tiket yang belum di-approve, get dari model_app (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
            //$data['detail'] = $this->model_app->detail_ticket($id)->row_array();
			$DataMentah = $this->model_app->detail_ticket($id)->row_array();
			$DataMentah['problem_summary'] = decryptAES_vigenere($DataMentah['problem_summary']);
			$DataMentah['problem_detail'] = decryptAES_vigenere($DataMentah['problem_detail']);
			$DataMentah['nama'] = decryptAES_vigenere($DataMentah['nama']);
			$DataMentah['email'] = decryptAES_vigenere($DataMentah['email']);
            $DataMentah['nama_teknisi'] = decryptAES_vigenere($DataMentah['nama_teknisi']);
			$data['detail'] = $DataMentah;

            $row = $this->model_app->detail_ticket($id)->row();
            //Dropdown pilih kondisi, menggunakan model_app (dropdown_kondisi), nama kondisi ditampung pada 'dd_kondisi', data yang akan di simpan adalah id_kondisi dan akan ditampung pada 'id_kondisi'
            $data['dd_kondisi'] = $this->model_app->dropdown_kondisi();
            $data['id_kondisi'] = "";

            //Dropdown pilih Teknisi, menggunakan model_app (dropdown_teknisi), nama teknisi ditampung pada 'dd_teknisi', dan data yang akan di simpan adalah id_user dengan level teknisi, data akan ditampung pada 'id_teknisi'
            $dataDropdown = $this->model_app->dropdown_teknisi();
            $data['dd_teknisi'] = $this->model_app->dropdown_teknisi();

            $data['id_teknisi'] = "";

            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    public function approve($id)
    {
        //Form validasi untuk kondisi dengan nama validasi = id_kondisi
        $this->form_validation->set_rules('id_kondisi', 'Id_kondisi', 'required',
            array(
                'required' => '<div class="alert alert-danger alert-dismissable">
                                    <strong>Failed!</strong> Please Choose the Priority.
                               </div>'
            )
        );

        $this->form_validation->set_rules('id_teknisi', 'Id_teknisi', 'required',
            array(
                'required' => '<div class="alert alert-danger alert-dismissable">
                                    <strong>Failed!</strong> Please choose the technician.
                               </div>'
            )
        );

        if($this->form_validation->run() == FALSE){
            if($this->session->userdata('level') == "Admin"){
                //Menyusun template Detail Ticket yang belum di-approve
                $data['title']    = "Menetapkan Prioritas dan Teknisi";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "ticket/setPriority";

                //Session
                $id_dept = $this->session->userdata('id_dept');
                $id_user = $this->session->userdata('id_user');

                $nama   = $this->input->post('nama');
                $email  = $this->input->post('email');

                //Detail setiap tiket yang belum di-approve, get dari model_app (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
                $data['detail'] = $this->model_app->detail_ticket($id)->row_array();

                $row = $this->model_app->detail_ticket($id)->row();
                //Dropdown pilih kondisi, menggunakan model_app (dropdown_kondisi), nama kondisi ditampung pada 'dd_kondisi', data yang akan di simpan adalah id_kondisi dan akan ditampung pada 'id_kondisi'
                $data['dd_kondisi'] = $this->model_app->dropdown_kondisi();
                $data['id_kondisi'] = "";

                //Dropdown pilih Teknisi, menggunakan model_app (dropdown_teknisi), nama teknisi ditampung pada 'dd_teknisi', dan data yang akan di simpan adalah id_user dengan level teknisi, data akan ditampung pada 'id_teknisi'
                $data['dd_teknisi'] = $this->model_app->dropdown_teknisi();
                $data['id_teknisi'] = "";

                //Load template
                $this->load->view('template', $data);
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        } else {
                //User harus admin, tidak boleh role user lain
            if($this->session->userdata('level') == "Admin"){
                //Proses me-approve ticket, menggunakan model_app (approve) dengan parameter id_ticket yang akan di-approve
                $this->model_app->approve($id);
                //Memanggil fungsi kirim email dari admin ke user
                //$this->model_app->emailapprove($id);
                //Memanggil fungsi kirim email dari admin ke teknisi
                //$this->model_app->emailtugas($id);
                //Set pemberitahuan bahwa tiket berhasil ditugaskan ke teknisi
                $this->session->set_flashdata('status', 'Assigned');
                //Kembali ke halaman List approvel ticket (list_approve)
                redirect('List_ticket/list_approve');
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        }
    }

    public function detail_reject($id)
    {
        //User harus admin, tidak boleh role user lain
        if($this->session->userdata('level') == "Admin"){
            //Menyusun template Detail Ticket yang akan di-reject
            $data['title']    = "Tiket Ditolak";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/detailreject";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Detail setiap tiket yang akan di-reject, get dari model_app (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
            //$data['detail'] = $this->model_app->detail_ticket($id)->row_array();
            $DataMentah = $this->model_app->detail_ticket($id)->row_array();
			$DataMentah['email'] = decryptAES_vigenere($DataMentah['email']);
			$data['detail'] = $DataMentah;
            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    public function reject($id)
    {
        //Form validasi untuk message yang akan di kirim ke email user
        $this->form_validation->set_rules('message', 'Message', 'required',
            array(
                'required' => '<div class="alert alert-danger alert-dismissable">
                                    <strong>Failed!</strong> Please Fill the Meesage.
                               </div>'
            )
        );

        if($this->form_validation->run() == FALSE){
            //User harus admin, tidak boleh role user lain
            if($this->session->userdata('level') == "Admin"){
                //Menyusun template Detail Ticket yang akan di-reject
                $data['title']    = "Tiket Ditolak";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "ticket/detailreject";

                //Session
                $id_dept = $this->session->userdata('id_dept');
                $id_user = $this->session->userdata('id_user');

                //Detail setiap tiket yang akan di-reject, get dari model_app (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
                $data['detail'] = $this->model_app->detail_ticket($id)->row_array();
                //Load template
                $this->load->view('template', $data);
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        } else {
            //User harus admin, tidak boleh role user lain
            if($this->session->userdata('level') == "Admin"){
                //Proses me-reject ticket, menggunakan model_app (reject) dengan parameter id_ticket yang akan di-reject
                $this->model_app->reject($id);
                //Memanggil fungsi kirim email dari admin ke user
                //$this->model_app->emailreject($id);
                //Set pemberitahuan bahwa ticket berhasil di-reject
                $this->session->set_flashdata('status', 'Rejected');
                //Kembali ke halaman List approvel ticket (list_approve)
                redirect('List_ticket/list_approve');   
            } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        }
    }

    public function detail_pilih_teknisi($id)
    {
        $nama   = $this->input->post('nama');
        $email  = $this->input->post('email');

        //User harus admin, tidak boleh role user lain
        if($this->session->userdata('level') == "Admin"){
            //Menyusun template Detail Ticket yang akan ditugaskan ke teknisi
            $data['title']    = "Assign Technician";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/detailpilihteknisi";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Detail setiap tiket yang akan ditugaskan ke teknisi, get dari model_app (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
            //$data['detail'] = $this->model_app->detail_ticket($id)->row_array();
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
            foreach ($data['tracking'] = $this->model_app->tracking_ticket($id)->result() as $value) {
              array_push($object, (object) array(
                'tanggal' => $value->tanggal,
                'status' => $value->status,
                'deskripsi' => $value->deskripsi,
                'filefoto' => $value->filefoto,
                'nama' => decryptAES_vigenere($value->nama),
              ));
            }
            $data['tracking'] = (object) $object;


            //Dropdown pilih Teknisi, menggunakan model_app (dropdown_teknisi), nama teknisi ditampung pada 'dd_teknisi', dan data yang akan di simpan adalah id_user dengan level teknisi, data akan ditampung pada 'id_teknisi'
            $data['dd_teknisi'] = $this->model_app->dropdown_teknisi();
            $data['id_teknisi'] = "";

            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    public function tugas($id)
    {
        //Form validasi untuk id_user dengan level teknisi dengan nama validasi = id_teknisi
        $this->form_validation->set_rules('id_teknisi', 'Id_teknisi', 'required',
            array(
                'required' => '<div class="alert alert-danger alert-dismissable">
                                    <strong>Failed!</strong> Please choose the technician.
                               </div>'
            )
        );

        //Kondisi jika saat proses penugasan tidak memenuhi syarat validasi akan dikembalikan ke halaman detail ticket yang akan ditugaskan
        if($this->form_validation->run() == FALSE){
            //User harus admin, tidak boleh role user lain
            if($this->session->userdata('level') == "Admin"){
                //Menyusun template Detail Ticket yang akan ditugaskan ke teknisi
                $data['title']    = "Assign Technician";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "ticket/detailpilihteknisi";

                //Session
                $id_dept = $this->session->userdata('id_dept');
                $id_user = $this->session->userdata('id_user');

                //Detail setiap tiket yang akan ditugaskan ke teknisi, get dari model_app (detailticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
                $data['detail'] = $this->model_app->detail_ticket($id)->row_array();

                //Dropdown pilih Teknisi, menggunakan model_app (dropdown_teknisi), nama teknisi ditampung pada 'dd_teknisi', dan data yang akan di simpan adalah id_user dengan level teknisi, data akan ditampung pada 'id_teknisi'
                $data['dd_teknisi'] = $this->model_app->dropdown_teknisi();
                $data['id_teknisi'] = "";
                
                //Load template
                $this->load->view('template', $data);
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        } else {
            //Bagian ini jika validasi terpenuhi
            //User harus admin, tidak boleh role user lain
            if($this->session->userdata('level') == "Admin"){
                //Proses menugaskan ticket ke teknisi, menggunakan model_app (input_tugas) dengan parameter id_ticket yang akan di-tugaskan
                $this->model_app->input_tugas($id);
                
                $this->model_app->emailtugas($id);
                //Set pemberitahuan bahwa tiket berhasil ditugaskan ke teknisi
                $this->session->set_flashdata('status', 'Assigned');
                //Kembali ke halaman Assign Ticket (indexpilih)
                redirect('List_ticket/list_approve');
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        }
    }
}
