<?php
/**
 * Plugin Name: Al-Aqsha CMS
 * Description: Tipe konten Galeri dan Pengumuman serta formulir PPDB untuk website Pondok Pesantren Al-Aqsha.
 * Version: 1.0.0
 * Requires PHP: 8.0
 * Author: Al-Aqsha Website Project
 */
if (!defined('ABSPATH')) exit;
function alaqsha_register_content_types(){
 register_post_type('aaq_announcement',array('labels'=>array('name'=>'Pengumuman','singular_name'=>'Pengumuman','add_new_item'=>'Tambah Pengumuman','edit_item'=>'Edit Pengumuman'),'public'=>true,'has_archive'=>true,'menu_icon'=>'dashicons-megaphone','supports'=>array('title','editor','thumbnail','excerpt'),'rewrite'=>array('slug'=>'pengumuman')));
 register_post_type('aaq_gallery',array('labels'=>array('name'=>'Galeri Kegiatan','singular_name'=>'Foto Galeri','add_new_item'=>'Tambah Foto/Album','edit_item'=>'Edit Foto/Album'),'public'=>true,'has_archive'=>true,'menu_icon'=>'dashicons-format-gallery','supports'=>array('title','editor','thumbnail','excerpt'),'rewrite'=>array('slug'=>'galeri')));
 register_post_type('aaq_ppdb_entry',array('labels'=>array('name'=>'Pendaftar PPDB','singular_name'=>'Pendaftar'),'public'=>false,'show_ui'=>true,'show_in_menu'=>true,'menu_icon'=>'dashicons-forms','supports'=>array('title','editor'),'capability_type'=>'post','map_meta_cap'=>true));
}
add_action('init','alaqsha_register_content_types');
function alaqsha_ppdb_shortcode(){
 $msg='';
 if(isset($_POST['aaq_ppdb_submit'])){
  if(!isset($_POST['aaq_ppdb_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['aaq_ppdb_nonce'])),'aaq_ppdb_submit')) {
   $msg='<p class="notice">Permintaan tidak dapat diverifikasi. Silakan muat ulang halaman.</p>';
  } else {
   $nama=sanitize_text_field(wp_unslash($_POST['nama'] ?? ''));
   $wali=sanitize_text_field(wp_unslash($_POST['wali'] ?? ''));
   $email=sanitize_email(wp_unslash($_POST['email'] ?? ''));
   $telepon=sanitize_text_field(wp_unslash($_POST['telepon'] ?? ''));
   $program=sanitize_text_field(wp_unslash($_POST['program'] ?? ''));
   $alamat=sanitize_textarea_field(wp_unslash($_POST['alamat'] ?? ''));
   if(!$nama || !$wali || !$telepon || !$program){
    $msg='<p class="notice">Mohon lengkapi nama calon santri, nama wali, nomor telepon, dan program.</p>';
   } else {
    $id=wp_insert_post(array('post_type'=>'aaq_ppdb_entry','post_status'=>'private','post_title'=>'Pendaftar - '.$nama,'post_content'=>"Nama calon santri: $nama\nNama wali: $wali\nEmail: $email\nTelepon: $telepon\nProgram: $program\nAlamat: $alamat"));
    if(!is_wp_error($id)){
      update_post_meta($id,'aaq_ppdb_program',$program);
      $msg='<p class="notice">Terima kasih. Data pendaftaran telah diterima. Admin pesantren akan menindaklanjuti sesuai prosedur.</p>';
    } else $msg='<p class="notice">Pendaftaran belum dapat disimpan. Silakan hubungi pengelola.</p>';
   }
  }
 }
 ob_start(); echo wp_kses_post($msg); ?>
 <form method="post" class="aaq-ppdb-form">
 <?php wp_nonce_field('aaq_ppdb_submit','aaq_ppdb_nonce'); ?>
 <label>Nama calon santri *<input name="nama" required maxlength="120"></label>
 <label>Nama orang tua/wali *<input name="wali" required maxlength="120"></label>
 <label>Email (opsional)<input name="email" type="email" maxlength="150"></label>
 <label>Nomor telepon/WhatsApp *<input name="telepon" required maxlength="40"></label>
 <label>Program/jenjang yang diminati *<select name="program" required><option value="">Pilih program</option><option value="Belum ditentukan">Belum ditentukan / konfirmasi admin</option></select></label>
 <label>Alamat (opsional)<textarea name="alamat" rows="3" maxlength="1000"></textarea></label>
 <p><small>Dengan mengirim formulir, Anda menyetujui data digunakan oleh pengelola pesantren untuk menindaklanjuti pendaftaran. Tambahkan kebijakan privasi sebelum website dipublikasikan.</small></p>
 <button type="submit" name="aaq_ppdb_submit" value="1">Kirim pendaftaran</button>
 </form>
 <?php return ob_get_clean();
}
add_shortcode('al_aqsha_ppdb','alaqsha_ppdb_shortcode');
