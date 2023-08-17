#! /bin/bash
for d in */ ; do
    echo "$d"
      echo $d.htaccess
  cat > $d.htaccess << END
RewriteEngine on
RewriteRule ^ ../download.txt [L]
END
done

