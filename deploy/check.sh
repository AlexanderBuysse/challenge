#!/bin/sh
set -eu
find index.php view -name '*.php' -exec sh -c 'for file do php -l "$file" || exit 1; done' sh {} +
php -r '$_GET = ["page" => "feed", "sort" => "time"]; require "index.php";' | grep -Fq 'Baking Crown'
php -r '$_GET = ["page" => "feed", "choice" => "video", "id" => 4]; require "index.php";' | grep -Fq 'assets/demo/moelleux.mp4'
php -r '$_SERVER["REQUEST_METHOD"] = "POST"; require "index.php";' | grep -Fq 'This action is disabled.'
test -s assets/demo/moelleux.mp4
test -s css/style.css
