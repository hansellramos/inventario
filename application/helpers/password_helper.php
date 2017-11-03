<?php

function generate_password($str) {
    return md5(md5($str));
}
