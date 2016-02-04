#! /bin/sh

for f in *; do
    if [ "$f" != "old" ] ; then
        if [[ -d $f ]]; then
            echo $f is a directory
	    rm $f.zip
	    zip -r $f.zip $f
        fi
    fi
done
