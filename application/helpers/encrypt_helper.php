<?php

function encryptAES_vigenere($data)
{
	$CI = &get_instance();
	$CI->load->library(
		array('vigenere', 'AES')
	);

	$aes = new AesCtr();
	$_data = $aes->encrypt($CI->vigenere->encrypt(ucfirst($data), $CI->config->item('kunci1')), $CI->config->item('kunci2'), 128);

	return $_data;
}

function decryptAES_vigenere($data)
{
	$CI = &get_instance();
	$CI->load->library(
		array('vigenere', 'AES')
	);

	$aes = new AesCtr();
	$_data = $CI->vigenere->decrypt(ucfirst($aes->decrypt($data, $CI->config->item('kunci2'), 128)), $CI->config->item('kunci1'));

	return $_data;
}
