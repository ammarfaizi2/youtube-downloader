<?php

file_put_contents("halt_compiler", file_get_contents("youtube-dl"), LOCK_EX | FILE_APPEND);
