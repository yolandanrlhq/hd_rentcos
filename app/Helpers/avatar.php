<?php

if (!function_exists('avatarInitials')) {
    function avatarInitials($name)
    {
        $words = explode(' ', trim($name));

        if (count($words) >= 2) {
            return strtoupper(
                substr($words[0], 0, 1) .
                substr($words[1], 0, 1)
            );
        }

        return strtoupper(substr($name, 0, 2));
    }
}

if (!function_exists('avatarColor')) {
    function avatarColor($name)
    {
        $hash = md5($name);

        // ambil 6 karakter → warna HEX
        return '#' . substr($hash, 0, 6);
    }
}
