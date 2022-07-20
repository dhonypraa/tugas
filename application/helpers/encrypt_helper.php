<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function encryptAES_vigenere($data)
{
    $CI = &get_instance();
    $CI->load->library(
        array('vigenere', 'AES')
    );

    $aes = new AesCtr();
    $data = $aes->encrypt($CI->vigenere->encrypt(ucfirst($data),$CI->config->item('kunci1')), $CI->config->item('kunci2'), 128);

    return $data;
}

function decryptAES_vigenere($data)
{
    $CI = &get_instance();
    $CI->load->library(
        array('vigenere', 'AES')
    );

    $aes = new AesCtr();
    $data = $CI->vigenere->decrypt(ucfirst($aes->decrypt($data, $CI->config->item('kunci2'), 128)),$CI->config->item('kunci1'));

    return $data;
}