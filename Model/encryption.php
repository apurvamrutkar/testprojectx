<?php

//echo password_encrypt("0000");

function password_encrypt($password) {
    //hashing algorithm - blowfish
    $hash_format = "$2y$10$";

    //salt length has to be 22 for blowfish
    $salt_length = 22;

    $salt = generate_salt($salt_length);
    $format_and_salt = $hash_format . $salt;
    $hashed_password = crypt($password, $format_and_salt);

    return $hashed_password;
}

function generate_salt($salt_length)
{
    $salt = mcrypt_create_iv($salt_length, MCRYPT_DEV_URANDOM);
    $salt = base64_encode($salt);
    $salt = str_replace('+', '.', $salt);

    return $salt;
}

function password_check($password, $existing_hash)
{
    $hash = crypt($password, $existing_hash);

    if ($hash === $existing_hash)
    {
        return true;
    }
    else
    {
        return false;
    }
}
?>
